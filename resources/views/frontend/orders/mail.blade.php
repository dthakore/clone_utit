@component('mail::message')
{{--Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# @lang('Hello!')
@endif
<style>
    body{
        color: black!important;
    }
</style>
<h2 style="font-size: 18px;">Thank you for your order</h2>

<h5 style="font-size: 14px">Your order Has been received and is now being processed. Your order details are shown below for your reference.</h5>

<h3 style="font-size: 16px">order # {{$order->order}} {{date('d-M-Y',strtotime($orderPayment->updated_at))}}</h3>

<table style="font-family: arial, sans-serif;width:100%;border-collapse: collapse;font-size: 14px">
<thead style="font-size: 16px">
<th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Product</th>
<th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Quantity</th>
<th style="border: 1px solid #dddddd;text-align: left;padding: 8px;">Price</th>
</thead>
<tbody>
@foreach($orderLineItems as $orderLineItem)
<tr>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">{{$orderLineItem->product_name}}</td>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
{{(int)$orderLineItem->item_qty}}
@if((strlen(trim($orderLineItem->comment)) > 1))
{{ " - " .  $orderLineItem->comment}}
@endif
</td>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
€ {{ number_format($orderLineItem->item_qty*$orderLineItem->item_price, 2, ',')}}
{{--€ {{ round($orderLineItem->item_qty*$orderLineItem->item_price, 2)}}--}}
</td>
</tr>
@endforeach
<tr>
<td colspan="2" style="border: 1px solid #dddddd;text-align: left;padding: 8px;font-weight: bold">
Subtotal (Excl VAT) :
</td>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
€ {{number_format($orderTotal, 2, ',')}}
{{--€ {{round($order->order_total, 2)}}--}}
</td>
</tr>
<tr>
<td colspan="2" style="border: 1px solid #dddddd;text-align: left;padding: 8px;font-weight: bold">
Vat ({{(int)$order->vat_percentage}} %) :
</td>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
€ {{number_format($order->vat, 2, ',')}}
{{--€ {{round($order->vat, 2)}}--}}
</td>
</tr>
<tr>
<td colspan="2" style="border: 1px solid #dddddd;text-align: left;padding: 8px;font-weight: bold">
Payment method :
</td>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
@php
if($orderPayment->payment_mode == 2 && !is_null(json_decode($orderPayment->payment_comment))){
echo json_decode($orderPayment->payment_comment)->type;
}
else{
echo $orderPayment->transaction_mode;
}
@endphp
</td>
</tr>
<tr>
<td colspan="2" style="border: 1px solid #dddddd;text-align: left;padding: 8px;font-weight: bold">
Total :
</td>
<td style="border: 1px solid #dddddd;text-align: left;padding: 8px;">
€ {{number_format($net_total, 2, ',')}}
{{--€ {{round($order->net_total, 2)}}--}}
</td>
</tr>
</tbody>
</table>

{{--  Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

@endcomponent

{{--@component('mail::layout')--}}
{{-- --}}{{-- Header --}}
{{--@slot('header')--}}
{{--@component('mail::header', ['url' => config('app.url')])--}}
{{--@endcomponent--}}
{{--@endslot--}}
{{-- --}}{{-- Body --}}
{{--<b>Hello!</b>--}}
{{--<h2>Thank you for your order</h2>--}}
{{--<h5>Your order Has been received and is now being processed. Your order details are shown below for your reference.</h5>--}}
{{--<h3>order # {{$order->order}}</h3>--}}
{{--<table>--}}
{{--<thead>--}}
{{--<th>Product</th>--}}
{{--<th>Quantity</th>--}}
{{--<th>Price</th>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--@foreach($orderLineItems as $orderLineItem)--}}
{{--<tr>--}}
{{--<td>{{$orderLineItem->product_name}}</td>--}}
{{--<td>--}}
{{--{{(int)$orderLineItem->item_qty}}--}}
{{--@if(empty($orderLineItem->comment))--}}
{{--{{ " - " .  $orderLineItem->comment}}--}}
{{--@endif--}}
{{--</td>--}}
{{--<td>--}}
{{--€ {{ number_format($orderLineItem->item_qty*$orderLineItem->item_price, 2, ',')}}--}}
{{-- € {{ round($orderLineItem->item_qty*$orderLineItem->item_price, 2)}}--}}
{{--</td>--}}
{{--</tr>--}}
{{--@endforeach--}}
{{--<tr>--}}
{{--<td colspan="2">--}}
{{--Subtotal (Excl VAT) :--}}
{{--</td>--}}
{{--<td>--}}
{{--€ {{number_format($order->order_total, 2, ',')}}--}}
{{--€ {{round($order->order_total, 2)}}--}}
{{--</td>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--<td colspan="2">--}}
{{--Vat ({{(int)$order->vat_percentage}} %) :--}}
{{--</td>--}}
{{--<td>--}}
{{--€ {{number_format($order->vat, 2, ',')}}--}}
{{--€ {{round($order->vat, 2)}}--}}
{{--</td>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--<td colspan="2">--}}
{{--Payment method :--}}
{{--</td>--}}
{{--<td>--}}
{{--@php--}}
{{--if($orderPayment->payment_mode == 2 && !is_null(json_decode($orderPayment->payment_comment))){--}}
{{--echo json_decode($orderPayment->payment_comment)->type;--}}
{{--}--}}
{{--else{--}}
{{--echo $orderPayment->transaction_mode;--}}
{{--}--}}
{{--@endphp--}}
{{--</td>--}}
{{--</tr>--}}
{{--<tr>--}}
{{--<td colspan="2">--}}
{{--Total :--}}
{{--</td>--}}
{{--<td>--}}
{{--€ {{number_format($order->net_total, 2, ',')}}--}}
{{--€ {{round($order->net_total, 2)}}--}}
{{--</td>--}}
{{--</tr>--}}
{{--</tbody>--}}
{{--</table>--}}
{{--@lang('Regards'),<br>--}}
{{--{{ config('app.name') }}--}}

{{--@isset($subcopy)--}}
{{--@slot('subcopy')--}}
{{--@component('mail::subcopy')--}}
{{--{{ $subcopy }}--}}
{{--@endcomponent--}}
{{--@endslot--}}
{{--@endisset--}}
{{-- Footer --}}
{{--@slot('footer')--}}
{{--@component('mail::footer')--}}
{{--© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')--}}
{{--@endcomponent--}}
{{--@endslot--}}
{{--@endcomponent--}}
