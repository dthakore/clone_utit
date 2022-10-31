<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use Stripe;

class OrdersController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::with(['user', 'country', 'products'])->get();

        $users = User::get();

        $countries = Country::get();

        $products = Product::get();

        return view('frontend.orders.index', compact('orders', 'users', 'countries', 'products'));
    }

    public function list()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::with(['user', 'country', 'products'])->where(['user_id' => \Auth::id()])->orderBy('id', 'DESC')->get();

        $orderids = Order::where('user_id',auth()->user()->id)->pluck('id')->toArray();

        $total_cashback = OrderLineItem::where(['product_sku' => 'cbm_cashback'])->whereIn('order_id',$orderids)->sum('item_qty');
        $total_bot = OrderLineItem::where(['product_sku' => 'NTBOT'])->whereIn('order_id',$orderids)->sum('item_qty');
        $orderlineitem = OrderLineItem::where(['product_sku' => 'NTTP1'])->whereIn('order_id',$orderids)->orderBy('id', 'DESC')->first();
        if(isset($orderlineitem->comment) &&  !is_null($orderlineitem->comment)) {
            $bot = preg_replace('/\D/', '', $orderlineitem->comment);
        }
        else{
            $bot = "";
        }
//        dd($orders);
        return view('frontend.orders.list', compact('orders','total_cashback','total_bot','bot'));
    }

    public function detail(Request $request, $id)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order = Order::with(['user', 'country', 'products'])->where(['id' => $id])->first();
        $orderlineitems = \App\Models\OrderLineItem::where(['order_id' => $order->id])->get();
        $orderpayment = \App\Models\OrderPayment::where(['order_id' => $order->id])->first();
