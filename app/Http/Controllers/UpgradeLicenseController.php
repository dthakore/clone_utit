<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Helpers\OrderHelper;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use App\Models\OrderLineItem;
use App\Models\OrderPayment;
use App\Models\Subscription;
use App\Models\Allwallettransaction;
use App\Models\Cart;
use App\Mail\Orderplaced;
use Illuminate\Support\Facades\Mail;
use \Mpdf\Mpdf as PDF;
use Gate;
use Illuminate\Http\Request;
use Stripe;

class UpgradeLicenseController extends Controller
{
    //
    public function checkout(Request $request)
    {
        $user_id = base64_decode($request->id);
        $user = User::where(['id' => base64_decode($request->id)])->first();
        $carts = Cart::where(['user_id' => base64_decode($request->id)])->get();
        $products = array();
        foreach ($carts as $cart){
            $mainProduct = Product::with(['category', 'media'])->where('id', $cart->product_id)->first();
            if(isset($mainProduct->media) && count($mainProduct->media) > 0){
                $imageArr = $mainProduct->media[0]->getAttributes();
                $image_file = $imageArr['file_name'];
                $folder = $imageArr['id'];
            }else{
                $image_file = '#';
                $folder = '#';
            }
            $product = array(
                'name' => $mainProduct->name,
                'sku' => $mainProduct->sku,
                'id' => $cart->product_id,
                'image' => $folder . '/' . $image_file,
                'cart_id' => $cart->cart_id,
            );
            if($mainProduct->sku == "NTTP1"){
                $product['main_product'] = 0;
                $product['qty'] = 1;
                $product['bot'] = $cart->product_qty;
                $product['comment'] =  'for '.$cart->product_qty.' bots';
                $product['price'] = $cart->product_price;
                $product['subtotal'] = $cart->product_price;
            }
            else{
                $product['comment'] = '';
                $product['main_product'] = 1;
                $product['qty'] = $cart->product_qty;
                $product['bot'] = 0;
                if($mainProduct->sku == "cbm_cashback"){
                    $product['price'] = $cart->product_price;
                    $product['subtotal'] = $cart->product_price * $cart->product_qty;
                }
                else{
                    $product['price'] = $mainProduct->price;
                    $product['subtotal'] = $mainProduct->price * $cart->product_qty;
                }
            }
            array_push($products, $product);
        }
        $subtotal = 0;
        foreach ($products as $p){
            $subtotal += $p['subtotal'];
        }
        $order_total = [
            'subtotal' => $subtotal,
            'Vat' => round($subtotal * 0.21,2),
            'grand_total' => round($subtotal * 0.21 + $subtotal,2),
        ];
        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $bank_transfer = Payment::where('id','=',1)->first();
        $stripe = Payment::where('id','=',2)->first();
        return view('frontend.upgradePlatform.billing', ['products' => $products, 'order_total' => $order_total,'countries'=>$countries,'user'=>$user,'bank_transfer'=>$bank_transfer,'stripe'=>$stripe,'user_id'=>$user_id]);
    }

