@extends('layouts.frontend-new', [
    "title" => "CART",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Cart"
        ]
    ]
])

@section('styles')

    <!--Internal  Nice-select css  -->
    <link href="{{asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>

    <!-- Internal Select2 css -->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <style>
        .btn-white:disabled {
            background-color: #fff!important;
            color: #323251!important;
            border-color: #e9e9ff82!important;
        }
        input,
        textarea {
            border: 1px solid #eeeeee;
            box-sizing: border-box;
            margin: 0;
            outline: none;
            padding: 10px;
        }

        input[type="button"] {
            -webkit-appearance: button;
            cursor: pointer;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .input-group {
            clear: both;
            margin: 15px 0;
            position: relative;
        }

        .input-group input[type='button'] {
            background-color: #eeeeee;
            min-width: 38px;
            width: auto;
            transition: all 300ms ease;
        }

        .input-group .button-minus,
        .input-group .button-plus {
            font-weight: bold;
            height: 38px;
            padding: 0;
            width: 38px;
            position: relative;
        }

        .input-group .quantity-field {
            position: relative;
            height: 38px;
            left: -6px;
            text-align: center;
            width: 62px;
            display: inline-block;
            font-size: 13px;
            margin: 0 0 5px;
            resize: vertical;
        }

        .button-plus {
            left: -13px;
        }

        input[type="number"] {
            -moz-appearance: textfield;
            -webkit-appearance: none;
        }
    </style>
@endsection


@section('content')
    <section class="content">
        <!-- Default box -->
        <div id="cart-data-list">
            <div class="cart-data">
                @if(!empty($products))
                    <div class="row" id="product-list">
                        <div class="col-lg-12 col-xl-9 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Shopping Cart-->
                                    <input type="hidden" value="{{$cashback_id}}" name="cb_type" />
                                    <div class="product-details table-responsive text-nowrap">
                                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="text-start">PRODUCT</th>
                                                <th class="w-150">QUANTITY</th>
                                                <th>PRICE</th>
                                                <th>SUBTOTAL</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($products as $product)
                                                <tr id="{{$product['cart_id']}}">
                                                    <td class="product-name">
                                                        <a href="@if($product['sku'] !=  'NTTP1') {{Url('product/'.$product['id'])}} @endif">{{$product['name']}}</a>
                                                        @if($product['bot'] > 0)
                                                            <select required class="form-control required" style="width: 100%;" id="bot-price" tabindex="-1" aria-hidden="true">
                                                                @if(!empty($final_price))
                                                                    @foreach($final_price as $key=>$value)
                                                                        <option value="{{$key . "#" .$value}}" {{ $product['bot'] == $key ? 'selected="selected"' : '' }}>up to {{$key}} bots / €{{ number_format($value, 2, ',')}} for  platform</option>
{{--                                                                        <option value="{{$key . "#" .$value}}" {{ $product['bot'] == $key ? 'selected="selected"' : '' }}>up to {{$key}} bots / €{{ $value}} for  platform</option>--}}
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-group mt-0 handle-counter ms-2" style="flex-wrap: unset">
                                                            <input type="button" value="-" class="button-minus" data-field="quantity" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                                            <input type="number" step="" min="1" value="{{$product['qty']}}" name="quantity" id="quantity_{{$product['id']}}" @if($product['sku'] !=  'NTBOT')  disabled @endif class="quantity-field productTextInput">
                                                            <input type="button" value="+" class="button-plus" data-field="quantity" @if($product['sku'] !=  'NTBOT') disabled @endif>
                                                        </div>
                                                    </td>
{{--                                                    <td class="text-center text-lg text-medium font-weight-bold  tx-15">€ {{ $product['price'] }}</td>--}}
                                                    <td class="text-center text-lg text-medium font-weight-bold  tx-15">€ {{ number_format($product['price'] , 2, ',')}}</td>
{{--                                                    <td class="text-center text-md-right">€ {{ $product['subtotal'] }}</td>--}}
                                                    <td class="text-center text-md-right">€ {{ number_format($product['subtotal'] , 2, ',') }}</td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-danger-light delete-item" href="javascript:void(0);" data-id="{{$product['cart_id']}}" data-product="{{$product['sku']}}" data-product-id="{{$product['id']}}"><i class="fe fe-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="shopping-cart-footer bd-0">
                                        {{-- <div class="column">
                                            <a href="{{Url('product/'.$cashback_product)}}" @if($cashback_id != 0)class="hide"@endif id="cashback">I want to buy cashback licenses</a>
                                        </div> --}}
                                        <div class="column">
                                            <a class="btn btn-secondary" href="{{ route('frontend.shop') }}"><i class="fe fe-corner-up-left  mx-2"></i>Back to Shopping</a>
                                            <button class="btn btn-primary update_cart" name="update_cart" value="Update Cart" aria-disabled="false"><i class="fe fe-refresh-cw mx-2"></i>Update Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card addCashbackBanner">
                                <div class="card-header">
                                <h5>ADD PRODUCTS TO YOUR ORDER</h5>
                                <hr>
                                <img src="{{ asset('assets/img/image.png') }}" alt="user-avatar" class="img-circle img-fluid">
                                <a href="{{Url('product/'.$cashback_product)}}" id="cashback" class="btn btn-secondary orderLicenceBtn"  aria-disabled="false" style=""><h6>CONTINUE ORDERING LICENSES</h6></a><br/>
                                <a href="#" class="btn btn-primary tellMeMore" aria-disabled="false" ><h6> TELL ME MORE</h6></a>&nbsp;
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12 col-xl-3 col-md-12">
                            <div class="card custom-card cart-details">
                                <div class="card-body">
                                    <h5 class="mb-3 font-weight-bold tx-14">CART TOTALS</h5>
                                    <dl class="dlist-align">
                                        <dt class="">Subtotal (Excl VAT)</dt>
{{--                                        <dd class="text-end ms-auto">€ <span id="sub-total">{{ $order_total['subtotal'] }}</span></dd>--}}
                                        <dd class="text-end ms-auto">€ <span id="sub-total">{{ number_format($order_total['subtotal'] , 2, ',') }}</span></dd>
                                    </dl>
                                    <dl class="dlist-align">
                                        <dt class="">Vat@21%</dt>
{{--                                        <dd class="text-end ms-auto">€ <span id="vat">{{ $order_total['vat']}}</span></dd>--}}
                                        <dd class="text-end ms-auto">€ <span id="vat">{{ number_format($order_total['vat'] , 2, ',') }}</span></dd>
                                    </dl>
                                    <dl class="dlist-align" style="font-size: 17px">
                                        <dt>Total Amount</dt>
{{--                                        <dd class="text-end  ms-auto tx-20"><strong>€ <span id="grand-total">{{ $order_total['grand_total']  }}</span></strong></dd>--}}
                                        <dd class="text-end  ms-auto tx-20"><strong>€ <span id="grand-total">{{ number_format($order_total['grand_total'] , 2, ',') }}</span></strong></dd>
                                    </dl>
                                </div>
                                <div class="card-footer">
                                    <div class="column"><a href="{{Url('checkout')}}" class="btn btn-outline-primary">Proceed to checkout</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-solid">
                                <div class="card-body" style="text-align: center">
                                    <h5>Oops! Your Cart is empty.</h5>
                                    <a href="{{ Url("shop")}}" class="btn btn-primary">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row hide" id="no-product">
            <div class="col-md-12">
                <div class="card card-solid">
                    <div class="card-body" style="text-align: center">
                        <h5>Oops! Your Cart is empty.</h5>
                        <a href="{{ Url("shop")}}" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <!-- Internal HandleCounter js -->
    <script src="{{asset('assets/js/handleCounter.js')}}"></script>

    <!-- Internal Select2.min js -->
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>

    <!-- Internal Nice-select js-->
    <script src="{{asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(e)  {
            <?php
            if($cashback_id != 0){
                echo "$('.addCashbackBanner').css('display', 'none');";
            }else{
                echo "$('.addCashbackBanner').css('display', 'block');";
            }
            ?>
            $(document).on('click', '.button-plus', function(e) {
                incrementValue(e);
            });
            $(document).on('click', '.button-minus', function(e) {
                decrementValue(e);
            });
            $(".qty").keyup(function() {
                var priceAmount = this.value;
                var product_price = $('.originalPrice').val();
                var price = this.value * parseFloat(product_price);
                price = price + price * 0.21;
                $('#product_price').text(price.toFixed(2))
                $(this).closest("div").find(".subTotal").val(parseInt($(this).val()) * priceAmount)
            });

            $(function () {
                $("#tradingPlatform").click(function () {
                    if ($(this).is(":checked")) {
                        $("#botPrice").show();

                    } else {
                        $("#botPrice").hide();
                        var platform_price = 0;
                        var qty = parseInt($('.qty').val());
                        var product_original_price = $('.originalPrice').val();
                        var price = qty * parseFloat(product_original_price);
                        price = price + price * 0.21;
                        var final_price= platform_price + price;
                        $('#product_price').text(final_price.toFixed(2));
                    }
                });
            });
        });
        function incrementValue(e) {
            e.preventDefault();
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

            if (!isNaN(currentVal)) {
                parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
                var product_price = $('.originalPrice').val();
                var price = (currentVal + 1) * parseFloat(product_price);
                price = price + price * 0.21;
                $('#product_price').text(price.toFixed(2))
            } else {
                parent.find('input[name=' + fieldName + ']').val(0);
            }
        }

        function decrementValue(e) {
            e.preventDefault();
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
            if (!isNaN(currentVal) && currentVal > 1) {
                parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                var product_price = $('.originalPrice').val();
                var price = (currentVal - 1) * parseFloat(product_price);
                price = price + price * 0.21;
                $('#product_price').text(price.toFixed(2));
            } else {
                parent.find('input[name=' + fieldName + ']').val(1);
            }
        }

        $('body').on('click','.delete-item',function () {
            var id = $(this).attr("data-id");
            var sku = $(this).attr("data-product");
            var product_id = $(this).attr("data-product-id");
            $.ajax({
                headers: {'x-csrf-token': '{{ csrf_token() }}' },
                method: 'POST',
                url: '<?php echo Url("delete-cart")?>',
                data: { id: id ,sku : sku},
                success: function(data) {
                    if(data.token == 1) {
                        $('#' + id).remove();
                        if(product_id == {{$cashback_product}}){
                            $('#cashback').removeClass("hide");
                        }
                        if(data.order_total.grand_total == 0){
                            $('#product-list').remove();
                            $('#no-product').removeClass('hide');
                        }
                        if(data.cashback_id == 0){
                            $('.addCashbackBanner').css('display', 'block');
                        }else{
                            $('.addCashbackBanner').css('display', 'none');
                        }
                        if((sku == "NTBOT") && ({{$upgrade}} == 0)){
                            $('#' + {{$platform_product}}).remove();
                        }
                        $('#sub-total').html(data.order_total.subtotal);
                        $('#vat').html(data.order_total.vat);
                        $('#cart-quantity').remove();
                        $(".utit_cart_icon").html('<i class="fe fe-shopping-cart tx-40 cart-badge" id="cart-quantity" style="font-size:20px;padding: 0" value='+ data.total_qty +'></i>');                        $('#grand-total').html(data.order_total.grand_total);
                    }
                }
            });
        });
        $('body').on('click','.update_cart',function () {
            var qty = $("#quantity_{{$bot_id}}").val();
            var platform = $('#bot-price').val();

            $.ajax({
                headers: {'x-csrf-token': '{{ csrf_token() }}' },
                method: 'POST',
                url: '<?php echo Url("update-cart")?>',
                data: { bot_qty: qty, bot_id : {{$bot_id}} , platform : platform},
                success: function(data) {
                    var data = JSON.parse(data);

                    if(data.token == 1) {
                        $('.cart-data').remove();
                        $('#cart-quantity').remove();
                        $(".utit_cart_icon").html('<i class="fe fe-shopping-cart tx-40 cart-badge" id="cart-quantity" style="font-size:20px;padding: 0" value='+ data.total_qty +'></i>');
                        $("#cart-data-list").html(data.data);
                        if(data.cashback_id != 0){
                            $('.addCashbackBanner').css('display', 'none');
                        }else{
                            $('.addCashbackBanner').css('display', 'block');
                        }
                    }
                }
            });
        });
    </script>
@endsection