//        dd($orders);
        return view('frontend.orders.detail', compact('order', 'orderlineitems', 'orderpayment'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id');

        return view('frontend.orders.create', compact('users', 'countries', 'products'));
    }

    public function checkout()
    {
        $user = User::where(['id' => auth()->user()->id])->first();
        $carts = Cart::where(['user_id' => auth()->user()->id])->get();
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
        return view('frontend.orders.billing', ['products' => $products, 'order_total' => $order_total,'countries'=>$countries,'user'=>$user,'bank_transfer'=>$bank_transfer,'stripe'=>$stripe]);
    }

    public function addTradingInCart(Request $request)
    {
        $platform = explode('#', $request->bot_price);
        if(!empty($platform[0]) && ($platform[0] != "undefined")){
            $platform_product = Product::where('sku', 'NTTP1')->first();
            Cart::where(['user_id' => auth()->user()->id,'product_id' => $platform_product->id])->delete();
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $platform_product->id;
            $cart->product_qty = $platform[0];
            $cart->product_price = round($platform[1] - ($platform[1] * 21)/121,2);
            $cart->upgrade = 1;
            $cart->created_at = now();
            $cart->save();
        }
        return redirect('cart');
    }

    public function addCart(Request $request)
    {
        $token = $request->id;
        $token = base64_decode($token);
        $requestArr = explode('$', $token);
//        dd($requestArr);
        $id = $requestArr[0]; //Product Id
        $qty = $requestArr[1]; //Product Qty
        $price = $requestArr[2]; //Product Total Price
        $productReplace = str_replace(",",".",$price);
        // dd($product);
        $platform = explode('#', $requestArr[3]);
//        dd($platform);
//        Cart::where(['user_id' => auth()->user()->id])->delete();
        if(!is_null($id) && !is_null($qty)){
            $cashback = Product::where('sku', 'cbm_cashback')->first();
            $product = Product::where('id', $id)->first();
            $cart = Cart::where(['user_id' => auth()->user()->id,'product_id' => $id])->first();
            if(isset($cashback) && $cashback->id == $id){
                $product->price = round($productReplace/$qty - ($productReplace/$qty * 21)/121,2);
            }
            if(is_null($cart)){
                $cart = new Cart;
                $cart->product_qty = $qty;
                $cart->user_id = auth()->user()->id;
                $cart->product_id = $id;
                $cart->product_price = $product->price;
                $cart->created_at = now();
                $cart->save();
            }
            else{
                $input['product_qty'] = $cart->product_qty + $qty;
                $input['product_price'] = $product->price;
                $input['updated_at'] = now();
                Cart::where(['cart_id' => $cart->cart_id])->update($input);
            }

        }
        if(!empty($platform[0]) && ($platform[0] != "undefined")){
            $platform_product = Product::where('sku', 'NTTP1')->first();
            Cart::where(['user_id' => auth()->user()->id,'product_id' => $platform_product->id])->delete();
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $platform_product->id;
            $cart->product_qty = $platform[0];
            $cart->product_price =  round($platform[1] - ($platform[1] * 21)/121,2);
            $cart->created_at = now();
            $cart->save();
        }
        return redirect('cart');
    }

    public function cart(){
        $carts = Cart::where(['user_id' => auth()->user()->id])->get();
        $cashback = Product::where('sku', 'cbm_cashback')->first();
        $platform = Product::where('sku', 'NTTP1')->first();
        if(!empty($cashback->id)){
            $cashback_product = $cashback->id;
        }
        else{
            $cashback_product = 0;
        }
        $platform_product = 0;
        if(!empty($platform->id)){
            $platform_cart = Cart::where(['user_id' => auth()->user()->id,'product_id'=>$platform->id])->first();
            if(!empty($platform_cart->cart_id)){
                $platform_product = $platform_cart->cart_id;
            }
        }
        $products = array();
        $bot_id = 0;
        $cashback_id = 0;
        $order_total = [
            'subtotal' => 0,
            'vat' => 0,
            'grand_total' => 0,
        ];
        $upgrade = 0;
        foreach ($carts as $cart){
            $mainProduct = Product::where('id', $cart->product_id)->first();
            $product = array(
                'name' => $mainProduct->name,
                'sku' => $mainProduct->sku,
                'id' => $cart->product_id,
                'cart_id' => $cart->cart_id,
            );
            if($mainProduct->sku == "NTTP1"){
                $product['main_product'] = 0;
                $product['qty'] = 1;
                $product['bot'] = $cart->product_qty;
                $product['price'] = $cart->product_price;
                $product['subtotal'] = $cart->product_price;
                if($cart->upgrade == 1){
                    $upgrade = 1;
                }
            }
            else{
                $product['main_product'] = 1;
                $product['qty'] = $cart->product_qty;
                $product['bot'] = 0;
                if($mainProduct->sku == "cbm_cashback"){
                    $cashback_id = $cart->cart_id;
                    $product['price'] = $cart->product_price;
                    $product['subtotal'] = $cart->product_price * $cart->product_qty;
                }
                else{
                    $bot_id = $cart->product_id;
                    $product['price'] = (float)$mainProduct->price;
                    $product['subtotal'] = $mainProduct->price * $cart->product_qty;
                }
            }
            array_push($products, $product);
            $subtotal = 0;
            foreach ($products as $p){
                $subtotal += $p['subtotal'];
            }
            $order_total = [
                'subtotal' => $subtotal,
                'vat' => round($subtotal * 0.21,2),
                'grand_total' => round($subtotal * 0.21 + $subtotal,2),
            ];
        }
        if($upgrade == 1){
            $final_price = $this->fetchPlatformRemainingDaysPrice();
        }
        else{
            $final_price = [
                3 => 43.496,
                8 => 75.49,
                15 => 130,
                35 => 259
            ];
        }
        return view('frontend.orders.cart', ['carts' => $carts,'products' => $products,'order_total' => $order_total,'bot_id' => $bot_id,'cashback_id' => $cashback_id,'cashback_product' => $cashback_product,'platform_product' => $platform_product,'upgrade' => $upgrade,'final_price' => $final_price]);
    }

    public function fetchCart(){
        $carts = Cart::where(['user_id' => auth()->user()->id])->get();
        $products = array();
        $bot_id = 0;
        $cashback_id = 0;
        $order_total = [
            'subtotal' => 0,
            'vat' => 0,
            'grand_total' => 0,
        ];
        foreach ($carts as $cart){
            $mainProduct = Product::where('id', $cart->product_id)->first();
            $product = array(
                'name' => $mainProduct->name,
                'sku' => $mainProduct->sku,
                'id' => $cart->product_id,
                'cart_id' => $cart->cart_id,
            );
            if($mainProduct->sku != "NTTP1"){
                $bot_id = $cart->product_id;
                $product['main_product'] = 1;
                $product['qty'] = $cart->product_qty;
                $product['bot'] = 0;
                if($mainProduct->sku == "cbm_cashback"){
                    $cashback_id = $cart->cart_id;
                    $product['price'] = $cart->product_price;
                    $product['subtotal'] = $cart->product_price * $cart->product_qty;
                }
                else{
                    $product['price'] = $mainProduct->price;
                    $product['subtotal'] = $mainProduct->price * $cart->product_qty;
                }
            }
            else{
                $product['main_product'] = 0;
                $product['qty'] = 1;
                $product['bot'] = $cart->product_qty;
                $product['price'] = $cart->product_price;
                $product['subtotal'] = $cart->product_price;
            }
            array_push($products, $product);
            $subtotal = 0;
            foreach ($products as $p){
                $subtotal += $p['subtotal'];
            }
            $order_total = [
                'subtotal' => $subtotal ,
                'vat' => $subtotal * 0.21,
                'grand_total' => $subtotal * 0.21 + $subtotal,
            ];
        }
        $data['carts'] = $carts;
        $data['products'] = $products;
        $data['order_total'] = $order_total;
        $data['cashback_id'] = $cashback_id;
        $data['bot_id'] = $bot_id;

        return $data;
    }

    public function updateCart(Request $request){
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $cashback_id = 0;
        $cashback_product = 0;
        $cashback = Product::where('sku', 'cbm_cashback')->first();
        $platform = Product::where('sku', 'NTTP1')->first();
        if(!empty($cashback->id)){
            $cashback_product = $cashback->id;
        }
        $upgrade = 0;
        $platform_product = 0;
        if(!empty($platform->id)){
            $platform_cart = Cart::where(['user_id' => auth()->user()->id,'product_id'=>$platform->id])->first();
            if(!empty($platform_cart->cart_id)){
                $platform_product = $platform_cart->cart_id;
            }
        }
        $bot_product = Product::where('sku', 'NTBOT')->first();
        foreach ($carts as $cart){
            if(($cart->product_id == $bot_product->id) && isset($request->bot_qty) && isset($request->bot_id)){
                $input['product_qty'] = $request->bot_qty;
                $input['product_price'] = $bot_product->price * $input['product_qty'];
                $input['updated_at'] = now();
                Cart::where(['cart_id' => $cart->cart_id])->update($input);
            }
            elseif(($cart->product_id == $platform->id) && isset($request->platform)){
                $platform = explode('#', $request->platform);
                $input['product_qty'] = $platform[0];
                $input['product_price'] = round($platform[1] - ($platform[1] * 21)/121,2);
                $input['updated_at'] = now();
                if($cart->upgrade == 1){
                    $upgrade = 1;
                }
                Cart::where(['cart_id' => $cart->cart_id])->update($input);
            }
            if($cart->product_id == $cashback->id){
                $cashback_id = $cart->cart_id;
            }
        }
        if($upgrade == 1){
            $final_price = $this->fetchPlatformRemainingDaysPrice();
        }
        else{
            $final_price = [
                3 => 43.496,
                8 => 75.49,
                15 => 130,
                35 => 259
            ];
        }
        $data = $this->fetchCart();
        $total_qty = Cart::where(['user_id' => auth()->user()->id])->sum('product_qty');
        if(!empty($platform_cart->cart_id)){
            $total_qty = $total_qty - $platform_cart->product_qty + 1;
        }
        $view = view('frontend.orders.cart-data', ['carts' => $data['carts'],'products' => $data['products'],'order_total' => $data['order_total'],'bot_id' => $data['bot_id'],'cashback_id' => $cashback_id,'cashback_product' => $cashback_product,'platform_product' => $platform_product,'upgrade' => $upgrade,'final_price' => $final_price]);
        $view = $view->render();

        echo json_encode([
            'token' => 1,
            'cashback_id' => $cashback_id,
            'total_qty' => $total_qty,
            'data'=> $view
        ]);die;
    }

    public function deleteCart(Request $request){
        Cart::where('cart_id',$request->id)->delete();

        $platform_product = Product::where('sku', 'NTTP1')->first();

        if($request->sku == "NTBOT"){
            Cart::where(['product_id' => $platform_product->id,'user_id' => auth()->user()->id ,'upgrade' => 0])->delete();
        }
        $data = $this->fetchCart();
        $total_qty = Cart::where(['user_id' => auth()->user()->id])->sum('product_qty');
        if(!empty($platform_product->id)) {
            $platform_cart = Cart::where(['user_id' => auth()->user()->id, 'product_id' => $platform_product->id])->first();
            if (!empty($platform_cart->cart_id)) {
                $total_qty = $total_qty - $platform_cart->product_qty + 1;
            }
        }

        return response()->json([
            "token" => 1,
            "message" => "Product removed from cart",
            'total_qty' => $total_qty,
            'cashback_id' => $data['cashback_id'],
            "order_total" => $data['order_total']
        ]);
    }

    /*
     * Function for fetch remaining days price for trading platform upgrade flaw
     */
    public function fetchPlatformRemainingDaysPrice(){
        $orders = Order::where('user_id',auth()->user()->id)->pluck('id')->toArray();
        $bot = 0;
        $price = [
            3 => 43.496,
            8 => 75.49,
            15 => 130,
            35 => 259
        ];
        $final_price = [];
        if(count($orders)>0){
            $orderlineitem = OrderLineItem::where(['product_sku' => 'NTTP1'])->whereIn('order_id',$orders)->orderBy('id', 'DESC')->first();
            if(!is_null($orderlineitem->comment)) {
                $bot = preg_replace('/\D/', '', $orderlineitem->comment);
            }
            $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
            $platform = Subscription::where(['user_id' => auth()->user()->id ,'product_id' => $platform_product_id->id])->first();
            if(($bot > 0) && isset($platform->cycle_end_at) && !empty($platform->cycle_end_at) && ($platform->cycle_end_at > date('Y-m-d H:i:s'))){
                $remaining_days = date_diff(date_create($platform->cycle_end_at),date_create(now()))->format('%a');
                foreach ($price as $key=>$value){
                    if($key == $bot){
                        $platform_price = $value;
                    }
                    if($key > $bot){
                        $final_price[$key] = round(($value - $platform_price) * $remaining_days / 365,2);
                    }
                }
            }
            else{
                $final_price = $price;
            }
        }

        return $final_price;
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

                Cart::where(['user_id' => auth()->user()->id])->delete();
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

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id');

        $order->load('user', 'country', 'products');

        return view('frontend.orders.edit', compact('users', 'countries', 'products', 'order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        $order->products()->sync($request->input('products', []));

        return redirect()->route('frontend.orders.index');
    }

    public function show(Request $request)
    {
        $orderInfo = Order::where('order',$request->id)->first();

        return view('frontend.orders.show', ['orderId' => $request->id,'orderInfo'=>$orderInfo]);
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function license()
    {
        $subscriptions = Subscription::where(['user_id' => auth()->user()->id])->orderBy('order_id', 'DESC')->get();
        return view('frontend.license.license',compact('subscriptions'));
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

    public function generateInvoice(Request $request)
    {
        $id = $request->id;
        $invoice = Invoice::where('invoice_number',$id)->first();
        $orderInfo = Order::where('order',$invoice->order_id)->first();
        if($orderInfo->user_id != auth()->user()->id){
            abort(404);
        }
        $order_payment = OrderPayment::where('order_id',$orderInfo->id)->first();
        $orderLineItems = OrderLineItem::where('order_id',$orderInfo->id)->get();

        $payment_method = $order_payment->transaction_mode;
        if('Stripe' === $order_payment->transaction_mode ){
            $json = json_decode($order_payment->payment_comment);
            $payment_method = "Paid by ".$json->type;
        }
        $data =[
            'orderInfo'=>$orderInfo,
            'orderPayment'=>$order_payment,
            'orderLineitem'=>$orderLineItems,
            'payment_method'=>$payment_method,
            'invoice'=>$invoice
        ];

        $documentFileName = "Invoice_".$id.".pdf";

        // Create the mPDF document
        $document = new PDF([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '10',
            'margin_bottom' => '10',
            'margin_footer' => '2',
        ]);

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"'
        ];

        // Write some simple Content
        //$document->WriteHTML($html);
        // Use Blade if you want
        $document->WriteHTML(view('frontend.invoice',['data'=>$data]));

        // Save PDF on your public storage
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));

        // Get file back from storage with the give header informations
        return Storage::disk('public')->download($documentFileName, 'Request', $header); //

    }

    public function generateLicense(Request $request)
    {
        $platform_product_id = Product::where(['sku' => 'NTTP1'])->first();
        if($platform_product_id->id == (int)$request->product_id){
            $subscriptions = \App\Models\Subscription::where(['user_id' => (int)$request->user_id,'product_id' => (int)$request->product_id])->get();
        }
        else{
            $subscriptions = \App\Models\Subscription::where(['order_id' => (int)$request->order_id,'product_id' => (int)$request->product_id])->get();
        }
        $licenses = "";
        foreach($subscriptions as $subscription){
            $licenses .= $subscription->licence_key;
            $licenses .= "\n";
        }
        $response = new StreamedResponse();
        $response->setCallBack(function () use($licenses) {
            echo $licenses;
        });
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'license_key.txt');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