    public function show(Request $request)
    {
        $orderInfo = Order::where('order',$request->id)->first();

        return view('frontend.upgradePlatform.show', ['orderId' => $request->id,'orderInfo'=>$orderInfo]);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $res = null;
            //dd($request->stripeToken);

            // dd($res);
            $user = User::find($request->user_id);
            $order = new Order;
            $order->user_id = $user->id;
            $order->user_name = $user->name;
            $order->email = $request->email;
            $order->building = $request->building;
            $order->street = $request->street;
            $order->company = $request->company;
            $order->vat_number = $request->vat_number;
            $order->region = $request->region;
            $order->postcode = $request->postcode;
            $order->city = $request->city;
            $order->country_id = $request->country_id;
            if($request->billing_info == 1){
                $order->address_type = 'Personal';
            }
            if($request->billing_info == 2){
                $order->address_type = 'Business';
            }
            //Get Latest order ID
            $orders = Order::orderBy('id', 'DESC')->first();
            if (!isset($orders)) {
                $order->order = 1;
            } else {
                $order->order = $orders->order + 1;
            }
            $products = json_decode($request->products, true);

            $payment = Payment::find($request->payment_mode);
            if (isset($payment) && strtolower($payment->type) == 'bank transfer') {
                $request->payment_status = 0;
                $order->order_status = 5;
            }else{
                $order->order_status = 2;
            }

            $request->vat_percentage = 21;
            $order->vat_percentage = 21;
            $order->order_total = 0;
            $order->net_total = 0;
            $order->created_at = now();
            if($request->payment_mode == 2 && (isset($request->payment_intent) ||  isset($request->stripeToken) ) ){
                // generate Invoice
                $invoice_number = OrderHelper::getInvoiceNumber();
                $order->invoice_number = $invoice_number;
                $orderInvoice = new Invoice();
                $orderInvoice->order_id = $order->order;
                $orderInvoice->invoice_number = $invoice_number;
                $orderInvoice->invoice_date = now();
                $orderInvoice->vat = $order->vat;
                $orderInvoice->vat_percentage = $order->vat_percentage;
                $orderInvoice->vat_number = $order->vat_number;
                $orderInvoice->company = $order->company;
                $orderInvoice->building = $order->building;
                $orderInvoice->street = $order->street;
                $orderInvoice->region = $order->region;
                $orderInvoice->postcode = $order->postcode;
                $orderInvoice->city = $order->city;
                $orderInvoice->order_total = $order->order_total;
                $orderInvoice->discount = $order->discount;
                $orderInvoice->net_total = $order->net_total;
                $orderInvoice->user_name = $order->user_name;
                $orderInvoice->email = $order->email;
                $orderInvoice->created_at = date('Y-m-d H:i:s');
                $orderInvoice->updated_at = date('Y-m-d H:i:s');

                $orderInvoice->save();
            }
            if ($order->save()) {

                Cart::where(['user_id' => $request->user_id])->delete();
                //save order line item
                foreach ($products as $p) {
                    $product = Product::where(['id' => $p['id']])->first();

                    if($product->level_one_affiliate != 0.00 && (!is_null($user->sponsor_id))){
                        $wallet = new Allwallettransaction;
                        $wallet->user_id = $user->sponsor_id;
                        $wallet->wallet_type_id = 1;
                        $wallet->reference_id = 14;
                        $wallet->denomination_id = 1;
                        $wallet->reference_num = $order->order;
                        $wallet->transaction_type = 1;
                        $wallet->transaction_comment = "Affiliate Commission for Level 1 from order: ".$order->order;
                        $wallet->transaction_status = 3;
                        $wallet->amount = $product->level_one_affiliate;
                        $wallet->created_at = now();
                        $wallet->save();
                    }
                    if(!is_null($user->sponsor_id)){
                        $sponsor2 = User::find($user->sponsor_id);
                        if($product->level_two_affiliate != 0.00 && (!is_null($sponsor2->sponsor_id))){
                            $wallet = new Allwallettransaction;
                            $wallet->user_id = $sponsor2->sponsor_id;
                            $wallet->wallet_type_id = 1;
                            $wallet->reference_id = 14;
                            $wallet->denomination_id = 1;
                            $wallet->reference_num = $order->order;
                            $wallet->transaction_type = 1;
                            $wallet->transaction_comment = "Affiliate Commission for Level 2 from order: ".$order->order;
                            $wallet->transaction_status = 3;
                            $wallet->amount = $product->level_two_affiliate;
                            $wallet->created_at = now();
                            $wallet->save();
                        }
                    }
                    $orderLineItem = new OrderLineItem;
                    $orderLineItem->order_id = $order->id;
                    $orderLineItem->product_id = $p['id'];
                    $orderLineItem->product_name = $p['name'];
                    $orderLineItem->item_qty = $p['qty'];
                    $orderLineItem->item_disc = 0;
                    $orderLineItem->item_price = $p['price'];
                    $orderLineItem->comment = $p['comment'];
                    $orderLineItem->product_sku = $p['sku'];
                    $orderLineItem->created_at = now();
                    $orderLineItem->save();
                    $item_price[] = $p['price'];
                    $item_qty[] = $p['qty'];
                    $item_desc[] = 0;
                    $ids[] = $p['id'];
                    if($product->is_subscription_enabled == 1){
                        if($p['sku'] == "NTBOT"){
                            $orderLineItem->cycle_ends_at = date('Y-m-d 23:59:59', strtotime('+1 year'));
                            $orderLineItem->save();
                            for ($i=0; $i < $p['qty']; $i++){
                                $bytes = random_bytes(20);
                                $subscription = new Subscription;
                                $subscription->order_id = $order->order;
                                $subscription->licence_key = bin2hex($bytes);
                                $subscription->product_id = $orderLineItem->product_id;
                                $subscription->user_id = $request->user_id;
                                $subscription->status = 'active';
                                $subscription->cycle_start_at = date('Y-m-d H:i:s');
                                $subscription->cycle_end_at = date('Y-m-d 23:59:59', strtotime('+1 year'));
                                $subscription->created_at = date('Y-m-d H:i:s');
                                $subscription->updated_at = date('Y-m-d H:i:s');
                                $subscription->save();
                            }
                        }
                        elseif($p['sku'] == "NTTP1"){
                            $orderLineItem->cycle_ends_at = date('Y-m-d 23:59:59', strtotime('+1 year'));
                            $orderLineItem->save();
                            $is_subscription = Subscription::where(['product_id' => $p['id'], 'user_id' => $request->user_id])->first();
                            if(is_null($is_subscription)){
                                $bytes = random_bytes(20);
                                $subscription = new Subscription;
                                $subscription->order_id = $order->order;
                                $subscription->licence_key = bin2hex($bytes);
                                $subscription->product_id = $orderLineItem->product_id;
                                $subscription->user_id = $request->user_id;
                                $subscription->status = 'active';
                                $subscription->cycle_start_at = date('Y-m-d H:i:s');
                                $subscription->cycle_end_at = $orderLineItem->cycle_ends_at;
                                $subscription->created_at = date('Y-m-d H:i:s');
                                $subscription->updated_at = date('Y-m-d H:i:s');
                                $subscription->save();
                            }

                        }

                    }
                }
                $orderItem = [
                    "item_qty" => $item_qty,
                    "item_desc" => $item_qty,
                    "item_price" => $item_price,
                ];
                // Order All item price,discount,total,net total
                $totalArray = $this->getOrderAllTotal($orderItem);
                $order->vat = ($totalArray['orderTotal'] * $order->vat_percentage) / 100;

                $net_total = round($totalArray['orderTotal'] - $totalArray['orderDiscount'] + $order->vat,2);
                //dd((int)$net_total);
                if($request->payment_mode == 2 && isset($request->stripeToken)){
                    Stripe\Stripe::setApiKey(config('app.STRIPE_SECRET'));
                    $res = Stripe\Charge::create ([
                        "amount" => (int) ($net_total * 100),
                        "currency" => "eur",
                        "source" => $request->stripeToken,
                        "description" => "Make payment and chill."
                    ]);
                }

                //update Order Total
                Order::find($order->id)->update([
                    'order_total'   => $totalArray['orderTotal'],
                    'discount'      => $totalArray['orderDiscount'],
                    'net_total'     => $net_total,
                    'vat' => round($order->vat,2)]);
                //dd($order->id);
                $payment = Payment::find($request->payment_mode);
                //save order payment
                $orderPayment = new OrderPayment;
                // dd($order->id);
                $orderPayment->order_id = $order->id;
                $orderPayment->total = $net_total;
                $orderPayment->payment_mode = $payment->id;
                if($request->payment_mode == 2 && isset($request->stripeToken)){
                    $orderPayment->payment_ref_id = $request->stripeToken;
                    $orderPayment->payment_comment = json_encode([
                        'stripeToken' => $request->stripeToken,
                        'type' => 'card'
                    ]);
                }
                if($request->payment_mode == 2 && isset($request->payment_intent)){
                    $orderPayment->payment_comment = json_encode([
                        'payment_intent' => $request->payment_intent,
                        'payment_intent_client_secret' => $request->payment_intent_client_secret,
                        'type' => $request->payment_method_types
                    ]);
                    $orderPayment->payment_ref_id = $request->payment_intent;
                }
                //            $orderPayment->payment_ref_id = $request->payment_ref_id;
                //            $orderPayment->payment_date = $request->payment_date;
                $orderPayment->payment_status = $request->payment_status;
                $orderPayment->transaction_mode = $payment->type;
                $orderPayment->denomination_id = 1;
                $orderPayment->payment_date = now();
                $orderPayment->created_at = now();
                $orderPayment->save();
                $order->products()->sync($ids);

                if($orderPayment->payment_status == 2){
                    $orderLineItems = OrderLineItem::where('order_id',$order->id)->get();
                    Mail::to($order->email)->send(new Orderplaced($order, $orderLineItems, $orderPayment,$totalArray['orderTotal'],$net_total));
                }

                // dd($order->order);
                return json_encode(['result' => 1, 'message' => 'success', 'orderId' => $order->order]);
            } else {
                return json_encode(['result' => 0, 'message' => 'error']);
            }
        } catch(\Stripe\Exception\CardException $e) {
            return json_encode(['result' => 0, 'message' => $e->getError()->message]);
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            // echo 'Status is:' . $e->getHttpStatus() . '\n';
            // echo 'Type is:' . $e->getError()->type . '\n';
            // echo 'Code is:' . $e->getError()->code . '\n';
            // // param is '' in this case
            // echo 'Param is:' . $e->getError()->param . '\n';
            // echo 'Message is:' . $e->getError()->message . '\n';
        } catch (\Stripe\Exception\RateLimitException $e) {
            return json_encode(['result' => 0, 'message' => $e->getError()->message]);
            // Too many requests made to the API too quickly
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return json_encode(['result' => 0, 'message' => $e->getError()->message]);
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return json_encode(['result' => 0, 'message' =>$e->getError()->message]);
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return json_encode(['result' => 0, 'message' => $e->getError()->message]);
            // Network communication with Stripe failed
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return json_encode(['result' => 0, 'message' => $e->getError()->message]);
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            return json_encode(['result' => 0, 'message' => $e->getError()->message]);
            // Something else happened, completely unrelated to Stripe
        }



    }

    /**
     * make total,net total and discount
     * @param $orderItemArray
     * @return array
     */
    protected function getOrderAllTotal($orderItemArray)
    {
        $itemPriceTotal = 0;
        $itemDiscTotal = 0;
        foreach ($orderItemArray['item_price'] as $key => $item) {
            if (!empty($orderItemArray['item_price'][$key]) && $orderItemArray['item_price'][$key] != '') {
                $itemPriceTotal += ($orderItemArray['item_price'][$key] * $orderItemArray['item_qty'][$key]);
            }
            if (!empty($orderItemArray['item_disc'][$key]) && $orderItemArray['item_disc'][$key] != '') {
                $itemDiscTotal += ($orderItemArray['item_disc'][$key] * $orderItemArray['item_qty'][$key]);
            } else {
                $itemDiscTotal += 0;
            }

        }
        $result = [
            'orderTotal' => $itemPriceTotal,
            'orderDiscount' => $itemDiscTotal,
        ];
        return $result;
    }
}
