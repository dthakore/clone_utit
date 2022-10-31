@extends('layouts.frontend-new', [
    "title" => "ORDER DETAIL",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Order"
        ]
    ]
])
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-solid">
                    <div class="card-header">
                        <h4 class="text-justified pt-2">Transaction Details</h4>
                    </div>

                    <div class="card-body">
                        <p class="pull-left">
                            Your transaction is
                            <?php
                            $status = App\Models\Order::ORDER_STATUS_SELECT[$order->order_status] ?? '';
                            if(!empty($status)){
                                if($status == "Pending"){
                                    echo '<span class="badge badge-warning" style="font-size: 100%;">Pending</span>';
                                }
                                elseif($status == "Shipped"){
                                    echo '<span class="badge badge-primary" style="font-size: 100%;">Shipped</span>';
                                }
                                elseif($status == "Processing"){
                                    echo '<span class="badge badge-info" style="font-size: 100%;">Processing</span>';
                                }
                                elseif($status == "Completed"){
                                    echo '<span class="badge badge-success" style="font-size: 100%;">Completed</span>';
                                }
                                elseif($status == "Cancelled"){
                                    echo '<span class="badge badge-dange" style="font-size: 100%;">Cancelled</span>';
                                }
                            }
                            ?>
                        </p>
                        <p class="pull-right">
                            Order No : {{$order->order}}<br>
                            Date : {{date('d-M-Y',strtotime($order->created_at))}}<br>
                            Platform expire on: {{ date('d-M-Y', strtotime( $orderlineitems->max('cycle_ends_at'))) }}
                        </p>
                        <div class="table-responsive">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                <tr>
                                    <th>
                                    </th>
                                    <th>
                                        Product Details
                                    </th>
                                    <th>
                                        License
                                    </th>
                                    <th class="text-right">
                                        Quantity
                                    </th>
                                    <th class="text-right">
                                        Price
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orderlineitems as $orderlineitem)
                                    <?php
                                    $product = App\Models\Product::with(['category', 'media'])->where('id',$orderlineitem->product_id)->get()->first();
                                    $image_file = "";
                                    $media = 0;
                                    if(isset($product->media[0])){
                                        $imageArr = $product->media[0]->getAttributes();
                                        $image_file = $imageArr['file_name'];
                                        $media = $imageArr['id'];
                                    }
                                    ?>
                                    <tr>
                                        <td style="width: 75px;">
                                            <img src="<?= Illuminate\Support\Facades\Storage::url("$media/$image_file");?>" class="img-responsive" style="height: 70px">
                                        </td>
                                        <td>
                                            @if(isset($product)) 
                                                @if($orderlineitem->product_sku == 'NTTP1')
                                                    <a class="h5" href="{{ url('/product/'.$product->id) }}">{{$orderlineitem->product_name}} - {{$orderlineitem->comment}}</a>
                                                @else
                                                    <a class="h5" href="{{ url('/product/'.$product->id) }}">{{$orderlineitem->product_name}}</a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $subscriptions = \App\Models\Subscription::where(['order_id' => $order->order,'product_id' => $product->id])->get();
                                            @endphp
                                            @if($status == "Completed" && !$subscriptions->isEmpty())
                                                <div class="font-w600 " >
                                                    <a href="{{url('/license/'.$order->order.'/'.$product->id.'/'. \Auth::id() )}}">License</a>
                                                </div>
                                            @else
                                                <div class="font-w600">
                                                    <h6>N/A</h6>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="font-w600 text-success">{{(int)$orderlineitem->item_qty }}</div>

                                        </td>
                                        <td class="text-right">
                                            <div class="font-w600 text-success">€ {{number_format($orderlineitem->item_price * (int)$orderlineitem->item_qty, 2, ',')}}</div>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="success">
                                    <td class="text-right" colspan="4">
                                        <span class="h4 font-w600">Sub Total</span>
                                    </td>
                                    <td class="text-right">
                                        <div class="h4 font-w600 text-success">€{{number_format($order->order_total, 2, ',')}}</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Order Summary
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table mg-b-0 text-md-nowrap" id="payment-detail-table">
                            <tbody>
                            <tr>
                                <td>Order Total</td>
                                <td class="text-right">€ {{number_format($order->order_total, 2, ',')}}</td>
                            </tr>
                            @if(isset($order->discount) && $order->discount > 0)
                            <tr>
                                <td>Discount</td>
                                <td class="text-right">€ {{number_format($order->discount, 2, ',')}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Vat@ {{(int)$order->vat_percentage }}%</td>
                                <td class="text-right">€ {{number_format($order->vat, 2, ',')}}</td>
                            </tr>

                            <tr class="success">
                                <td class="text-right" colspan="1">
                                    <span class="h4 font-w600">Total</span>
                                </td>
                                <td class="text-right">
                                    <div class="h4 font-w600 text-success">€ {{number_format($order->net_total, 2, ',')}}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $status = App\Models\Order::ORDER_STATUS_SELECT[$order->order_status];
                if($status == "Completed" && $order->cbm != 1):?>
                <div style="text-align: center">
                <a class="btn btn-primary btn-block btn-flat" target="_blank" href="{{ url('/invoice/'.$order->invoice_number) }}">
                    <i class="fas fa-download">
                    </i>
                    Download Invoice
                </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Payment Summary
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table mg-b-0 text-md-nowrap" id="payment-detail-table">
                            <thead><tr>
                                <th style="border-bottom: 1px solid #e9ecef">Payment Option</th>
                                <th style="border-bottom: 1px solid #e9ecef" class="text-right">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($orderpayment))
                            <tr>
                                <td>{{$orderpayment->transaction_mode}}</td>
                                <td class="text-right">
                                    <div class="h4 font-w600 text-success">€ {{number_format($orderpayment->total, 2, ',')}}</div>
                                </td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
