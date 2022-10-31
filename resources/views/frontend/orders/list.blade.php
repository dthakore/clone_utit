@extends('layouts.frontend-new', [
    "title" => "Order List",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Orders"
        ]
    ]
])
@section('styles')

    <!-- Data table css -->
    <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css')}}"  rel="stylesheet">
    <link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}" rel="stylesheet" />

    <!-- INTERNAL Select2 css -->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
    {{-- <style>
        .circle-icon {
            height: 55px!important;
            left: 40px!important;
            top: 10px!important;
            width: 55px!important;
        }
        .sales-card{
            min-height: 140px!important;
        }
    </style> --}}
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-8">
                                <div class="ps-4 pt-4 pe-3 pb-4">
                                    <div class="">
                                        <h6 class="mb-2 tx-12 ">Total Orders</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold mb-4">
                                                {{count($orders)}}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                    <i class="fe fe-shopping-bag tx-16 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-12">
                                <div class="ps-4 pt-3 pe-3  ">
                                    <div class="">
                                        <h2 class="mb-0 mt-1 tx-12">Cashback Licenses</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 ps-4 pe-0 pb-2 pt-2">
                                <div class="text-center">
                                    <h4 class="tx-20 font-weight-semibold mb-2">
                                    {{(int)$total_cashback}}
                                    </h4>
                                </div>
                                <p class="mb-0 tx-12 text-muted text-center">Total Licenses</p>
                            </div>
                            <div class="col-6 ps-2 pe-3 pb-2 pt-2">
                                <div class="text-center">
                                    <h4 class="tx-20 font-weight-semibold mb-2">N/A</h4>
                                </div>
                                <p class="mb-0 tx-12 text-muted text-center">Available Licenses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-12">
                                <div class="ps-4 pt-3 pe-3  ">
                                    <div class="">
                                        <h2 class="mb-0 mt-1 tx-12">Marketplace</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 ps-4 pe-3 pb-2 pt-2">
                                <div class="text-center">
                                    <h4 class="tx-20 font-weight-semibold mb-2">{{(int)$total_bot}}</h4>
                                </div>
                                <p class="mb-0 tx-12 text-muted text-center">Crypto bot licenses</p>
                            </div>
                            <div class="col-3 ps-4 pe-3 pb-2 pt-2">
                                <div class="text-center">
                                    <h4 class="tx-20 font-weight-semibold mb-2">{{$bot}}</h4>
                                </div>
                                <p class="mb-0 tx-12 text-muted text-center">botTrader Platform</p>
                            </div>
                            <div class="col-3 ps-4 pe-3 pb-2 pt-2">
                                <div class="text-center">
                                    <h4 class="tx-20 font-weight-semibold mb-2">N/A</h4>
                                </div>
                                <p class="mb-0 tx-12 text-muted text-center">Expert Advisors</p>
                            </div>
                            <div class="col-3 ps-4 pe-3 pb-2 pt-2">
                                <div class="text-center">
                                    <h4 class="tx-20 font-weight-semibold mb-2">N/A</h4>
                                </div>
                                <p class="mb-0 tx-12 text-muted text-center">MAM follower accounts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-nowrap border-bottom" id="responsive-datatable">
                            <thead>
                            <tr>
                                <th class="wd-5p">
                                    Order ID
                                </th>
                                <th class="wd-25p">
                                    Order Details
                                </th>
                                <th class="wd-15p">
                                    Payment Method
                                </th>
                                <th class="wd-15p">
                                    Status
                                </th>
                                <th class="wd-10p">
                                    Date
                                </th>
                                <th class="wd-10p">
                                    Total
                                </th>
                                <th class="wd-20p">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        {{$order->order}}
                                    </td>
                                    <td>
                                        <?php
                                        $product_name = \App\Models\OrderLineItem::where(['order_id' => $order->id])->get();
                                        if(!$product_name->isEmpty()){
                                            echo $product_name[0]->product_name ."<br/>" . $product_name[0]->comment;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $payment_method = \App\Models\OrderPayment::where(['order_id' => $order->id])->first();
                                        if(!empty($payment_method)){
                                            if($payment_method->payment_mode == 2 && !is_null(json_decode($payment_method->payment_comment))){
                                                echo json_decode($payment_method->payment_comment)->type;
                                            }
                                            else{
                                                echo $payment_method->transaction_mode;
                                            }
                                        }
                                        else{
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $status = App\Models\Order::ORDER_STATUS_SELECT[$order->order_status] ?? '';
                                        if(!empty($status)){
                                            if($status == "Pending"){
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            }
                                            elseif($status == "Shipped"){
                                                echo '<span class="badge badge-primary">Shipped</span>';
                                            }
                                            elseif($status == "Processing"){
                                                echo '<span class="badge badge-info">Processing</span>';
                                            }
                                            elseif($status == "Completed"){
                                                echo '<span class="badge badge-success">Completed</span>';
                                            }
                                            elseif($status == "Cancelled"){
                                                echo '<span class="badge badge-danger">Cancelled</span>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        {{date('d-M-Y',strtotime($order->updated_at))}}
                                    </td>
                                    <td>
                                            {{"EUR ".number_format($order->net_total, 2, ',')}}
{{--                                        {{"EUR ". $order->net_total}}--}}
                                    </td>
                                    <td>
                                        <?php 
                                            //var_dump($order);
                                        ?>
                                        <a class="btn btn-primary btn-sm" href="{{ url('/order/'.$order->id) }}">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
                                        <?php if($status == "Completed" && $order->cbm != 1):?>
                                        <a class="btn btn-primary btn-sm" href="{{ url('/invoice/'.$order->invoice_number) }}">
                                            <i class="fas fa-download">
                                            </i>
                                            Invoice
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <!-- Internal Data tables -->
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/table-data.js')}}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

@endsection
