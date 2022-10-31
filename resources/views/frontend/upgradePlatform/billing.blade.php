@extends('layouts.guest-checkout',[
    "title" => "CHECKOUT",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Checkout"
        ]
    ]
])
@section('styles')

    <!--Internal  Nice-select css  -->
    <link href="{{asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
    <style>
        .wizard>.actions>ul>li:last-child a {
            display: none!important;
        }
        .product-img{
            height: 85px!important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-8 mx-auto">
                            <form id="checkout_form" enctype="multipart/form-data" _lpchecked="1" class="stripe-payment" data-cc-on-file="false" data-stripe-publishable-key="{{ config('app.STRIPE_KEY') }}" id="stripe-payment" method="get" onsubmit="return false">
                                {{--@method('POST')--}}
                                @csrf
                                {{ Request::get('a') }}
                                @if(isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded')
                                    <input type="hidden" name="payment_intent" id="payment_intent" value="{{ $_GET['payment_intent'] }}">
                                    <input type="hidden" name="payment_intent_client_secret" id="payment_intent_client_secret" value="{{ $_GET['payment_intent_client_secret'] }}">
                                @endif
                                @if(isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'failed')
                                    <div class="form-group">
                                        <div class="alert alert-danger">
                                            There is Error in payment. Please Try Again.
                                        </div>
                                    </div>
                                    <input type="hidden" name="payment_intent" id="payment_intent" value="{{ $_GET['payment_intent'] }}">
                                    <input type="hidden" name="payment_intent_client_secret" id="payment_intent_client_secret" value="{{ $_GET['payment_intent_client_secret'] }}">
                                @endif
                                <input type="hidden" name="order_status" value="pending">
                                <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
                                <input type="hidden" name="products" id="products" value='<?= json_encode($products) ?>'>
                                <input type="hidden" name="payment_status" class="payment_status" value="0">
                            <div class="checkout-steps wrapper">
                                <div id="checkoutsteps">
                                    <!-- SECTION 1 -->
                                    <h4>Billing</h4>
                                    <section>
                                        <div id="personalAddDetail" class="personalAddressForm" style="">
                                            <h5 class="text-start mb-2">Billing Information</h5>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="firstName">First name</label>
                                                    <input class="form-control" type="text" name="first_name" id="first_name">
                                                    <span class="error hide" id="first_name_error">Please Enter First Name</span>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="lastName">Last name</label>
                                                    <input type="text" name="last_name" id="last_name" class="form-control">
                                                    <span class="error hide" id="last_name_error">Please Enter Last Name</span>
                                                </div>
                                            </div>
                                            <div class="mb-3 form-group">
                                                <label class="required" for="email">Email Address</label>
                                                <input class="form-control" type="text" name="email" id="email">
                                                <span class="error hide" id="email_error">Please Enter Email Address</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <input type="radio" checked class="billing_info" id="billing_info" value="1" name="billing_info">
                                                    <label for="billing_info">Personal</label>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <input type="radio" class="billing_info" id="billing_mode2" value="2" name="billing_info">
                                                    <label class="form-check-label" for="billing_mode2">Business</label>
                                                </div>
                                            </div>
                                            <div class="row personal">
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="company">Company</label>
                                                    <input type="text" name="company" id="company" value="" class="form-control">
                                                    <span class="error hide" id="company_error">Please Enter Company Name</span>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="vat">Vat Number</label>
                                                    <input type="text" name="vat_number" id="vat_number" value="" class="form-control">
                                                    <span class="error hide" id="vat_error">Please Enter Vat Number</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="building">Building</label>
                                                    <input class="form-control" type="text" name="building" id="building_no">
                                                    <span class="error hide" id="building_error">Please Enter Building Number</span>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="street">Street</label>
                                                    <input type="text" name="street" id="street" class="form-control">
                                                    <span class="error hide" id="street_error">Please Enter Street</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="region">Region</label>
                                                    <input type="text" name="region" id="region" class="form-control">
                                                    <span class="error hide" id="region_error">Please Enter Region</span>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="required" for="postcode">Postcode</label>
                                                    <input type="text" name="postcode" id="postcode" class="form-control">
                                                    <span class="error hide" id="postcode_error">Please Enter Postcode</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label class="col-md-6 required" for="city">City</label>
                                                    <input type="text" name="city" id="city" class="form-control">
                                                    <span class="error hide" id="city_error">Please Enter City</span>
                                                </div>
                                                <div class="col-md-6 mb-3 form-group">
                                                    <label for="country">Country</label>
                                                    <select name="country_id" id="personal-country-select" class="form-control">
                                                        @foreach($countries as $id => $entry)
                                                            <option value="{{ $id }}" >{{ $entry }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="error hide" id="country_error">Please Enter Country</span>
                                                </div>
                                            </div>
                                            <hr class="mb-4">
                                        </div>
                                    </section>
                                    <!-- SECTION 2 -->
                                    <h4>Order</h4>
                                    <section>
                                        <h5 class="text-start mb-2">Your Order</h5>
                                        <div class="product">
                                            <?php foreach ($products as $product):?>
                                            <div class="item flex-wrap">
                                                <div class="left">
                                                    <a href="javascript:void(0);" class="thumb radius">
                                                        <img src="{{Illuminate\Support\Facades\Storage::url($product['image'])}}" alt="" class="radius product-img" width="80">
                                                    </a>
                                                    <div class="purchase">
                                                        <h6> <a href="javascript:void(0);">{{$product['name']}}</a> </h6>
                                                        <span><?= $product['comment']!=''? $product["comment"]:' ' ?></span>
                                                        <div class="d-flex flex-wrap  mt-2">
                                                            <div class="mt-2 product-title tx-12">Quantity: {{$product['qty']}} </div>
                                                        </div>
                                                    </div>
                                                </div>
{{--                                                <span class="price tx-20">€ {{  round($product['price']*$product['qty'], 2)}}</span>--}}
                                                <span class="price tx-20">€ {{  number_format($product['price']*$product['qty'], 2, ',')}}</span>
                                            </div>
                                                <?php endforeach; ?>
                                        </div>
                                        <div class="checkout">
                                            <div class="mb-3 subtotal">
                                                <span class="heading">Subtotal (Excl VAT):</span>
{{--                                                <span class="total tx-20 font-weight-bold">€ {{ round($order_total['subtotal'], 2)}}</span>--}}
                                                <span class="total tx-20 font-weight-bold">€ {{ number_format($order_total['subtotal'], 2, ',')}}</span>
                                            </div>
                                            <div class="mb-3 subtotal">
                                                <span class="heading">Vat@21%</span>
{{--                                                <span class="total tx-20 font-weight-bold">€ {{ round($order_total['Vat'], 2)}}</span>--}}
                                                <span class="total tx-20 font-weight-bold">€ {{ number_format($order_total['Vat'], 2, ',')}}</span>
                                            </div>
                                            <div class="mb-3 subtotal">
                                                <span class="heading">Total Amount:</span>
{{--                                                <span class="total tx-20 font-weight-bold">€ {{ round($order_total['grand_total'], 2)}}</span>--}}
                                                <span class="total tx-20 font-weight-bold">€ {{ number_format($order_total['grand_total'], 2, ',')}}</span>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- SECTION 3 -->
                                    <h4>Payments</h4>
                                    <section>
                                        <div class="">
                                            <h5 class="text-start mb-2">Payments</h5>
                                        </div>
                                        <div class="card-pay">
                                            <ul class="tabs-menu nav">
                                                @if($stripe->is_active == 1)
                                                    <li class=""><a href="#stripe" class="active" id="stripe_payment_method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> {{$stripe->frontend_label}}</a></li>
                                                @endif
                                                @if($bank_transfer->is_active == 1)
                                                        <li><a href="#bank-transfer" data-bs-toggle="tab" class="" id="bank_payment_method"><i class="fa fa-university"></i>  {{$bank_transfer->frontend_label}} </a></li>
                                                    @endif
                                            </ul>
                                            <div class="tab-content mt-4">
                                                <div class="tab-pane active show" id="stripe">
                                                    <div class="stripe-container">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="panel panel-primary">
                                                            <div class="tab-menu-heading tabs-menu1 payment_tabs">
                                                            <ul class="nav panel-tabs">
                                                                <li><a class="select_stripe_payment active" data-bs-toggle="tab" href="#card" id="stripe_card" data-method_type="card" data-name="card"><img src="{{ asset('img/card.png') }}" alt="homepage" style="max-width: 144px;height: 58px;"></a></li>
                                                                <li><a class="select_stripe_payment" data-bs-toggle="tab" href="#giropay" id="stripe_giropay" data-method_type="giropay" data-name="giropay"><img src="{{ asset('img/Giropay.svg.png') }}" alt="homepage" style="max-width: 125px;height: 58px;"></a></li>
                                                                <li><a class="select_stripe_payment" data-bs-toggle="tab" href="#bancontact" id="stripe_bancontact" data-method_type="bancontact" data-name="bancontact"><img src="{{ asset('img/bancontact.png') }}" alt="homepage" style="max-width: 125px;height: 58px;"></a></li>
                                                                <li><a class="select_stripe_payment" data-bs-toggle="tab" href="#ideal" id="stripe_ideal" data-method_type="ideal" data-name="ideal"><img src="{{ asset('img/ideal.png') }}" alt="homepage" style="max-width: 100px;height: 58px;"></a></li>
                                                            </ul>
                                                        </div>
                                                        </div>
                                                        <div class="panel-body tabs-menu-body">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active stripe-gateway-tab" id="card" role="tabpanel" aria-expanded="false">
                                                                <div class="form-group">
                                                                    <label class="required">CardHolder Name</label>
                                                                    <input type="text" class="form-control card-name" id="card_holder_name">
                                                                    <span class="error hide" id="card_holder_name_error">Please Enter Card Holder Name</span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="required">Card Number</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control card-num" id="card_number">
                                                                        <span class="input-group-append">
																					<button class="btn btn-primary box-shadow-0" type="button"><i class="fab fa-cc-visa"></i> &nbsp; <i class="fab fa-cc-amex"></i> &nbsp;
																					<i class="fab fa-cc-mastercard"></i></button>
																				</span>
                                                                    </div>
                                                                    <span class="error hide" id="card_number_error">Please Enter Card Number</span>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <div class="form-group expiration">
                                                                            <label class="required">Expiration</label>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control card-expiry-month" id="card-expiry-month" placeholder="MM" size='2'>
                                                                                <input type="text" class="form-control card-expiry-year" id="card-expiry-year" placeholder="YYYY" size='4' >
                                                                            </div>
                                                                            <span class="error hide" id="expiration_error">Please Enter Expiry Month and year</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group cvc">
                                                                            <label class="required">CVC</label>
                                                                            <input class="form-control card-cvc" id="card-cvc" placeholder='e.g 595' size='4' type='text'>
                                                                            <span class="error hide" id="cvc_error">Please Enter CVC</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='form-row row'>
                                                                    <div class='col-md-12 hide errorCard form-group'>
                                                                        <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane stripe-gateway-tab" id="giropay" role="tabpanel" aria-expanded="true">
                                                                <div class="tab-pane p-20 stripe-gateway-tab" role="tabpanel" aria-expanded="true">
                                                                    <!-- giropay -->
                                                                    <div class="form-group">
                                                                        <label class="required" for='name'> Name</label>
                                                                        <input type="text" class="form-control giropay_name" id="giropay_name" name="name">
                                                                        <span class="error hide" id="giropay_card_name_error">Please Enter Name</span>
                                                                    </div>
                                                                    <!-- Used to display form errors. -->
                                                                    <div id="error-message" role="alert"></div>
                                                                    <!-- end giropay -->
                                                                </div> <br>

                                                            </div>
                                                            <div class="tab-pane stripe-gateway-tab" id="bancontact" role="tabpanel" aria-expanded="true">
                                                                <!-- bancontact -->
                                                                <div class="form-group">
                                                                    <label class="required" for='name'> Name</label>
                                                                    <input type="text" class="form-control bancontact_name" id="bancontact_name" name="name">
                                                                    <span class="error hide" id="bancontact_card_name_error">Please Enter Name</span>
                                                                </div>
                                                                <!-- end bancontact -->
                                                            </div>
                                                            <div class="tab-pane stripe-gateway-tab" id="ideal" role="tabpanel" aria-expanded="true">
                                                                <!-- ideal -->
                                                                <div class="form-group">
                                                                    <label class="required" for="accountholder-name">CardHolder Name</label>
                                                                    <input type="text" class="form-control" id="accountholder-name"  name="accountholder-name">
                                                                    <span class="error hide" id="ideal_card_name_error">Please Enter Card Holder Name</span>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label class='required' for="ideal-bank-element">
                                                                        iDEAL Bank
                                                                    </label>
                                                                    <div id="ideal-bank-element" class="field" style="width: 30em;margin-bottom: 150px">
                                                                        <!-- A Stripe Element will be inserted here. -->
                                                                    </div>
                                                                    <div id="error-message" role="alert"></div>
                                                                </div>
                                                                <!-- end ideal -->
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="bank-transfer">
                                                    <p class="mt-4">Please deposit the license amount of
{{--                                                        <strong><span id="amountPayable" class="amount-payable">€{{ round($order_total['grand_total'], 2)}}</span></strong>--}}
                                                        <strong><span id="amountPayable" class="amount-payable">€{{ number_format($order_total['grand_total'], 2, ',')}}</span></strong>
                                                        to
                                                    </p>
                                                    <dl class="card-text">
                                                        <dt>Account Name: </dt>
                                                        <dd> Force International</dd>
                                                    </dl>
                                                    <dl class="card-text">
                                                        <dt>Account No. EURO: </dt>
                                                        <dd> 0689 0467 8308</dd>
                                                    </dl>
                                                    <dl class="card-text">
                                                        <dt>IBAN EUR: </dt>
                                                        <dd>BE63 0689 0467 8308</dd>
                                                    </dl>
                                                    <dl class="card-text">
                                                        <dt>Swift/BIC Code: </dt>
                                                        <dd>GKCCBEBB</dd>
                                                    </dl>
                                                    <dl class="card-text">
                                                        <dt>Beneficiary Bank: </dt>
                                                        <dd>Belfius Bank SA/NV Boulevard Pachecho 44 1000 Brussels BELGIUM</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div id="errterms"></div>
                                            <input type="checkbox" id="termscondition" name="terms">
                                            <label class="form-check-label" for="exampleCheck1"> I agree to the </label> <a class="success required" target="_blank" href="https://support.utradeitrade.com/legal/terms-and-conditions/">  Terms and Conditions</a>
                                            <span class="error hide" id="terms_error">Please agree to Terms and Conditions</span>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary pull-right" type="submit" id="order_submit">
                                                Place Order
                                            </button>
                                        </div>
                                    </section>
                                    <!-- SECTION 4 -->
{{--                                    <h4>Finished</h4>--}}
{{--                                    <section class="text-center">--}}
{{--                                        <div class="">--}}
{{--                                            <h5 class="text-center mb-4">Thanks you for your Order!</h5>--}}
{{--                                        </div>--}}
{{--                                        <svg class="wd-100 ht-100 mx-auto justify-content-center mb-3 text-center" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">--}}
{{--                                            <circle class="path circle" fill="none" stroke="#22c03c" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />--}}
{{--                                            <polyline class="path check" fill="none" stroke="#22c03c" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />--}}
{{--                                        </svg>--}}
{{--                                        <p class="success pl-5 pr-5"><strong>Confirmation e-mail sent to:</strong> {{$orderInfo->email}}</p>--}}
{{--                                        <p class="success pl-5 pr-5"><strong>Order Number:</strong> {{$orderId}}</p>--}}
{{--                                        <p class="success pl-5 pr-5"><strong>Please proceed to Bottrader platform for trading services</strong></p>--}}
{{--                                        <a href="https://bottrader.perpetualmarkets.com/login?email={{$orderInfo->email}}" target="_blank" class="btn waves-effect waves-light btn-rounded btn-primary mt-2" style="margin: auto">Go to Bottrader</a>--}}

{{--                                        <p class="success pl-5 pr-5">Order placed successfully. Meanwhile you can track your order in my order section.</p>--}}
{{--                                    </section>--}}
                                </div>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Jquery-steps js -->
    <script src="{{asset('assets/plugins/checkout-jquery-steps/jquery.steps.min.js')}}"></script>

    <!--Internal  Nice-select js-->
    <script src="{{asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!-- Internal HandleCounter js -->
    <script src="{{asset('assets/js/handleCounter.js')}}"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var formValid = true;
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    function stripeRes(status, response) {
        if (response.error) {
            $('#global-loader').css('display','none');
            $('.errorCard')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
            formValid = true;
        } else {
            var token = response['id'];
            // $form.find('input[type=text]').empty();
            var $form = $("#checkout_form");
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.append("<input type='hidden' name='payment_mode' value='2'/>");

            var form_data = new FormData(document.getElementById("checkout_form"));
            // $("#order_submit").attr('disabled', 'disabled');
            $.ajax({
                url: '{{ url('/upgrade_license/submit') }}',
                type: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (res) {
                    // $('div.m-section__content').block();
                    $('#global-loader').css('display','block');
                },
                success: function (res) {
                    var result = JSON.parse(res);
                    if(result.message == 'success'){
                        window.location.href = '{{ url('/upgrade_license/success') }}/'+result.orderId;
                    }else{
                        $('.error').removeClass('hide').find('.alert').text(result.message);
                    }

                }
            });

        }
    }
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    function delete_cookie(name) {
        document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
    var stripe;
    var elements;
    var idealBank;
    $(window).bind("load", function() {
        // insert your code here
        stripe = Stripe('<?php echo config("app.STRIPE_KEY"); ?>');
        elements = stripe.elements();
        var style = {
            base: {
                padding: '10px 12px',
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a'
            }
        };
        //Mount iDeal Bank details
        idealBank = elements.create('idealBank', {style: style});
        idealBank.mount('#ideal-bank-element');
    });
    $(document).ready(function () {
        $(".personal").hide();

        $('.SelectFieldButton').css('display', 'none');
        @if(isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded')
        $('#global-loader').css('display','block');
        if (window.location.href.indexOf("redirect_status=succeeded") > -1) {
            var user_id = getCookie("user_id");
            var email = getCookie("email");
            var building = getCookie("building");
            var street = getCookie("street");
            var region = getCookie("region");
            var postcode = getCookie("postcode");
            var city = getCookie("city");
            var country_id = getCookie("country_id");
            var payment_method_types = getCookie("payment_method_types");
            var products = getCookie("products");
            var payment_intent = "{{ $_GET['payment_intent'] }}";
            var payment_intent_client_secret = "{{ $_GET['payment_intent'] }}";
            $.ajax({
                url: '{{ url('/upgrade_license/submit') }}',
                type: 'POST',
                headers: {'x-csrf-token': '{{ csrf_token() }}'},
                data: JSON.stringify(
                    {
                        user_id : user_id,
                        email : email,
                        street : street,
                        region : region,
                        postcode : postcode,
                        city : city,
                        country_id : country_id,
                        products : products,
                        payment_mode : 2,
                        billing_info : 2,
                        payment_intent : payment_intent,
                        payment_method_types : payment_method_types,
                        payment_intent_client_secret : payment_intent_client_secret,
                        payment_status : 2,
                        order_status : 2
                    }
                ), // stringyfy before passing
                dataType: 'json', // payload is json
                contentType : 'application/json',
                beforeSend: function (res) {
                    // $('div.m-section__content').block();
                    $('#global-loader').css('display','block');
                },
                success: function (result) {
                    if(result.message == 'success'){
                        window.location.href = "{{ url('/upgrade_license/success') }}/" +result.orderId;
                    }else{
                        $('.error').removeClass('hide').find('.alert').text(result.message);
                    }

                }
            });

        }
        @endif
        @if(isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'failed')
           delete_cookie("user_id");
           delete_cookie("email");
           delete_cookie("building");
           delete_cookie("street");
           delete_cookie("region");
           delete_cookie("postcode");
           delete_cookie("city");
           delete_cookie("country_id");
           delete_cookie("products");
        @endif

        $(document).on('click', '#order_submit', function(e) {

            var terms = $('#termscondition').prop('checked');
            if(terms){
                $('#terms_error').addClass("hide");
            }
            else{
                $('#terms_error').removeClass("hide");
            }
            if($("#stripe_payment_method").hasClass('active')){
                var user_id = $("#user_id").val();
                var email = $("#email").val();
                var building = $("#building_no").val();
                var street = $("#street").val();
                var region = $("#region").val();
                var postcode = $("#postcode").val();
                var city = $("#city").val();
                var country_id = $("#personal-country-select").val();
                var products = $("#products").val();

                setCookie('user_id', user_id);
                setCookie('email', email);
                setCookie('building', building);
                setCookie('street', street);
                setCookie('region', region);
                setCookie('postcode', postcode);
                setCookie('city', city);
                setCookie('country_id', country_id);
                setCookie('products', products);

                if($("#stripe_card").hasClass('active')){
                    var card_holder_name = $('#card_holder_name').val();
                    var card_number = $('#card_number').val();
                    var card_expiry_month = $('#card-expiry-month').val();
                    var card_expiry_year = $('#card-expiry-year').val();
                    var card_cvc = $('#card-cvc').val();
                    if(card_holder_name == ""){
                        $("#card_holder_name_error").removeClass("hide");
                    }
                    else{
                        $("#card_holder_name_error").addClass("hide");
                    }
                    if(card_number == ""){
                        $("#card_number_error").removeClass("hide");
                    }
                    else{
                        $("#card_number_error").addClass("hide");
                    }
                    if(card_expiry_month == "" || card_expiry_year == ""){
                        $("#expiration_error").removeClass("hide");
                    }
                    else{
                        $("#expiration_error").addClass("hide");
                    }
                    if(card_cvc == ""){
                        $("#cvc_error").removeClass("hide");
                    }
                    else{
                        $("#cvc_error").addClass("hide");
                    }

                    if(terms == false || card_holder_name == "" || card_number == "" || card_expiry_month == "" || card_expiry_year == "" || card_cvc == ""){
                        return false;
                    }
                    else{
                        $('#global-loader').css('display','block');
                        setCookie('payment_method_types', 'card');
                        var $form = $(".stripe-payment"),
                            inputVal = ['input[type=email]', 'input[type=password]',
                                'input[type=text]','input[type=checkbox]', 'input[type=file]',
                                'textarea',
                            ].join(', '),
                            $inputs = $form.find('.required').find(inputVal),
                            valid = true;
                        $inputs.each(function (i, el) {
                            var $input = $(el);
                            if ($input.val() === '') {
                                $input.parent().addClass('has-error');
                                $errorStatus.removeClass('hide');
                                formValid= true;
                                //e.preventDefault();
                            }
                        });

                        if (!$form.data('cc-on-file')) {
                            //e.preventDefault();
                            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                            Stripe.createToken({
                                number: $('.card-num').val(),
                                cvc: $('.card-cvc').val(),
                                exp_month: $('.card-expiry-month').val(),
                                exp_year: $('.card-expiry-year').val()
                            }, stripeRes);
                        }
                    }
                }
                if($("#stripe_giropay").hasClass('active')){
                    var giropay_name = $('#giropay_name').val();
                    if(giropay_name == ""){
                        $("#giropay_card_name_error").removeClass("hide");
                    }
                    else{
                        $("#giropay_card_name_error").addClass("hide");
                    }
                    if(terms == false || giropay_name == ""){
                        return false;
                    }
                    else{
                        $('#global-loader').css('display','block');
                        setCookie('payment_method_types', 'giropay');
                        <?php
                        $stripe = new \Stripe\StripeClient( config("app.STRIPE_SECRET"));
                        $intent = $stripe->paymentIntents->create(
                            ['amount' => $order_total['grand_total']*100, 'currency' => 'eur', 'payment_method_types' => ['giropay']]
                        );
                        ?>

                        stripe.confirmGiropayPayment(
                            '{{$intent->client_secret}}',
                            {
                                payment_method: {
                                    billing_details: {
                                        name: giropay_name
                                    }
                                },
                                return_url: "{{Url('upgrade_license/'.base64_encode($user->id))}}",
                            }
                        ).then(function(result) {
                            if (result.error) {
                                console.log(result.error)
                            }
                        });
                    }
                }
                if($("#stripe_bancontact").hasClass('active')){
                    var bancontact_name = $('#bancontact_name').val();
                    if(bancontact_name == ""){
                        $("#bancontact_card_name_error").removeClass("hide");
                    }
                    else{
                        $("#bancontact_card_name_error").addClass("hide");
                    }
                    if(terms == false || bancontact_name == ""){
                        return false;
                    }
                    else{
                        $('#global-loader').css('display','block');
                        setCookie('payment_method_types', 'bancontact');
                        <?php
                        $stripe = new \Stripe\StripeClient( config("app.STRIPE_SECRET"));
                        $intent = $stripe->paymentIntents->create(
                            ['amount' => $order_total['grand_total']*100, 'currency' => 'eur', 'payment_method_types' => ['bancontact']]
                        );
                        ?>
                        stripe.confirmBancontactPayment(
                            '{{$intent->client_secret}}',
                            {
                                payment_method: {
                                    billing_details: {
                                        name: bancontact_name
                                    }
                                },
                                return_url: "{{Url('upgrade_license/'.base64_encode($user->id))}}",
                            }
                        ).then(function(result) {
                            if (result.error) {
                                console.log(result.error)
                            }
                        });
                    }
                }
                if($("#stripe_ideal").hasClass('active')){
                    var ideal_name = $('#accountholder-name').val();
                    if(ideal_name == ""){
                        $("#ideal_card_name_error").removeClass("hide");
                    }
                    else{
                        $("#ideal_card_name_error").addClass("hide");
                    }
                    if(terms == false || ideal_name == ""){
                        return false;
                    }
                    else{
                        $('#global-loader').css('display','block');
                        setCookie('payment_method_types', 'ideal');
                        <?php
                        $stripe = new \Stripe\StripeClient( config("app.STRIPE_SECRET"));
                        $intent = $stripe->paymentIntents->create(
                            ['amount' => $order_total['grand_total']*100, 'currency' => 'eur', 'payment_method_types' => ['ideal']]
                        );
                        ?>
                        stripe.confirmIdealPayment(
                            '{{$intent->client_secret}}',
                            {
                                payment_method: {
                                    ideal: idealBank,
                                    billing_details: {
                                        name: ideal_name
                                    }
                                },
                                return_url: "{{Url('upgrade_license/'.base64_encode($user->id))}}",
                            }
                        ).then(function(result) {
                            if (result.error) {
                                console.log(result.error)
                            }
                        });
                    }
                }
            }
            else{
                if(terms == false){
                    return false;
                }
                else{
                    var form_data = new FormData(document.getElementById("checkout_form"));
                    $.ajax({
                        url: "{{ url('/upgrade_license/submit') }}",
                        type: 'POST',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function (res) {
                            // $('div.m-section__content').block();
                            $('#global-loader').css('display','block');
                        },
                        success: function (res) {
                            var result = JSON.parse(res);
                            window.location.href = '{{ url('/upgrade_license/success') }}/'+result.orderId;
                        }
                    });
                }
            }
        });
        $(document).on('click', '.billing_info', function(e) {
            var value = $(this).val();
            if(value == 1){
                $(".personal").hide();
                $(".business-detail").show();
            }
            if(value == 2){
                $(".personal").show();
                $(".business-detail").show();
            }
        });

        $("#checkoutsteps").steps({
            headerTag: "h4",
            bodyTag: "section",
            transitionEffect: "fade",
            enableAllSteps: !0,
            transitionEffectSpeed: 500,
            onStepChanging: function(e, s, t) {
                if(t >= 1){
                    var first_name = $("#first_name").val();
                    var last_name = $("#last_name").val();
                    var email = $("#email").val();
                    var billing_info = $(".billing_info").prop('checked');
                    var company = $("#company").val();
                    var vat = $("#vat_number").val();
                    var building = $("#building_no").val();
                    var street = $("#street").val();
                    var region = $("#region").val();
                    var postcode = $("#postcode").val();
                    var city = $("#city").val();
                    var country = $("#personal-country-select").val();
                    if(first_name == ""){
                        $("#first_name_error").removeClass("hide");
                    }
                    else{
                        $("#first_name_error").addClass("hide");
                    }
                    if(last_name == ""){
                        $("#last_name_error").removeClass("hide");
                    }
                    else{
                        $("#last_name_error").addClass("hide");
                    }
                    if(email == ""){
                        $("#email_error").removeClass("hide");
                    }
                    else{
                        $("#email_error").addClass("hide");
                    }
                    if(billing_info == false){
                        if(company == ""){
                            $("#company_error").removeClass("hide");
                        }
                        else{
                            $("#company_error").addClass("hide");
                        }
                        if(vat == ""){
                            $("#vat_error").removeClass("hide");
                        }
                        else{
                            $("#vat_error").addClass("hide");
                        }
                    }
                    if(building == ""){
                        $("#building_error").removeClass("hide");
                    }
                    else{
                        $("#building_error").addClass("hide");
                    }
                    if(street == ""){
                        $("#street_error").removeClass("hide");
                    }
                    else{
                        $("#street_error").addClass("hide");
                    }
                    if(region == ""){
                        $("#region_error").removeClass("hide");
                    }
                    else{
                        $("#region_error").addClass("hide");
                    }
                    if(postcode == ""){
                        $("#postcode_error").removeClass("hide");
                    }
                    else{
                        $("#postcode_error").addClass("hide");
                    }
                    if(city == ""){
                        $("#city_error").removeClass("hide");
                    }
                    else{
                        $("#city_error").addClass("hide");
                    }
                    if(country == ""){
                        $("#country_error").removeClass("hide");
                    }
                    else{
                        $("#country_error").addClass("hide");
                    }
                    if((billing_info == false) && (first_name == "" || last_name == "" || email == "" || company == "" || vat == "" || building == "" || street == "" || region == "" || postcode == "" || city == "" || country == "")){
                        return false;
                    }
                    else{
                        if(first_name == "" || last_name == "" || email == "" || building == "" || street == "" || region == "" || postcode == "" || city == "" || country == ""){
                            return false;
                        }
                        else {
                            return 1 === t ? $(".steps ul").addClass("step-2") : $(".steps ul").removeClass("step-2"), 2 === t ? $(".steps ul").addClass("step-3") : $(".steps ul").removeClass("step-3"), 3 === t ? ($(".steps ul").addClass("step-4"), $(".actions ul").addClass("step-last")) : ($(".steps ul").removeClass("step-4"), $(".actions ul").removeClass("step-last")), !0
                        }
                    }
                }
                else{
                    return 1 === t ? $(".steps ul").addClass("step-2") : $(".steps ul").removeClass("step-2"), 2 === t ? $(".steps ul").addClass("step-3") : $(".steps ul").removeClass("step-3"), 3 === t ? ($(".steps ul").addClass("step-4"), $(".actions ul").addClass("step-last")) : ($(".steps ul").removeClass("step-4"), $(".actions ul").removeClass("step-last")), !0
                }

            },
            labels: {
                finish: "Place Order",
                next: "Next",
                previous: "Previous"
            }
        }), $(".wizard > .steps li a").click((function() {
            $(this).parent().addClass("checked"), $(this).parent().prevAll().addClass("checked"), $(this).parent().nextAll().removeClass("checked")
        })), $(".forward").click((function() {
            $("#wizard").steps("next")
        })), $(".backward").click((function() {
            $("#wizard").steps("previous")
        })), $(".checkbox-circle label").click((function() {
            $(".checkbox-circle label").removeClass("active"), $(this).addClass("active")
        })), $("#checkoutsteps .steps").prepend("<div class='checkoutline'></div>")
    });
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/" ></script>
@endsection
