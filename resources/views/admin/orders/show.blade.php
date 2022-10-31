@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            @php
                $subscription = App\Models\Subscription::where('order_id', $order->order)->first();
                
            @endphp
            <div class="card">
                <ul class="nav nav-tabs mb-2" role="tablist" id="relationship-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#general_info" role="tab" data-toggle="tab">
                            General Info
                        </a>
                    </li>
                    @if(isset($subscription))
                    <li class="nav-item">
                        <a class="nav-link" href="#license" role="tab" data-toggle="tab">
                            License
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#payment" role="tab" data-toggle="tab">
                            Payment
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" role="tabpanel" id="general_info">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $order->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.order') }}
                                    </th>
                                    <td>
                                        {{ $order->order }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $order->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.company') }}
                                    </th>
                                    <td>
                                        {{ $order->company }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.order_status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Order::ORDER_STATUS_SELECT[$order->order_status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.order_origin') }}
                                    </th>
                                    <td>
                                        {{ $order->order_origin }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.building') }}
                                    </th>
                                    <td>
                                        {{ $order->building }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.street') }}
                                    </th>
                                    <td>
                                        {{ $order->street }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.region') }}
                                    </th>
                                    <td>
                                        {{ $order->region }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.postcode') }}
                                    </th>
                                    <td>
                                        {{ $order->postcode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.city') }}
                                    </th>
                                    <td>
                                        {{ $order->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.country') }}
                                    </th>
                                    <td>
                                        {{ $order->country->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.product') }}
                                    </th>
                                    <td>
                                        @foreach($order->products as $key => $product)
                                            <span class="label label-info">{{ $product->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.order_total') }}
                                    </th>
                                    <td>
                                        {{ $order->order_total }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.discount') }}
                                    </th>
                                    <td>
                                        {{ $order->discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.vat') }}
                                    </th>
                                    <td>
                                        {{ $order->vat }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.vat_percentage') }}
                                    </th>
                                    <td>
                                        {{ $order->vat_percentage }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.vat_number') }}
                                    </th>
                                    <td>
                                        {{ $order->vat_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.net_total') }}
                                    </th>
                                    <td>
                                        {{ $order->net_total }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.invoice_number') }}
                                    </th>
                                    <td>
                                        @if(isset($order->invoice_number))
                                            {{ $order->invoice_number }}
                                        @endif
                                    </td>
                                </tr>
                                {{--<tr>
                                    <th>
                                        {{ trans('cruds.order.fields.invoice_date') }}
                                    </th>
                                    <?php
                                    // var_dump($order->invoice_date);
                                    // dd($order);
                                    ?>
                                    <td>
                                        @if(isset($order->invoice_date))
                                        {{ $order->invoice_date }}
                                        @endif
                                    </td>
                                </tr>--}}
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.is_subscription_enabled') }}
                                    </th>
                                    <td>
                                        {{ $order->is_subscription_enabled }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.order_comment') }}
                                    </th>
                                    <td>
                                        {{ $order->order_comment }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.user_name') }}
                                    </th>
                                    <td>
                                        {{ $order->user_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.email') }}
                                    </th>
                                    <td>
                                        {{ $order->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.voucher_code') }}
                                    </th>
                                    <td>
                                        {{ $order->voucher_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.voucher_discount') }}
                                    </th>
                                    <td>
                                        {{ $order->voucher_discount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $order->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.order.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $order->updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="license">
                        @if(isset($orderLineItem))
                        <table class="table table-borderless table-vcenter">
                            <thead>
                            <tr>
                                <th>
                                    <b>Product Details</b>
                                </th>
                                <th>
                                    <b>License Key</b>
                                </th>
                                <th>
                                    <b>Quantity</b>
                                </th>
                                <th>
                                    <b>Discount</b>
                                </th>
                                <th>
                                    <b>Cycle ends</b>
                                </th>
                                <th>
                                    <b>Price</b>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="table" id="productControl">
                                
                                @foreach($orderLineItem as $id => $product)
                                
                                    <tr class="addMoreProduct">
                                        <div class="col-md-12">
                                            <div class="form-group" id="product">
                                                <td>
                                                    <div class="font-w600">
                                                        <h6 class="h5">{{$product->product_name}}</h6>
                                                    </div>
                                                </td>
                                            </div>
                                        </div>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    @php
                                                        $status = App\Models\Order::ORDER_STATUS_SELECT[$order->order_status];
                                                    @endphp
                                                    @if($status == "Completed")
                                                        <div class="font-w600 " >
                                                            <a href="{{url('/license/'.$order->order.'/'.$product->product_id.'/'. \Auth::id() )}}">License</a>
                                                        </div>
                                                    @else
                                                        <div class="font-w600">
                                                            <h6>N/A</h6>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600">
                                                        <h6>{{ old('item_qty', $product->item_qty) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600">
                                                        <h6>{{ old('item_disc', $product->item_disc) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600">
                                                        @if(isset($subscription))
                                                        <h6>
                                                            {{ date('Y-m-d',strtotime($subscription->cycle_end_at))}}
                                                        </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600">
                                                        <h6>{{ old('item_price', $product->item_price) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="tab-pane" role="tabpanel" id="payment">
                        @if(isset($orderPayment))
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">Payment Mode</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Payment Ref</th>
                                    <th class="text-center">Payment Date</th>
                                    <th class="text-center">Payment Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderPayment as $id => $order_payment)
                                    <tr>
                                        <td class="col-md-1" style="max-width: 10.333333%;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600 text-center">
                                                        <h6>{{ $order_payment->id }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600 text-center">
                                                        @if(isset($payment))
                                                        <h6>{{ $payment->type }}</h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600 text-center">
                                                        <h6>{{ App\Models\OrderPayment::PAYMENT_STATUS_SELECT[$order_payment->payment_status] }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600 text-center">
                                                        <h6>{{ old('payment_ref_id', $order_payment->payment_ref_id) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600 text-center">
                                                        <h6>{{ old('payment_date', date('Y-m-d', strtotime($order_payment->payment_date))) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="font-w600">
                                                        <h6>{{ $order_payment->total }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection