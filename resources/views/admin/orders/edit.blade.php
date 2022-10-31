@extends('layouts.admin')
@section('content')
<style>
    .error {
        color: red;
    }
    .selected-address {
        padding: 10px 15px;
        border: 1px solid #eee;
        border-radius: 10px;
    }
</style>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.update", [$order->id]) }}" id="update-order">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                            <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required disabled>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $order->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block" id="user_msg">{{ trans('cruds.order.fields.user_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="created_at">Order Date</label>
                            <input class="form-control date {{ $errors->has('created_at') ? 'is-invalid' : '' }}" type="text" name="created_at" id="created_at" value="{{ old('created_at', date('Y-m-d', strtotime($order->created_at))) }}" required>
                            @if($errors->has('created_at'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('created_at') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="order_comment">{{ trans('cruds.order.fields.order_comment') }}</label>
                            <input class="form-control {{ $errors->has('order_comment') ? 'is-invalid' : '' }}" type="text" name="order_comment" id="order_comment" value="{{ old('order_comment', $order->order_comment) }}">
                            @if($errors->has('order_comment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('order_comment') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.order_comment_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="vat_number">{{ trans('cruds.order.fields.vat_number') }}</label>
                            <input class="form-control {{ $errors->has('vat_number') ? 'is-invalid' : '' }}" type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', $order->vat_number) }}">
                            @if($errors->has('vat_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vat_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.vat_number_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="invoice_number">{{ trans('cruds.order.fields.invoice_number') }}</label>
                            <input class="form-control {{ $errors->has('invoice_number') ? 'is-invalid' : '' }}" type="text" name="invoice_number" id="invoice_number" value="{{ isset($invoice) ? old('invoice_number', $invoice->invoice_number) : '' }}" readonly>
                            @if($errors->has('invoice_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('invoice_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="email">{{ trans('cruds.order.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $order->email) }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" type="text" name="company" id="company" value="{{ old('company', $order->company) }}">
                            @if($errors->has('company'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('company') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="building">{{ trans('cruds.order.fields.building') }}</label>
                            <input class="form-control {{ $errors->has('building') ? 'is-invalid' : '' }}" type="text" name="building" id="building" value="{{ old('building', $order->building) }}">
                            @if($errors->has('building'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('building') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.building_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="street">{{ trans('cruds.order.fields.street') }}</label>
                            <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $order->street) }}">
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.street_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="order_status">{{ trans('cruds.order.fields.order_status') }}</label>
                            <select class="form-control {{ $errors->has('order_status') ? 'is-invalid' : '' }}" name="order_status" id="order_status" required>
                                <option value disabled {{ old('order_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Order::ORDER_STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ (old('order_status') ? old('order_status') : $order->order_status ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('order_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('order_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.order_status_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="city">{{ trans('cruds.order.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $order->city) }}">
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.city_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="region">{{ trans('cruds.order.fields.region') }}</label>
                            <input class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" type="text" name="region" id="region" value="{{ old('region', $order->region) }}">
                            @if($errors->has('region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('region') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.region_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="postcode">{{ trans('cruds.order.fields.postcode') }}</label>
                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', $order->postcode) }}">
                            @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.postcode_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="country_id">{{ trans('cruds.user.fields.country') }}</label>
                            <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" required>
                                @foreach($countries as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $order->country_id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.country_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <h4>Product</h4>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>Product Name<span class="error"> *</span></th>
                                <th class="text-center">Qty<span class="error"> *</span></th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                            </tr>
                            </thead>
                            <tbody class="table" id="productControl">
                            @foreach($orderLineItem as $id => $product)
                            <tr class="addMoreProduct">
                                <td class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="form-group" id="product">
                                            <!-- <select class="product form-control {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products" id="products" required disabled>
                                                @foreach($products as $id => $pro)
                                                    <option value="{{ $id }}" {{ (old('products') ? old('products') : $product->product_id ?? '') == $id ? 'selected' : '' }}>{{ $pro }}</option>
                                                @endforeach
                                            </select> -->
                                            <input type="hidden" class="product" id="product_id" name="product_id" value="{{ $product->product_id }}">
                                            <input class="product form-control {{ $errors->has('products') ? 'is-invalid' : '' }}" type="text" name="products" id="products" value="{{ old('products', $product->product_name) }}" required readonly>
                                            @if($errors->has('products'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('products') }}
                                                </div>
                                            @endif
                                            <span class="help-block" id="product_msg">{{ trans('cruds.order.fields.product_helper') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="product form-control {{ $errors->has('item_qty') ? 'is-invalid' : '' }}" type="text" name="item_qty" id="item_qty" value="{{ old('item_qty', $product->item_qty) }}" required readonly>
                                            @if($errors->has('item_qty'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('item_qty') }}
                                                </div>
                                            @endif
                                            <span class="help-block" id="qty_msg"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-2">
                                    <div class="col-md-12">
                                        <div class="product form-group">
                                            <input class="form-control {{ $errors->has('item_disc') ? 'is-invalid' : '' }}" type="text" name="item_disc" id="item_disc" value="{{ old('item_disc', $product->item_disc) }}" readonly>
                                            @if($errors->has('item_disc'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('item_disc') }}
                                                </div>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-2 text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="product form-control {{ $errors->has('item_price') ? 'is-invalid' : '' }}" type="text" name="item_price" id="item_price" value="{{ old('item_price', $product->item_price) }}" readonly>
                                            @if($errors->has('item_price'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('item_price') }}
                                                </div>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </td>
                                @php
                                    $qnty = $product->item_qty;
                                    $disc = (!empty($product->item_disc)) ? $product->item_disc : 0;
                                    $discount = $disc;
                                    $total = ($qnty * $product->item_price) - $discount;
                                @endphp
                                <td class="col-md-2 text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="product form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="text" name="orderTotal" id="orderTotal" value="{{ old('total', $total) }}" readonly>
                                        </div>
                                    </div>
                                </td>
                            </td>
                            </tr>
                            @endforeach
                            <tr id="beforePrice">
                                <td colspan="4" class="text-right"><strong>Total Price:</strong></td>
                                <td class="text-right"  id="totalPrice">&euro; {{ $order->order_total }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total Discount:</strong></td>
                                <td class="text-right"  id="totalDiscount">&euro; {{ $order->discount }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong id="vatPercent">Vat@ {{ $order->vat_percentage }}%:</strong></td>
                                <td class="text-right"  id="vat-amount">&euro; {{ $order->vat }}</td>
                            </tr>
                            <tr class="success">
                                <td colspan="4" class="text-right text-uppercase"><strong>Net Total:</strong></td>
                                <td class="text-right"><strong  id="netTotalLabel">&euro; {{ $order->net_total }}</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h4>Payment</h4>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Payment Mode<span class="error"> *</span></th>
                            <th class="text-center">Payment Status<span class="error"> *</span></th>
                            <th class="text-center">Payment Ref<span class="error"> *</span></th>
                            <th class="text-center">Payment Date<span class="error"> *</span></th>
                            <th class="text-center">Payment Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderPayment as $id => $order_payment)
                            <tr>
                                <td class="col-md-1" style="max-width: 10.333333%;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input autofocus="autofocus" class="form-control" placeholder="Id" name="id" id="payment_id" value="{{ $order_payment->id }}" type="text" readonly="readonly">
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <select class="form-control {{ $errors->has('payment_mode') ? 'is-invalid' : '' }}" name="payment_mode" id="payment_mode" required disabled>
                                            @foreach($payment as $id => $value)
                                                <option value="{{ $id }}" {{ (old('payment_mode') ? old('payment_mode') : $order_payment->payment_mode ?? '') == $id ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('payment_mode'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('payment_mode') }}
                                            </div>
                                        @endif
                                        <span class="help-block"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <select class="form-control {{ $errors->has('payment_status') ? 'is-invalid' : '' }}" name="payment_status" id="payment_status" required>
                                            <option value disabled {{ old('payment_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Models\OrderPayment::PAYMENT_STATUS_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ (old('payment_status') ? old('payment_status') : $order_payment->payment_status ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('payment_status'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('payment_status') }}
                                            </div>
                                        @endif
                                        <span class="help-block"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-1" style="max-width: 10.333333%;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control {{ $errors->has('payment_ref_id') ? 'is-invalid' : '' }}" type="text" name="payment_ref_id" id="payment_ref_id" value="{{ old('payment_ref_id', $order_payment->payment_ref_id) }}" required>
                                            @if($errors->has('payment_ref_id'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('payment_ref_id') }}
                                                </div>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="form-control date {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d', strtotime($order_payment->payment_date))) }}" required readonly>
                                            @if($errors->has('payment_date'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('payment_date') }}
                                                </div>
                                            @endif
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-md-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input autofocus="autofocus" class="form-control" placeholder="Total" name="total" id="total" value="{{ $order_payment->total }}" type="text" readonly>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group" align="right">
                <button class="btn btn-danger" type="submit" id="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {

    // calculate everything
	$(".product").on("change", calcAll);

    // function for calculating product details
    function calcAll() {
        $(".addMoreProduct").each(function () {
            var product = '<?php echo json_encode($productPrice); ?>';
            var data = JSON.parse(product);

            var qnty = 0;
            var price = 0;
            var discount = 0;
            var total = 0;
            if (!isNaN(parseFloat($(this).find("#product_id").val()))) {
                id = parseFloat($(this).find("#product_id").val());
                if(id != ''){
                    price = parseFloat(data[id]);
                }
            }
            if (!isNaN(parseFloat($(this).find("#item_qty").val()))) {
                qnty = parseFloat($(this).find("#item_qty").val());
            }
            if (!isNaN(parseFloat($(this).find("#item_disc").val()))) {
                discount = parseFloat($(this).find("#item_disc").val());
            }
            disc = qnty * discount;
            total = qnty * price - discount;
            $(this).find("#item_price").val(price.toFixed(3)*qnty);
            $(this).find(".hidetotal").val(total.toFixed(3));
            $(this).find(".hidediscount").val(disc.toFixed(3));
        });

        var sum = $(".hidetotal").val();
        var totalDiscount = $(".hidediscount").val();
        // show values of Total price, Total discount Net total .toFixed(3)
        $("#totalPrice").text(sum);
        $("#totalDiscount").text(totalDiscount);
        $("#netTotalLabel").text(sum);
    }
});
</script>
@endsection('scripts')
