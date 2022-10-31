<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Country;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\OrderPayment;
use App\Models\Invoice;
use App\Models\ProductAffiliate;
use App\Models\CbmOrderLicenses;
use App\Models\CbmMtFourAccount;
use Gate;
use Illuminate\Http\Request;
use Mpdf\Tag\Sub;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\OrderHelper;
use App\Helpers\WalletHelper;
use App\Helpers\BinaryTreeHelper;
use App\Helpers\ServiceHelper;
use App\Helpers\MatrixHelper;
use App\Helpers\VoucherHelper;
use App\Models\Allwallettransaction;

class OrdersController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $start = '';
            $end = '';
            $query = Order::with(['user', 'country', 'products'])->select(sprintf('%s.*', (new Order())->table));
            if ($request->has('user_name') && $request->get('user_name') != null) {
                $name = explode(" ~ ", $request->get('user_name'));
                $user_id = User::where("name", "like", "%{$name[0]}%")->pluck('id')->toArray();
                $query->whereIn("user_id", $user_id);
            }
            if ($request->has('sponsor') && $request->get('sponsor') != null) {
                $name = explode(" ~ ", $request->get('sponsor'));
                if(isset($name[1])){
                    $user = User::where("sponsor_id", $name[1])->pluck('id')->toArray();
                    $query->whereIn('user_id', $user);
                }else{
                    $query->where('user_id', "");
                }
            }
            if ($request->has('product') && $request->get('product') != null) {
                $order_id = OrderLineItem::where("product_id", $request->get('product'))->pluck('order_id')->toArray();
                $query->whereIn("id", $order_id);
            }
            if ($request->has('status') && $request->get('status') != null) {
                $query->where('order_status', $request->get('status'));
            }
            if($request->get('start_date') != null){
                $start = date('Y-m-d 00:00:00',strtotime($request->get('start_date')));
            }
            if($request->get('end_date') != null){
                $end = date('Y-m-d 23:59:59',strtotime($request->get('end_date')));
            }
            if ($start != '' && $end != '') {
                $query->whereBetween('created_at', [$start, $end]);
            } else if ($start != '') {
                $query->where("created_at", "like", "%{$start}%");
            }

            if ($request->has('invoice_number') && $request->get('invoice_number') != null) {
                $invoice = Invoice::where('invoice_number', "like", "%{$request->get('invoice_number')}%")->get();
                $invoice_order_ids = [];
                if(!empty($invoice)){
                    foreach ($invoice as $value){
                        array_push($invoice_order_ids,$value->order_id);
                    }
                }
                if(isset($invoice_order_ids)){
                    $query->whereIn('order', $invoice_order_ids);
                }else{
                    $query->where('order', "");
                }
            }
            if ($request->has('payment_method') && $request->get('payment_method') != null) {
                $payment = OrderPayment::where('transaction_mode', "like", "%{$request->get('payment_method')}%")->get();
                $order_ids = [];
                if(!empty($payment)){
                    foreach ($payment as $value){
                        array_push($order_ids,$value->order_id);
                    }
                }
                if(isset($order_ids)){
                    $query->whereIn('id', $order_ids);
                }else{
                    $query->where('id', "");
                }
            }
            $query->orderBy('id', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'order_show';
                $editGate = 'order_edit';
                $deleteGate = '';
                $crudRoutePart = 'orders';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('order', function ($row) {
                return $row->order ? $row->order : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });
            $table->addColumn('id', function ($row) {
                return $row->id;
            });
            $table->addColumn('user_id', function ($row) {
                return $row->user_id;
            });
            $table->addColumn('payment_method', function ($row) {
                $payment = OrderPayment::where('order_id', $row->id)->first();
                return isset($payment) ? $payment->transaction_mode : '';
            });
            $table->editColumn('order_status', function ($row) {
                return $row->order_status ? Order::ORDER_STATUS_SELECT[$row->order_status] : '';
            });
            $table->editColumn('order_origin', function ($row) {
                return $row->order_origin ? $row->order_origin : '';
            });
            $table->editColumn('net_total', function ($row) {
                return $row->net_total ? $row->net_total : '';
            });
            $table->addColumn('invoice_number', function ($row) {
                $invoice = Invoice::where('order_id', $row->order)->first();
                return isset($invoice) ? $invoice->invoice_number : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get();
        $countries = Country::get();
        $products = Product::get();

        return view('admin.orders.index', compact('users', 'countries', 'products'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment = Payment::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $product = Product::all();
        $productPrice = [];
        foreach ($product as $value) {
            $productPrice[$value['id']] = $value['price'];
        }

        return view('admin.orders.create', compact('users', 'countries', 'products', 'payment', 'productPrice'));
    }

    public function store(StoreOrderRequest $request)
    {
        $user = User::find($request->user_id);
        $order = new Order;
        $order->user_id = $user->id;
        $order->user_name = $user->name;
        $order->email = $user->email;
        $order->order_origin = 'Admin';
        $order->order_status = $request->order_status;
        $order->company = $user->company;

        if ($request->company == '') {
            $order->building = $user->building_num;
            $order->street = $user->street;
            $order->region = $user->region;
            $order->postcode = $user->postcode;
            $order->city = $user->city;
            $order->country_id = $user->country_id;
        } else {
            $order->building = $user->bus_address_building_num;
            $order->street = $user->bus_address_street;
            $order->region = $user->bus_address_region;
            $order->postcode = $user->bus_address_postcode;
            $order->city = $user->bus_address_city;
            $order->country_id = $user->bus_address_country_id;
        }

        /*if($request->order_status == 2){
            //Get Invoice Number
            $order->invoice_number = OrderHelper::getInvoiceNumber();
            $order->invoice_date = now();
            $convert = strtotime($order->invoice_date);
            $day = date("d", $convert);
            $month = date("m", $convert);
            $random = rand(1,9);
            $reverse = strrev($order->invoice_number);
            $fourDigit = substr($reverse,0,4);
            $orderComment = '+++'.$random.$day.'/'.$random.$month.$random.'/'.$random.$fourDigit.'+++';
            $order->order_comment = $orderComment;
        }else{
            $order->order_comment = $request->order_comment;
        }*/

        //Get Latest order ID
        $orders = Order::orderBy('id', 'DESC')->first();
        if (!isset($orders)) {
            $order->order = 1;
        } else {
            $order->order = $orders->order + 1;
        }
        session(['audit_log' => "(Admin)User ".auth()->id()." bought a package for user {$user->id}", 'audit_log_category' => "Package Purchase"]);

//        $orderItem = [
//            "item_qty" => array($request->item_qty),
//            "item_disc" => array($request->item_disc),
//            "item_price" => array($request->item_price),
//        ];
        // Order All item price,discount,total,net total
//        $totalArray = $this->getOrderAllTotal($orderItem);

        $order->vat_number = $request->vat_number;
        $order->vat = $request->vat;
        $order->country_id = $request->country_id;
        $order->company = $request->company;
        $order->vat_percentage = $request->vat_percent;
        $order->order_total = $request->order_total;
        $order->discount = $request->discount;
        $order->net_total = $request->net_total;
        $order->created_at = $request->created_at;
        if ($request->order_status == 2 && $order->net_total > 0) {
            //Get Invoice Number
            //Get Invoice Number
            if ($request->invoice_number == '') {
                $invoice_number = OrderHelper::getInvoiceNumber();;
            } else {
                $invoice_number = $request->invoice_number;
            }
            /*$convert = strtotime($order->invoice_date);*/
//            $invoice_number = OrderHelper::getInvoiceNumber();

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
            $subscription = Subscription::where('order_id', $order->order)->get()->first();
            if (!empty($subscription)) {
                $subscription = $subscription->toArray();
            } else {
                $subscription = [];
            }

            if (count($subscription) > 0) {
                $orderInvoice->subscription_id = $subscription['subscription_id'];
            }
            $orderInvoice->save();

            $convert = strtotime($orderInvoice->invoice_date);
            $day = date("d", $convert);
            $month = date("m", $convert);
            $random = rand(1, 9);
            $reverse = strrev($order->invoice_number);
            $fourDigit = substr($reverse, 0, 4);
            $orderComment = '';
            $order->order_comment = $orderComment;
        } else {
            $order->order_comment = $request->order_comment;
        }
        if ($order->save()) {
            //save order line item
            $prod = $request->products;
            $qty = $request->item_qty;
            $disc = $request->item_disc;
            $price = $request->item_price;
            if (!empty($prod)) {
                for ($i = 0; $i < count($prod); $i++) {
                    if (!empty($prod[$i])) {
                        $product = Product::where(['id' => $prod[$i]])->first();
                        if ($product->level_one_affiliate != 0.00 && (!is_null($user->sponsor_id))) {
                            $wallet = new Allwallettransaction;
                            $wallet->user_id = $user->sponsor_id;
                            $wallet->wallet_type_id = 1;
                            $wallet->reference_id = 14;
                            $wallet->denomination_id = 1;
                            $wallet->reference_num = $order->order;
                            $wallet->transaction_type = 1;
                            $wallet->transaction_comment = "Affiliate Commission for Level 1 from order: " . $order->order;
                            $wallet->transaction_status = 3;
                            $wallet->amount = $qty[$i] * $product->level_one_affiliate;
                            $wallet->created_at = now();
                            $wallet->save();
                        }
                        if (!is_null($user->sponsor_id)) {
                            $sponsor2 = User::find($user->sponsor_id);
                            if ($product->level_two_affiliate != 0.00 && (!is_null($sponsor2->sponsor_id))) {
                                $wallet = new Allwallettransaction;
                                $wallet->user_id = $sponsor2->sponsor_id;
                                $wallet->wallet_type_id = 1;
                                $wallet->reference_id = 14;
                                $wallet->denomination_id = 1;
                                $wallet->reference_num = $order->order;
                                $wallet->transaction_type = 1;
                                $wallet->transaction_comment = "Affiliate Commission for Level 2 from order: " . $order->order;
                                $wallet->transaction_status = 3;
                                $wallet->amount = $qty[$i] * $product->level_two_affiliate;
                                $wallet->created_at = now();
                                $wallet->save();
                            }
                        }
                        $orderLineItem = new OrderLineItem;
                        $orderLineItem->order_id = $order->id;
                        $orderLineItem->product_id = $prod[$i];
                        $orderLineItem->product_name = $product->name;
                        $orderLineItem->item_qty = $qty[$i];
                        $orderLineItem->item_disc = $disc[$i];
                        $orderLineItem->item_price = $price[$i];
                        $orderLineItem->product_sku = $product->sku;
                        $orderLineItem->created_at = now();
                        $orderLineItem->save();
                    }
                }
            }

            $payment = Payment::find($request->payment_mode);
            //save order payment
            $orderPayment = new OrderPayment;
            $orderPayment->order_id = $order->id;
            $orderPayment->total = $order->net_total;
            $orderPayment->payment_mode = $payment->id;
            $orderPayment->payment_ref_id = $request->payment_ref_id;
            $orderPayment->payment_date = $request->payment_date;
            $orderPayment->payment_status = $request->payment_status;
            $orderPayment->transaction_mode = $payment->type;
            $orderPayment->denomination_id = 1;
            $orderPayment->created_at = now();
            $orderPayment->save();

            // add user affiliate level amount
            // $affiliateData = ProductAffiliate::where(['product_id' => $request->products])->first();

            // if (!empty($affiliateData)) {
            //     $affLevel = [];
            //     foreach ($affiliateData as $affKey => $affiliate) {
            //         $affLevel[$affKey] = $affiliate->aff_level;
            //     }
            //     $maxValue = max($affLevel);
            //     $userParents = json_decode(BinaryTreeHelper::GetParentTrace($order->user_id, $maxValue));
            //     foreach ($userParents as $parent) {
            //         if (in_array($parent['level'], $affLevel)) {
            //             //Credit transaction type
            //             $transaction_type = 0;
            //             //User Wallet type
            //             $wallet_type = 1;
            //             //Affiliate reference Id
            //             $affiliate_id = 3;
            //             //Transaction comment
            //             $comment = "From UserId-" . $order->user_id . ", Level-" . $parent['level'];
            //             //Denomination Id
            //             $denominationId = 1;
            //             //Transaction Status
            //             $transaction_status = 1;
            //             //CBM portal
            //             $portal_id = 1;
            //             // get affiliate
            //             $affiliateDetails = ProductAffiliate::where(['product_id' => $request->products, 'aff_level' => $parent['level']])->first();
            //             $affAmount = $affiliateDetails->amount * $request->item_qty;

            //             //Add to wallet
            //             WalletHelper::addToWallet($parent['userId'], $wallet_type, $transaction_type, $affiliate_id, $userId, $comment, $denominationId, $transaction_status, $portal_id, $affAmount, now());
            //         }
            //     }
            // }

            // //License Update
            // $cbm_account = CbmMtFourAccount::where(['email_address' => $user->email, 'agent' => $products->agent])->first();

            // ServiceHelper::modifyCBMUserLicenses($user->id, $user->email, $products->agent, $request->item_qty, $request->item_qty);

            // $orderLicense = new CbmOrderLicenses;
            // $orderLicense->user_id = $user->id;
            // $orderLicense->order_id = $order->id;
            // $orderLicense->product_id = $products->id;
            // $orderLicense->product_name = $products->name;
            // $orderLicense->licenses = $request->item_qty;
            // $orderLicense->created_at = now();
            // $orderLicense->save();
            // if (!empty($cbm_account)) {
            //     OrderHelper::generateCBMNodes($cbm_account->login);
            // }
            // //OrderHelper::orderConfirmationMail($order->id);
            // OrderHelper::updateUserStatus($order->id);

            $order->products()->sync($request->input('products', []));
        }
        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment = Payment::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $orderLineItem = OrderLineItem::where('order_id', $order->id)->get();
        $orderPayment = OrderPayment::where('order_id', $order->id)->get();

        $product = Product::all();
        $productPrice = [];
        foreach ($product as $value) {
            $productPrice[$value['id']] = $value['price'];
        }

        $order->load('user', 'country', 'products');
        $invoice = Invoice::where('order_id', $order->order)->first();

        return view('admin.orders.edit', compact('users', 'countries', 'products', 'order', 'payment', 'productPrice', 'orderLineItem', 'orderPayment','invoice'));
    }

    public function update(Request $request, Order $order)
    {

        $order->created_at = $request->created_at;
        $orderLineItem = OrderLineItem::where('order_id', $order->id)->get();
        foreach ($orderLineItem as $item) {
            $price [] = $item->item_price;
            $qty [] = $item->item_qty;
            $disc [] = $item->item_disc;


        }
        $orderItem = [
            "item_qty" => $qty,
            "item_disc" => $disc,
            "item_price" => $price,
        ];
//        print_r($orderItem);die;
        // Order All item price,discount,total,net total
        $totalArray = $this->getOrderAllTotal($orderItem);

        $request->vat_percentage = 21.00;
        $order->vat = $totalArray['orderTotal'] * 0.21;
        $order->email = $request->email;
        $order->country_id = $request->country_id;
        $order->region = $request->region;
        $order->city = $request->city;
        $order->street = $request->street;
        $order->company = $request->company;
        $order->order_status = $request->order_status;
        $order->vat_number = $request->vat_number;
        $order->discount = $totalArray['orderDiscount'];
        $order->net_total = $totalArray['orderTotal'] - $totalArray['orderDiscount'] + $order->vat;
        $order->updated_at = now();

        /*$orderLineItem = OrderLineItem::where(['product_name' => $request->products, 'order_id' => $order->id])->first();
        $orderLineItem->item_qty = $request->item_qty;
        // $orderLineItem->item_disc = $request->item_disc;
        // $orderLineItem->item_price = $request->item_price;
        $orderLineItem->updated_at = now();
        $orderLineItem->save();*/
//        $order->invoice_number = $request->invoice_number;
        //$order->invoice_date = $request->payment_date;
        $is_Invoice = Invoice::where(['order_id' => $order->order])->get()->first();
        //If Order Cancelled
        if($request->order_status == 3){
            $order->invoice_number = NULL;
            if($is_Invoice != ''){
                $is_Invoice->delete();
            }
        }
        if ($request->order_status == 2 && $order->net_total > 0) {
            //Get Invoice Number
            if ($request->invoice_number == '') {
                $invoice_number = OrderHelper::getInvoiceNumber();;
            } else {
                $invoice_number = $request->invoice_number;
            }
            if ($is_Invoice == null) {
                $orderInvoice = new Invoice();
                $orderInvoice->order_id = $order->order;
                $orderInvoice->invoice_number = $invoice_number;
                //$order->invoice_date = ($request->payment_date !='')?$request->payment_date:'';
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
                $subscription = Subscription::where('order_id', $order->order)->get()->first();
                if (!empty($subscription)) {
                    $subscription = $subscription->toArray();
                } else {
                    $subscription = [];
                }

                if (count($subscription) > 0) {
                    $orderInvoice->subscription_id = $subscription['subscription_id'];
                }
                $orderInvoice->save();

            } else {
                $is_Invoice->invoice_number = $invoice_number;
                $is_Invoice->invoice_date = ($request->payment_date !='')?$request->payment_date:$is_Invoice->invoice_date;
                $is_Invoice->save();

            }

        }
        // $order->order_comment = $request->order_comment;
        $payment = Payment::find($request->payment_mode);
        $orderPayment = OrderPayment::where(['order_id' => $order->id])->first();
//        $orderPayment->total = $order->net_total;
        $orderPayment->payment_ref_id = $request->payment_ref_id;
        $orderPayment->payment_status = $request->payment_status;
//        $orderPayment->transaction_mode = $payment->type;
        $orderPayment->updated_at = now();
        $orderPayment->save();
        session(['audit_log' => "(Admin)User ".auth()->id()." updated order", 'audit_log_category' => "Package Purchase"]);
        if ($order->save()) {
            $order->products()->sync($request->input('product_id', []));

            return redirect()->route('admin.orders.index');
        }
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('user', 'country', 'products');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $orderLineItem = OrderLineItem::where('order_id', $order->id)->get();
        $orderPayment = OrderPayment::where('order_id', $order->id)->get();
        $payment_type = OrderPayment::where('order_id', $order->id)->first();
        $payment = Payment::where('id','=', $payment_type->payment_mode)->first();

        return view('admin.orders.show', compact('order','orderLineItem','products','orderPayment','payment'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        session(['audit_log' => "(Admin)User ".auth()->id()." deleted order", 'audit_log_category' => "Package Purchase"]);

        $order->delete();

        Allwallettransaction::where('reference_num', $order->order)->delete();
        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * get user address or business address
     * @param $_POST
     * @return array
     */
    public function getAddress()
    {
        date_default_timezone_set('Europe/Berlin');

        if (isset($_POST['user_id'])) {
            $users = User::find($_POST['user_id']);
            $country = Country::find($users->country_id);
            $users->country_id = isset($country->name) ? $country->name : '';
            $country2 = Country::find($users->bus_address_country_id);
            if (empty($country2)) {
            } else {
                $users->bus_address_country_id = isset($country2->name) ? $country2->name : '';
            }
            $result = [
                'result' => true,
                'userInfo' => $users,
            ];
        } else {
            $result = [
                'result' => false,
            ];
        }
        echo json_encode($result);
    }


    /**
     * get product price
     * @param $_POST
     * @return array
     */
    public function loadPrice()
    {
        date_default_timezone_set('Europe/Berlin');

        if ($_POST['qty'] > 0) {
            $user = User::find($_POST['user_id']);
            $productDetail = Product::find($_POST['product_id']);
            $totalItemPrice = $productDetail->price * $_POST['qty'];
            $discount = $_POST['discount'];
            $totalDiscount = $_POST['qty'] * $discount;
            $subTotal = $totalItemPrice - $totalDiscount;
            $vatAmount = 0;
            $vatpercent = 0;
            if (isset($_POST['country'])) {
                $country = Country::find($user->country_id);
                $vatAmount = $subTotal * $country->personal_vat / 100;
            }
            if (isset($_POST['address'])) {
                if ($_POST['address'] == 0) {
                    $country = Country::find($user->country_id);
                    if (empty($country)) {
                        $vatAmount = 0;
                        $vatpercent = 0;
                    } else {
                        $vatAmount = $subTotal * $country->personal_vat / 100;
                        $vatpercent = $country->personal_vat;
                    }
                } else {
                    $country = Country::find($users->bus_address_country_id);
                    if (empty($country)) {
                        $vatAmount = 0;
                        $vatpercent = 0;
                    } else {
                        $vatAmount = $subTotal * $country->business_vat / 100;
                        $vatpercent = $country->business_vat;
                    }
                }
            }
            $vatincluded_amount = $totalItemPrice - $totalDiscount + $vatAmount;
            $result = [
                'result' => true,
                'productPrice' => $productDetail->price,
                'totalItemPrice' => $totalItemPrice,
                'vatAmount' => $vatAmount,
                'netTotal' => $vatincluded_amount,
                'subTotal' => $subTotal,
                'discount' => $discount,
                'vatpercent' => $vatpercent,
                'totalDiscount' => $totalDiscount
            ];
        } else {
            $result = [
                'result' => false,
            ];
        }
        echo json_encode($result);
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
