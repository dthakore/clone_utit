@extends('layouts.admin')
@section('content')
@section('styles')
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
@endsection
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" id="create-order">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                            <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="order_comment">{{ trans('cruds.order.fields.order_comment') }}</label>
                            <input class="form-control {{ $errors->has('order_comment') ? 'is-invalid' : '' }}" type="text" name="order_comment" id="order_comment" value="{{ old('order_comment', '') }}">
                            @if($errors->has('order_comment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('order_comment') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.order_comment_helper') }}</span>
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
                                    <option value="{{ $key }}" {{ old('order_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                            <label class="required" for="created_at">Order Date</label>
                            <input class="form-control date {{ $errors->has('created_at') ? 'is-invalid' : '' }}" type="text" name="created_at" id="created_at" value="{{ old('created_at') }}" required>
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
                <div class="col-md-12">
                    <div class="col-md-12 hide" id="address-selector">
                        <div class="form-group">
                            <div class="control-group">
                                <label class="control-label required" for="address">Addresses</label>
                                <div class="controls">
                                    <input type="radio" id="homeAddr" name="select_address" class="AddType" value="0" checked/> <label for="homeAddr">Personal</label>&nbsp;&nbsp;
                                    <input type="radio" id="workAddr" name="select_address" class="AddType" value="1"/> <label for="workAddr">Business</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 selected-address hide"></div>
                </div>
            </div>
            <div class="row hide">
                <div class="col-md-6">
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label for="vat_number">Vat Number</label>
                            <input class="form-control {{ $errors->has('vat_number') ? 'is-invalid' : '' }}" type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', '') }}">
                            @if($errors->has('vat_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vat_number') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company">Company</label>
                            <input class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}" type="text" name="company" id="company" value="{{ old('company', '') }}">
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
                            <label for="building">Building</label>
                            <input class="form-control {{ $errors->has('building') ? 'is-invalid' : '' }}" type="text" name="building" id="building" value="{{ old('building', '') }}">
                            @if($errors->has('building'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('building') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', '') }}">
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}">
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="region">Region</label>
                            <input class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" type="text" name="region" id="region" value="{{ old('region', '') }}">
                            @if($errors->has('region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('region') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="country_id">{{ trans('cruds.user.fields.country') }}</label>
                            <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" required>
                                @foreach($countries as $id => $entry)
                                    <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', '') }}">
                            @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
            </div>
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
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody class="table" id="productControl">
                        <tr class="addMoreProduct">
                            <td class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group" id="product">
                                    <!-- <label class="required" for="products">{{ trans('cruds.order.fields.product') }}</label> -->
                                        <select class="product form-control {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products[]" id="products" required>
                                            @foreach($products as $id => $product)
                                                <option value="{{ $id }}" {{ old('products') == $id ? 'selected' : '' }}>{{ $product }}</option>
                                            @endforeach
                                        </select>
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
                                        <input class="product form-control item_qty {{ $errors->has('item_qty') ? 'is-invalid' : '' }}" type="text" name="item_qty[]" id="item_qty" value="{{ old('item_qty', '') }}" required>
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
                                        <input class="form-control {{ $errors->has('item_disc') ? 'is-invalid' : '' }}" type="text" name="item_disc[]" id="item_disc" value="{{ old('item_disc', '') }}">
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
                                        <input class="product form-control {{ $errors->has('item_price') ? 'is-invalid' : '' }}" type="text" name="item_price[]" id="item_price" value="{{ old('item_price', '') }}" readonly>
                                        @if($errors->has('item_price'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('item_price') }}
                                            </div>
                                        @endif
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-add-product">
                                    <span>+</span>
                                </button>
                            </td>
                            <td style="display: none;">
                                <input style="display: none;" class="form-control hidetotal" readonly="readonly" val="" placeholder="Total Price" type="text">
                            </td>
                            <td style="display: none;">
                                <input style="display: none;" class="form-control hidediscount" readonly="readonly" val="" placeholder="Total Discount" type="text">
                            </td>
                        </tr>
                        <tr id="beforePrice">
                            <td colspan="4" class="text-right"><strong>Total Price:</strong></td>
                            <td class="text-right"  id="totalPrice">0</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total Discount:</strong></td>
                            <td class="text-right"  id="totalDiscount">0</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><strong id="vatPercent">Vat(21%) :</strong></td>
                            <td class="text-right"  id="vat-amount">0</td>
                        </tr>
                        <tr class="success">
                            <td colspan="4" class="text-right text-uppercase"><strong>Net Total:</strong></td>
                            <td class="text-right"><strong  id="netTotalLabel">0</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="order_total" id="order_total" value="">
            <input type="hidden" name="discount" id="discount" value="">
            <input type="hidden" name="net_total" id="net_total" value="">
            <input type="hidden" name="vat" id="vat" value="">
            <input type="hidden" name="vat_percent" id="vat_percent" value="21.00">
            <h4>Payment</h4><hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="payment_mode">Payment Mode</label>
                            <select class="form-control {{ $errors->has('payment_mode') ? 'is-invalid' : '' }}" name="payment_mode" id="payment_mode" required>
                                @foreach($payment as $id => $value)
                                    <option value="{{ $id }}" {{ old('payment_mode') == $id ? 'selected' : '' }}>{{ $value }}</option>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="payment_ref_id">Payment Ref</label>
                            <input class="form-control {{ $errors->has('payment_ref_id') ? 'is-invalid' : '' }}" type="text" name="payment_ref_id" id="payment_ref_id" value="{{ old('payment_ref_id', '') }}" required>
                            @if($errors->has('payment_ref_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('payment_ref_id') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="payment_mode">Payment Status</label>
                            <select class="form-control {{ $errors->has('payment_status') ? 'is-invalid' : '' }}" name="payment_status" id="payment_status" required>
                                <option value disabled {{ old('payment_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\OrderPayment::PAYMENT_STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('payment_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="payment_date">Payment Date</label>
                            <input class="form-control date {{ $errors->has('payment_date') ? 'is-invalid' : '' }}" type="text" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" required>
                            @if($errors->has('payment_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('payment_date') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
{{--                    <input type="hidden" name="vat" id="vat_amount" value="">--}}
{{--                    <input type="hidden" name="vat_percent" id="vat_percent" value="21.00">--}}
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
            $(document).on('click', '.btn-add-product', function (e) {
                var controlForm = $('#productControl:first');
                var currentEntry = $(this).parents('.addMoreProduct:first');
                var newEntry = $(currentEntry.clone()).appendTo(controlForm).insertBefore('#beforePrice');

                // Remove Selected option in new Field
                newEntry.find('#products option:selected').removeAttr('selected');
                newEntry.find('#item_qty').val('');
                newEntry.find('#item_price').val('');
                newEntry.find('#item_disc').val('');

                controlForm.find('.btn-add-product:not(:last)')
                    .removeClass('btn-default').addClass('btn-danger')
                    .removeClass('btn-add-product').addClass('btn-remove-product')
                    .html('<span>-</span>');
            }).on('click', '.btn-remove-product', function (e) {
                $(this).parents('.addMoreProduct:first').remove();
                calcAll();
                return false;
            });

            $("form[id='create-order']").validate({
                rules: {
                    user_id: {
                        required: true
                    },
                    order_status: {
                        required: true
                    },
                    products: {
                        required: true
                    },
                    item_qty: {
                        required: true
                    },
                    payment_mode: {
                        required: true
                    },
                    payment_status: {
                        required: true
                    },
                    payment_ref_id: {
                        required: true
                    },
                    created_at: {
                        required: true,
                        date: true
                    },
                    payment_date: {
                        required: true,
                        date: true
                    }
                },
                messages: {
                    user_id: {
                        required: "Please select the user"
                    },
                    order_status: {
                        required: "Please select the order status"
                    },
                    products: {
                        required: "Please select the product"
                    },
                    item_qty: {
                        required: "Please enter quantity"
                    },
                    payment_mode: {
                        required: "Please select the payment mode"
                    },
                    payment_status: {
                        required: "Please select the payment status"
                    },
                    payment_ref_id: {
                        required: "Please enter payment reference id"
                    },
                    created_at: {
                        required: "Please enter order date",
                        date: "Please enter proper date"
                    },
                    payment_date: {
                        required: "Please enter payment date",
                        date: "Please enter proper date"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            // calculate everything
            // $(".product").on("change", calcAll);

            $(document).on('change','.product',function () {
                calcAll();
            });

            $(document).on('change','.item_qty',function () {
                calcAll();
            });

            // function for calculating product details
            function calcAll() {
                var total = 0;
                var disc = 0;
                var withoutdisc = 0;
                var vat = 0;
                $(".addMoreProduct").each(function () {
                    var product = '<?php echo json_encode($productPrice); ?>';
                    var data = JSON.parse(product);
                    var discount = 0;
                    var qnty = 0;
                    var price = 0;
                    if (!isNaN(parseFloat($(this).find("#products").val()))) {
                        id = parseFloat($(this).find("#products").val());
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
                    disc += discount;
                    total += (((qnty * price) - discount) + vat);
                    withoutdisc += (qnty * price);

                    $(this).find("#item_price").val(price.toFixed(3)*qnty);
                    $(this).find(".hidetotal").val(total.toFixed(3));
                    $(this).find(".hidediscount").val(disc.toFixed(3));
                });
                vat = (total * 0.21);
                total = total + vat;

                // show values of Total price, Total discount Net total .toFixed(3)
                $("#totalPrice").text(withoutdisc.toFixed(3));
                $("#totalDiscount").text(disc.toFixed(3));
                $("#netTotalLabel").text(total.toFixed(3));
                $("#vat-amount").text(vat.toFixed(3));
                $("#vat").val(vat.toFixed(3));
                $("#order_total").val(withoutdisc.toFixed(3));
                $("#discount").val(disc.toFixed(3));
                $("#net_total").val(total.toFixed(3));
            }

            // TODO: Select Address
            $(document).on('change','#user_id',function (e) {
                $("#vat-amount, #netTotal, #totalPrice, #totalDiscount").html('0');
                $('#user_msg').css('display','none');
                $('#user').removeClass('error');

                $("#address-selector").addClass("hide");
                var data = {
                    user_id : $(this).val(),
                    _token: "{{ csrf_token() }}"
                };
                if($('#user_id').val() != ""){
                    $.ajax({
                        type : "POST",
                        url : "{{ url('admin/get-address') }}",
                        data : data,
                        success : function(result){
                            var addressData = JSON.parse(result);
                            if(addressData.result == true){
                                $('#submit').attr("disabled", false);
                                if(addressData['userInfo']['business_name'] != 0) {
                                    if(addressData['userInfo']['business_name'] != "") {
                                        if(addressData['userInfo']['business_name'] != null){
                                            $("#address-selector").removeClass("hide");
                                        }
                                    }
                                }
                                setAddress(0, addressData);
                            }else if(addressData.result == 'false'){
                                $("#address-selector").removeClass("hide");
                                $("#address-selector").html('<span style="color:red;">Address is not Available</span>');
                                $('#submit').attr('disabled', true);
                            }else {
                                alert("could not load address")
                            }
                        }
                    });
                }else{
                    $("#user_msg").html("Please select the user").addClass('error');
                }
            });

            $('#item_qty').on("keyup",function () {
                console.log("Qty");
                var productName = $('#products').val();
                if (productName == '') {
                    $('#product_msg').text('Please select the product');
                    $('#product').addClass('error');
                    return false;
                }
            });

            //On updating item remove defined field
            $('#products').on("change",function(){
                $('#item_qty').val('');
                $('#item_disc').val(0);
                $('#totalPrice').html(0);
                $('#netTotalLabel').html(0);
                $('#vat-amount').html(0);
                $('#totalDiscount').html(0);
            });

            function ProductPrice(productDetails) {
                $('#product_msg').css('display','none');
                $('#product').removeClass('error');
                var validQtyFlag = 0;
                var addrType = $(".AddType:checked").val();
                var UserId = $('#user_id').val();
                // get selected product
                var productItem = productDetails.find('#products').val();
                // get entered quantity
                var productQty = productDetails.find('#item_qty').val();
                var discount = productDetails.find('#item_disc').val();
                var validNum = /[^\d].+/;

                if(productItem != '' && productQty != ''){
                    $('#qty_msg').css('display','none');
                    $('#qty').removeClass('error');
                    var data = {
                        qty : productQty,
                        product_id : productItem,
                        address : addrType,
                        user_id : UserId,
                        discount: discount,
                        _token: "{{ csrf_token() }}"
                    };
                    $.ajax({
                        type : "POST",
                        url : "{{ url('admin/load-price') }}",
                        data : data,
                        success : function(result){
                            var productData = JSON.parse(result);
                            if(productData.result == true){
                                $('#itemPrice').val(productData.productPrice);
                                $("#vatPercent").html('Vat@' + productData.vatpercent + '%');
                                $('#totalPrice').html(productData.totalItemPrice);
                                $('#netTotalLabel').html(productData.netTotal);
                                $('#vat-amount').html(productData.vatAmount);
                                //Set the hidden vat element
                                $('#vat_amount').val(productData.vatAmount);
                                $('#vat_percent').val(productData.vatpercent);
                                $('#totalDiscount').html(productData.totalDiscount);
                            }
                        }
                    });
                }else{
                    productDetails.find('#itemPrice').val('');
                }
            }

            function changedPrice(){
                var productRow = $('#products').parents('tr');
                ProductPrice(productRow);
            }

            $("#homeAddr, #workAddr").change(function () {
                var data = {
                    user_id : $('#user_id').val(),
                    _token: "{{ csrf_token() }}"
                };
                var addressType = $(this).val();
                if($('#user_id').val() != ""){
                    $.ajax({
                        type : "POST",
                        url : "{{ url('admin/get-address') }}",
                        data : data,
                        success : function(result){
                            var addressData = JSON.parse(result);
                            if(addressData.result == true){
                                setAddress(addressType, addressData);
                            } else {
                                alert("could not load address")
                            }
                            changedPrice();
                        }
                    });
                }else{
                    $("#user_msg").html("Please select the user").addClass('error');
                }
            });

            function setAddress(adType, addressData) {
                if(adType == 0) {
                    var personalAddress = '';
                    personalAddress += (addressData['userInfo']['name'] == 'NULL' || addressData['userInfo']['name'] == '0' || addressData['userInfo']['name'] === 0 || !addressData['userInfo']['name'])?'':"<b>" + addressData['userInfo']['name']+"</b>,<br/>";
                    personalAddress += (addressData['userInfo']['building_num'] == 'NULL' || addressData['userInfo']['building_num'] == '0' || addressData['userInfo']['building_num'] === 0 || !addressData['userInfo']['building_num'] )?'':addressData['userInfo']['building_num']+", ";
                    personalAddress += (addressData['userInfo']['street'] == 'NULL' || addressData['userInfo']['street'] == '0' || addressData['userInfo']['street'] === 0 || !addressData['userInfo']['street'])?'':addressData['userInfo']['street'] + ',<br/>';
                    personalAddress += (addressData['userInfo']['city'] == 'NULL' || addressData['userInfo']['city'] == '0' || addressData['userInfo']['city'] === 0 || !addressData['userInfo']['city'])?'':addressData['userInfo']['city'] + ' - ';
                    personalAddress += (addressData['userInfo']['postcode'] == 'NULL' || addressData['userInfo']['postcode'] == '0' || addressData['userInfo']['postcode'] === 0 || !addressData['userInfo']['postcode'] )?'':addressData['userInfo']['postcode'] + ', ';
                    personalAddress += (addressData['userInfo']['region'] == 'NULL' || addressData['userInfo']['region'] == '0' || addressData['userInfo']['region'] === 0 || !addressData['userInfo']['region'] )?'':addressData['userInfo']['region'] + ', ';
                    personalAddress += (addressData['userInfo']['country_id'] == 'NULL' || addressData['userInfo']['country_id'] == '0' || addressData['userInfo']['country_id'] === 0 || !addressData['userInfo']['country_id'] )?'':addressData['userInfo']['country_id'];

                    $(".selected-address").removeClass("hide");
                    $(".selected-address").html(personalAddress);

                    $('#vat_number').val('');
                    $('#company').val('');
                    $('#building').val(addressData['userInfo']['building_num']);
                    $('#street').val(addressData['userInfo']['street']);
                    $('#city').val(addressData['userInfo']['city']);
                    $('#region').val(addressData['userInfo']['region']);
                    $('#postcode').val(addressData['userInfo']['postcode']);
                    var val = $('#country_id').find("option:contains('"+addressData['userInfo']['country_id']+"')").val()
                    $('#country_id').val(val).trigger('change.select2');
                } else {
                    var businessAddr = '';
                    businessAddr += (addressData['userInfo']['business_name'] == 'NULL' || addressData['userInfo']['business_name'] == '0' || addressData['userInfo']['business_name'] === 0 || !addressData['userInfo']['business_name'])?'':"<b>" + addressData['userInfo']['business_name']+"</b>,<br/>";
                    businessAddr += (addressData['userInfo']['bus_address_building_num'] == 'NULL' || addressData['userInfo']['bus_address_building_num'] == '0' || addressData['userInfo']['bus_address_building_num'] === 0 || !addressData['userInfo']['bus_address_building_num'] )?'':addressData['userInfo']['bus_address_building_num']+", ";
                    businessAddr += (addressData['userInfo']['bus_address_street'] == 'NULL' || addressData['userInfo']['bus_address_street'] == '0' || addressData['userInfo']['bus_address_street'] === 0 || !addressData['userInfo']['bus_address_street'] )?'':addressData['userInfo']['bus_address_street'] + ',<br/>';
                    businessAddr += (addressData['userInfo']['bus_address_city'] == 'NULL' || addressData['userInfo']['bus_address_city'] == '0' || addressData['userInfo']['bus_address_city'] === 0 || !addressData['userInfo']['bus_address_city'] )?'':addressData['userInfo']['bus_address_city'] + ' - ';
                    businessAddr += (addressData['userInfo']['bus_address_postcode'] == 'NULL' || addressData['userInfo']['bus_address_postcode'] == '0' || addressData['userInfo']['bus_address_postcode'] === 0 || !addressData['userInfo']['bus_address_postcode'] )?'':addressData['userInfo']['bus_address_postcode'] + ', ';
                    businessAddr += (addressData['userInfo']['bus_address_region'] == 'NULL' || addressData['userInfo']['bus_address_region'] == '0' || addressData['userInfo']['bus_address_region'] === 0 || !addressData['userInfo']['bus_address_region'] )?'':addressData['userInfo']['bus_address_region'] + ', ';
                    businessAddr += (addressData['userInfo']['bus_address_country_id'] == 'NULL' || addressData['userInfo']['bus_address_country_id'] == '0' || addressData['userInfo']['bus_address_country_id'] === 0 || !addressData['userInfo']['bus_address_country_id'] )?'':addressData['userInfo']['bus_address_country_id'] + ', <br/>';
                    businessAddr += (addressData['userInfo']['vat_number'] == 'NULL' || addressData['userInfo']['vat_number'] == '0' || addressData['userInfo']['vat_number'] === 0 || !addressData['userInfo']['vat_number'] )?'':'' + addressData['userInfo']['vat_number'];

                    $(".selected-address").removeClass("hide");
                    $(".selected-address").html(businessAddr);

                    $('#vat_number').val(addressData['userInfo']['vat_number']);
                    $('#company').val(addressData['userInfo']['business_name']);
                    $('#building').val(addressData['userInfo']['bus_address_building_num']);
                    $('#street').val(addressData['userInfo']['bus_address_street']);
                    $('#city').val(addressData['userInfo']['bus_address_city']);
                    $('#region').val(addressData['userInfo']['bus_address_region']);
                    $('#postcode').val(addressData['userInfo']['bus_address_postcode']);
                    var val = $('#country_id').find("option:contains('"+addressData['userInfo']['bus_address_country_id']+"')").val()
                    $('#country_id').val(val).trigger('change.select2');
                }
            }
        });
    </script>
@endsection
