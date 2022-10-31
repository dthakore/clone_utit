@extends('layouts.frontend',[
    "title" => "",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "#"
        ],
        [
            "title" => "Billing"
        ]
    ]
])
<style>
    #termscondition::after {
        content:unset !important;
        color: red;
    }
    .content-wrapper {
        height: unset !important;
    }
</style>
@section('content')


    <div class="">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Order Details
                </div>
                <div class="card-body">
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
                        <div class="form-group">
                            <div class="row">

                                <div class="col-lg-6">
                                    <h5>Billing Info</h5>
                                    <hr>
                                    <div id="personalAddDetail" style="">
                                        <div class="personalAddressForm" style="margin-top: 15px">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 required" for="first_name">First Name
                                                        </label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control form-control-line" type="text" name="first_name" id="first_name" value="{{$user->first_name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 required" for="last_name">Last name</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control form-control-line">
                                                            <input type="hidden" name="order_status" value="pending">
                                                            <input type="hidden" name="user_id" id="user_id" value="<?= auth()->user()->id; ?>">
                                                            <input type="hidden" name="products" id="products" value='<?= json_encode($products) ?>'>
                                                            <input type="hidden" name="payment_status" class="payment_status" value="0">
                                                            {{--<input type="hidden" name="item_qty" value="1">--}}
                                                            {{--<input type="hidden" name="item_disc" value="0">--}}
                                                            {{--<input type="hidden" name="item_price" value="<?= $product['price']?>">--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="required col-md-12" for="email">Email Address</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control form-control-line" type="text" name="email" id="email" value="{{$user->email}}">
                                                        </div>
                                                    </div>
                                                </div
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="radio" checked class="billing_info" id="billing_info" value="1" name="billing_info">
                                                            <label class="form-check-label" for="billing_info">Personal</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="radio"  class="billing_info" id="billing_mode2" value="2" name="billing_info">
                                                            <label class="form-check-label" for="billing_mode2">Business</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="personal">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6 required" for="company">Company</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="company" id="company" value="" class="form-control form-control-line">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6 required" for="vat">Vat Number</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="vat_number" id="vat_number" value="" class="form-control form-control-line">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="business-detail">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="required col-md-6" for="building">Building
                                                                </label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control form-control-line" type="text" name="building" id="building_no" value="{{$user->building_num}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6 required" for="street">Street</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="street" id="street" value="{{$user->street}}" class="form-control form-control-line">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6 required" for="region">Region</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="region" id="region" value="{{$user->region}}" class="form-control form-control-line">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6 required" for="city">City</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="city" id="city" value="{{$user->city}}" class="form-control form-control-line">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6 required" for="porstcode">Postcode</label>
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="postcode" id="postcode" value="{{$user->postcode}}" class="form-control form-control-line">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="col-md-6" for="country">Country</label>
                                                                <div class="col-sm-12">
                                                                    <select name="country_id" id="personal-country-select" class="form-control form-control-line">
                                                                        @foreach($countries as $id => $entry)
                                                                            <option value="{{ $id }}" @if($id == $user->country_id) selected @endif >{{ $entry }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-lg-6">
                                        <div>
                                            <h5>Payment Details</h5>
                                            <hr>
                                            <div class="row">
                                                @if($stripe->is_active == 1)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="radio"  class="payment_mode" id="payment_mode2" value="2" name="payment_mode">
                                                            <label class="form-check-label" for="payment_mode2"> {{$stripe->frontend_label}} </label>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($bank_transfer->is_active == 1)
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="radio"   class="payment_mode" id="payment_mode" value="1" name="payment_mode">
                                                            <label class="form-check-label" for="payment_mode"> {{$bank_transfer->frontend_label}} </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class=" stripe-container">
                                                <ul class="nav nav-tabs customtab" role="tablist" id="stripe-payment-methods">
                                                    <li class="nav-item select_stripe_payment" data-method_type="card"><a class="nav-link  active" data-toggle="tab" href="#card" data-name="card" role="tab" aria-expanded="false" style="padding: 0"><img src="{{ asset('img/card.png') }}" alt="homepage" style="max-width: 144px;"></a></li>
                                                    <li class="nav-item select_stripe_payment" data-method_type="giropay"><a class="nav-link" data-toggle="tab" href="#giropay" data-name="giropay" role="tab" aria-expanded="true" style="padding: 6px"><img src="{{ asset('img/Giropay.svg.png') }}" alt="homepage" style="max-width: 100px;"></a></li>
                                                    <li class="nav-item select_stripe_payment" data-method_type="bancontact"><a class="nav-link" data-toggle="tab" href="#bancontact" data-name="bancontact" role="tab" aria-expanded="true" style="padding: 6px"><img src="{{ asset('img/bancontact.png') }}" alt="homepage" style="max-width: 100px;"></a></li>
                                                    <li class="nav-item select_stripe_payment" data-method_type="ideal"><a class="nav-link" data-toggle="tab" href="#ideal" data-name="ideal" role="tab" aria-expanded="true" style="padding: 6px"><img src="{{ asset('img/ideal.png') }}" alt="homepage" style="max-width: 100px;"></a></li>
                                                </ul>
                                                <div class="tab-content" style="height: 230px">
                                                    <div class="tab-pane active stripe-gateway-tab" id="card" role="tabpanel"
                                                            aria-expanded="false">
                                                        <div class='form-row row mt-3'>
                                                            <div class='col-xs-12 col-lg-6 form-group'>
                                                                <label class='control-label required'>Name on Card</label>
                                                                <input class='form-control card-name' type='text'>
                                                            </div>
                                                            <div class='col-xs-12 col-lg-6 form-group '>
                                                                <label class='control-label required'>Card Number</label>
                                                                <input class='form-control card-num' type='text'>
                                                            </div>
                                                        </div>

                                                        <div class='form-row row'>
                                                            <div class='col-xs-12 col-md-4 form-group cvc '>
                                                                <label class='control-label required'>CVC</label>
                                                                <input  class='form-control card-cvc' placeholder='e.g 595'
                                                                    size='4' type='text'>
                                                            </div>
                                                            <div class='col-xs-12 col-md-4 form-group expiration '>
                                                                <label class='control-label required'>Expiration Month</label> <input
                                                                    class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                                            </div>
                                                            <div class='col-xs-12 col-md-4 form-group expiration '>
                                                                <label class='control-label required'>Expiration Year</label> <input
                                                                    class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                                            </div>
                                                        </div>

                                                        <div class='form-row row'>
                                                            <div class='col-md-12 hide error form-group'>
                                                                <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                    <div class="tab-pane stripe-gateway-tab" id="giropay" role="tabpanel" aria-expanded="true">
                                                        <div class="tab-pane p-20 stripe-gateway-tab" role="tabpanel" aria-expanded="true">
                                                        <!-- giropay -->
                                                        <div class='form-row row'>
                                                            <div class='col-xs-12 col-lg-6 form-group'>
                                                                <label class='control-label required' for='name'> Name </label>
                                                                <input class='form-control giropay_name' type='text' id="name" name="name">
                                                            </div>
                                                        </div>
                                                            <!-- Used to display form errors. -->
                                                            <div id="error-message" role="alert"></div>
                                                        <!-- end giropay -->
                                                        </div> <br>

                                                    </div>
                                                    <div class="tab-pane stripe-gateway-tab" id="bancontact" role="tabpanel" aria-expanded="true">
                                                        <!-- bancontact -->
                                                        <div class='form-row row'>
                                                            <div class='col-xs-12 col-lg-6 form-group'>
                                                                <label class='control-label required' for='name'> Name </label>
                                                                <input class='form-control bancontact_name' type='text' id="name" name="name">
                                                            </div>
                                                        </div>
                                                        <!-- end bancontact -->
                                                    </div>
                                                    <div class="tab-pane stripe-gateway-tab" id="ideal" role="tabpanel" aria-expanded="true">
                                                        <!-- ideal -->
                                                        <div class="form-row row">
                                                            <div class='col-xs-12 col-lg-6 form-group'>
                                                                <label class='control-label required' for="accountholder-name">
                                                                Name
                                                                </label>
                                                                <input class='form-control' id="accountholder-name"  name="accountholder-name">
                                                            </div>
                                                        </div>

                                                        <div class="form-row row">
                                                            <div class='col-xs-12 col-lg-6 form-group'>
                                                                <label class='control-label required' for="ideal-bank-element">
                                                                iDEAL Bank
                                                                </label>
                                                                <div id="ideal-bank-element" class="field" style="width: 30em">
                                                                <!-- A Stripe Element will be inserted here. -->
                                                                </div>
                                                                <div id="error-message" role="alert"></div>
                                                            </div>
                                                        </div>
                                                        <!-- end ideal -->
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row bank-detail">
                                            <div class="col-sm-12">
                                                <p>Please deposit the license amount of
                                                    <strong><span id="amountPayable" class="amount-payable">€{{$order_total['grand_total']}}</span></strong>
                                                    to
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p>
                                                            <strong>Account Name: </strong>Force
                                                            International<br>
                                                            <strong>Account No. EURO: </strong>0689 0467
                                                            8308<br>
                                                            <strong>IBAN EURO: </strong>BE63 0689 0467 8308<br>
                                                            <strong>Swift/BIC Code: </strong>GKCCBEBB<br>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>
                                                            <strong>Beneficiary Bank:</strong>
                                                            Belfius Bank SA/NV<br>
                                                            Boulevard Pachecho 44<br>
                                                            1000 Brussels<br>
                                                            BELGIUM<br>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <h5>Order Summary</h5>
                                    <table class="table table-striped  my-order" width="100%" border="0"
                                            cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($products as $product):?>
                                        <tr>
                                            <td>
                                                <div class="order-pro">
                                                    <img id="step4_prd_img"
                                                            src="<?=Illuminate\Support\Facades\Storage::url($product['image'])?>"
                                                            width="80">
                                                    <div class="order-dt">
                                                        <h6 class="pink m-0"><strong><span id=""><?= $product['name'] ?></span></strong>
                                                        </h6>
                                                        <span><?= $product['comment']!=''? $product["comment"]:' ' ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td id="checkout-qty"><?= $product['qty'] ?></td>
                                            <td><strong class="bold" id="checkout-total">€<?= $product['price']*$product['qty'] ?></strong>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <table class="table sub-total bill" style="max-width:310px" border="0" cellspacing="0"
                                    cellpadding="0">
                                    <tbody>
                                    <tr>
                                    <td>Subtotal (Excl VAT):</td>
                                    <td><strong id="check-subtotal">
                                            € <?php echo $order_total['subtotal']; ?></strong></td>
                                    </tr>
                                    <tr>
                                    <td id="vat_percent_html_step4">Vat@21%</td>
                                    <td><strong id="vat_amount_html_step4">€ <?php echo $order_total['Vat']; ?></strong></td>
                                    </tr>
                                    <tr class="total">
                                    <td>Total Amount:</td>
                                    <td>
                                        <strong id="total_amount_html_step4">
                                            € <?php echo $order_total['grand_total']; ?>
                                        </strong>
                                        <input type='hidden' name="grand_total" id="grand_total" value="<?php echo $order_total['grand_total']; ?>"/>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <div id="errterms"></div>
                                            <input type="checkbox"  class="required" id="termscondition" name="terms">
                                            <label class="form-check-label" for="exampleCheck1"> I agree to the </label> <a class="success required" data-toggle="modal" data-target="#terms" data-whatever="@mdo">  Terms and Conditions</a>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" id="order_submit">
                                                Place Order
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Terms & Conditions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-funds-form">
                            <div class="form-group">
                                <p>I agree that the service implementation can start immediately after I have made my payment and therefore I waive the right to ask for a refund. </p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
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
    $(document).ready(function () {
        var stripe = Stripe('<?php echo config("app.STRIPE_KEY"); ?>');
        var elements = stripe.elements();

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

        @if(isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded')
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
                url: '{{ url('/submit') }}',
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
                success: function (result) {
                    if(result.message == 'success'){
                        window.location.href = "{{ url('/success') }}/" +result.orderId;
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
        $(".stripe-container").hide();
        $(".bank-detail").hide();
        $(".personal").hide();
        $("#payment_mode2").prop('checked', true);

        $(".select_stripe_payment").click(function() {
            var payment_type = $(this).data('method_type')
            if(payment_type === 'card'){
                $('.giropay_name').val('')
                $('.bancontact_name').val('')
            }
            if(payment_type === 'giropay'){
                $('.card-name').val('')
                $('#accountholder-name').val('')
                $('.card-num').val('')
                $('.card-cvc').val('')
                $('.card-expiry-month').val('')
                $('.card-expiry-month').val('')
                $('.card-expiry-year').val('')
                $('.bancontact_name').val('')

            }
            if(payment_type === 'bancontact'){
                $('.giropay_name').val('')
                $('#accountholder-name').val('')
                $('.card-name').val('')
                $('.card-num').val('')
                $('.card-cvc').val('')
                $('.card-expiry-month').val('')
                $('.card-expiry-month').val('')
                $('.card-expiry-year').val('')
            }
            if(payment_type === 'ideal'){
                $('.giropay_name').val('')
                $('.bancontact_name').val('')
                $('.card-name').val('')
                $('.card-num').val('')
                $('.card-cvc').val('')
                $('.card-expiry-month').val('')
                $('.card-expiry-month').val('')
                $('.card-expiry-year').val('')
            }
        });

        var payment_modes = $(".payment_mode").val();
        if(payment_modes == 1){
            $(".bank-detail").show();
            $("#payment_mode").prop('checked', true);
            $(".stripe-container").hide();
        }

        var payment_mode2 = $(".payment_mode").val();
        if(payment_mode2 == 2){
            $(".stripe-container").show();
        }

        $(".payment_mode").click(function() {
            var value = $(this).val();
            if(value == 1){
                $(".stripe-container").hide();
                $(".bank-detail").show();
                $(".payment_status").val(0);
            }
            if(value == 2){
                $(".stripe-container").show();
                $(".bank-detail").hide();
                $(".payment_status").val(2);
            }
        });
        $(".billing_info").click(function() {
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
        function stripeRes(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
                formValid = true;
            } else {
                var token = response['id'];
                // $form.find('input[type=text]').empty();
                var $form = $("#checkout_form");
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

                var form_data = new FormData(document.getElementById("checkout_form"));
                // $("#order_submit").attr('disabled', 'disabled');
                    $.ajax({
                        url: '{{ url('/submit') }}',
                        type: 'POST',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function (res) {
                        // $('div.m-section__content').block();
                        },
                        success: function (res) {
                            var result = JSON.parse(res);
                            if(result.message == 'success'){
                                window.location.href = '{{ url('/success') }}/'+result.orderId;
                            }else{
                                $('.error').removeClass('hide').find('.alert').text(result.message);
                            }

                        }
                    });

                    }
            }

        $("#checkout_form").validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                city: {
                    required: true,
                },
                region: {
                    required: true,
                },
                country: {
                    required: true,
                },
                email: {
                    required: true,
                },
                building_no: {
                    required: true,
                },
                company: {
                    required: true,
                },
                vat_number: {
                    required: true,
                },
                terms:{
                    required: true,
                }
            },
            messages: {
                terms: {
                    required: "Please agree to Terms and Conditions"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "terms") {
                    $("#errterms").append(error);

                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function (form) {
                //e.preventDefault();
                var form_data = new FormData(document.getElementById("checkout_form"));
                var $payment_mode = $('.payment_mode:checked').val()
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
                if($payment_mode  == 1){
                    $.ajax({
                        url: '{{ url('/submit') }}',
                        type: 'POST',
                        data: form_data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function (res) {
                        // $('div.m-section__content').block();
                        },
                        success: function (res) {
                            var result = JSON.parse(res);
                            window.location.href = '{{ url('/success') }}/'+result.orderId;
                        }
                    });
                }else{
                    var giropay_name = $('.giropay_name').val()
                    var bancontact_name = $('.bancontact_name').val()
                    var ideal_name = $('#accountholder-name').val()
                    var card_name = $('.card-name').val()
                    var grand_total = $('#grand_total').val()
                    if(giropay_name !== ''){
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
                            return_url: "{{Url('checkout')}}",
                        }
                        ).then(function(result) {
                            if (result.error) {
                                console.log(result.error)
                            }
                        });
                    }
                    if(bancontact_name !== ''){
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
                            return_url: "{{Url('checkout')}}",
                        }
                        ).then(function(result) {
                            if (result.error) {
                                console.log(result.error)
                            }
                        });
                    }
                    if(ideal_name !== ''){
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
                            return_url: "{{Url('checkout')}}",
                        }
                        ).then(function(result) {
                            if (result.error) {
                                console.log(result.error)
                            }
                        });
                    }
                    if(card_name !== ''){
                        setCookie('payment_method_types', 'card');
                        var $form = $(".stripe-payment"),
                        inputVal = ['input[type=email]', 'input[type=password]',
                            'input[type=text]','input[type=checkbox]', 'input[type=file]',
                            'textarea',
                        ].join(', '),
                        $inputs = $form.find('.required').find(inputVal),
                        $errorStatus = $form.find('div.error'),
                        $payment_mode = $('.payment_mode:checked').val(),
                        valid = true;
                        if($payment_mode == 2){
                            $errorStatus.addClass('hide');

                            $('.has-error').removeClass('has-error');
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
                }

                return false; // required to block normal submit since you used ajax
            }
        });
    });
</script>
@endsection
