@extends('layouts.frontend-new', [
    "title" => "PRODUCT DETAILS",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Product details"
        ]
    ]
])
@section('styles')
    <link href="{{ asset('css/trip.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/plugins/wizard/steps.css') }}" rel="stylesheet"/>
    <!-- Internal Nice-select css  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css" rel="stylesheet" />
    <style>
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
        .grp1_radio{
            display: none;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #footer {
            flex: 0 0 50px;/*or just height:50px;*/
            margin-top: auto;
        }
    </style>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <?php
        $image_file = "";
        $folder = 0;
        if(isset($product->media[0])){
            $imageArr = $product->media[0]->getAttributes();
            $image_file = $imageArr['file_name'];
            $folder = $imageArr['id'];
        }

        $is_parentProduct = count($child_product);
        $child_price = 0;
        if ($is_parentProduct > 0) {
            $child_price = $child_product['price'];
        }
        $id = $product['id'];
        ?>
        <div class="card card-solid">
            <div class="card-body">
                    @if($product['sku'] == "cbm_cashback")
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <h3 class="d-inline-block d-sm-none product-title mb-1"><?= $product['name']; ?></h3>
                            <div class="col-12 border br-5">
                                <img src="<?= Illuminate\Support\Facades\Storage::url("$folder/$image_file");?>"
                                     class="product-image" alt="Product Image">
                            </div>
                        </div>
                        <div class="col-12 col-sm-8">
                            <h4 class="product-title mb-1">{{$product['name']}}</h4>
                            <p class="text-muted tx-13 mb-1">{{$product['short_description']}}</p>
                            <div class="card-header" id="min_prd_card_header" style="background-color: red; text-align: center; display: none;">
                                <h6 class="m-b-0 text-white" id="min_prd_card_header_text">A minimum of 5
                                    license is required to proceed</h6>
                            </div>
                            <div class="input-group mt-0" id="cashback">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="deposit">Deposit</label>
                                        <input type="number" id="deposit" name="deposit" class="form-control" placeholder="€">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number-of-licenses">Licenses</label>
                                        <input type="number" id="license-count" name="number-of-licenses" class="form-control" style="font-size: small;" placeholder="Number of Licenses">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="bg-white text-center">
                                        <div class="button-group">
                                            <button type="button" id="licenseBtn" onclick="licenseBtnClk()" class="btn waves-effect waves-light btn-primary" style="display: none; margin: auto">Proceed</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-6 disabledDiv" style="display: none">
                                    <div class="card-header" id="fund_card_header"
                                         style="background-color: #52BBA4; text-align: center; display: none;">
                                        <h6 class="m-b-0 text-white">Recommended</h6>
                                    </div>
                                    <div class="card-body bg-white text-center">
                                        <h2>Fund</h2>
                                        <div class="button-group">
                                            <button type="button" id="fundBtn" onclick="fundBtnClk()"
                                                    class="btn waves-effect waves-light btn-rounded btn-primary"
                                                    style="display: none;">Select
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="quantity_price" style="display: none">
                                <h6 class="price">Price Incl. VAT : <span class="mb-0 h3 ms-2">EUR<span id="product_price"><?= round(($product['price'] + $product['price'] * 0.21),2);?>
                            </span></span></h6>
                                <input type="hidden" name="originalPrice" value="<?= $product['price']; ?>" class="originalPrice">
                                <div class="quantity mt-3">
                                    <label>Quantity</label>
                                </div>
                                <div class="input-group mt-0">
                                    <input type="button" value="-" class="button-minus" data-field="quantity">
                                    <input type="number" step="" min="1" value="1" name="quantity" class="quantity-field productTextInput">
                                    <input type="button" value="+" class="button-plus" data-field="quantity">
                                </div>
                                <div class="mt-4">
                                    {{--                            <a class="btn btn-primary" id="buy"--}}
                                    {{--                               href="#">--}}
                                    {{--                                Buy Now--}}
                                    {{--                            </a>--}}
                                    <a class="btn btn-primary" id="cart" href="#">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row trip-table mt-4" id="cbm_licenses-flow" style="display: none">
                        <div class="col-12 col-sm-3">
                            <h4 class="f20">TRADING CAPITAL</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="trading_capital">
                                    <thead>
                                    <tr>
                                        <th>Cluster</th>
                                        <th>Capital Deposit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($product_pricing as $value)
                                        <tr data-step="{{$value['id']}}">
                                            <td>
                                                <input name="group1" type="radio" id="grp1_radio_{{$value['id']}}" class="grp1_radio">
                                                <span style="margin: 27px;">
                                                                @if ($value['is_cluster']){{$value['licenses'] }}@endif
                                                            </span>
                                            </td>
                                            <td>
{{--                                                 &euro; {{$value['licenses'] * env('MinimumNodeAmount') }}--}}
                                                &euro; {{ number_format($value['licenses'] * env('MinimumNodeAmount') , 2, ',')}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <h4 class="f20">UTIT LICENSES</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="cbm_licenses">
                                    <thead>
                                    <tr>
                                        <th>Licenses</th>
                                        <th>License Cost(Excl. VAT)</th>
                                        <th>Price Per License</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($product_pricing as $value)
                                        <tr data-step="{{$value['id']}}">
                                            <td class="grp2_{{$value['id']}}">
                                                <input name="group2" type="radio" id="grp2_radio_{{$value['id']}}" class="grp1_radio">
                                                <span style="margin: 27px;">{{$value['licenses']}}</span>
                                            </td>
                                            <td class="grp2_{{$value['id']}}">
{{--                                                 &euro;{{$value['licenses'] * $value['price_per_license']}}--}}
                                                &euro; {{ number_format($value['licenses'] * $value['price_per_license'] , 2, ',')}}
                                            </td>
                                            <td class="grp2_{{$value['id']}}">
{{--                                                 &euro;{{$value['price_per_license']}}--}}
                                                &euro; {{ number_format($value['price_per_license'] , 2, ',')}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4"></div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <h3 class="d-inline-block d-sm-none product-title mb-1">{{$product['name']}}</h3>
                            <div class="col-12 border br-5">
                                <img src="<?= Illuminate\Support\Facades\Storage::url("$folder/$image_file");?>"
                                     class="product-image" alt="Product Image">
                            </div>
                        </div>
                        <div class="col-12 col-sm-8">
                            <h4 class="product-title mb-1">{{$product['name']}}</h4>
                            <p class="text-muted tx-13 mb-1">{{$product['short_description']}}</p>
{{--                              <h6 class="price">Price Incl. VAT : <span class="mb-0 h3 ms-2">EUR<span id="product_price"><?= round(($product['price'] + $product['price'] * 0.21),2);?>--}}
                             <h6 class="price">Price Incl. VAT : <span class="mb-0 h3 ms-2">EUR<span id="product_price"><?= number_format($product->price + $product->price * 0.21, 2, ',')  ?>
                                      </span></span></h6>
                            <input type="hidden" name="originalPrice" value="<?= number_format($product['price'], 2, ','); ?>" class="originalPrice">
{{--                            <input type="hidden" name="originalPrice" value="<?= $product['price']; ?>" class="originalPrice">--}}
                            <div class="quantity mt-3">
                                <label>Quantity</label>
                            </div>
                            <div class="input-group mt-0">
                                <input type="button" value="-" class="button-minus" data-field="quantity">
                                <input type="number" step="" min="1" value="1" name="quantity" class="quantity-field productTextInput">
                                <input type="button" value="+" class="button-plus" data-field="quantity">
                            </div>
                            {{--<div class="form-group">
                                <label class="required">Select currency pair</label>
                                <select required class="form-control required" style="width: 100%;" id="platform_pair"
                                        tabindex="-1" aria-hidden="true">
                                    <option value="1" selected="selected">BTC/USDT</option><option value="2">BNB/USDT</option><option value="4">ETH/USDT</option><option value="6">SOL/USDT</option><option value="7">AAVE/USDT</option><option value="8">TRX/USDT</option><option value="9">XRP/USDT</option><option value="10">ADA/USDT</option><option value="11">DOT/USDT</option><option value="12">DOGE/USDT</option><option value="13">LTC/USDT</option><option value="14">UNI/USDT</option><option value="15">LUNA/USDT</option><option value="16">BCH/USDT</option><option value="17">ETC/USDT</option><option value="18">LINK/USDT</option><option value="19">MATIC/USDT</option><option value="20">XLM/USDT</option><option value="21">XMR/USDT</option>                                <option  data-select2-id="19"></option>

                                </select>
                            </div> -->--}}

                            @if($has_platform == 0)
                                <p class="vote">Make sure you have sufficient platform for bots</p>
                                <div class="form-group" id="botdata">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="tradingPlatform" checked>
                                    <p>Add trading platform license to trade the selected bots</p>
                                </div>
                                <select required class="form-control required" style="width: 100%;" id="botPrice" tabindex="-1" aria-hidden="true">
                                    <option value="" selected="selected">Please Select</option>
                                    <option value="3#43.496" selected="selected">up to 3 bots / €43,49 for platform</option>
                                    <option value="8#75.49">up to 8 bots / €75,49 for  platform</option>
                                    <option value="15#130">up to 15 bots / €130 for platform</option>
                                    <option value="35#259">up to 35 bots / €259 for platform</option>
                                </select>
                                <div class="error invalid-feedback">Please select atleast one platform</div>
                            </div>
                            @endif
                            <div class="mt-4">
                                {{--                            <a class="btn btn-primary" id="buy"--}}
                                {{--                               href="#">--}}
                                {{--                                Buy Now--}}
                                {{--                            </a>--}}
                                <a class="btn btn-primary" id="cart" href="#">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                        <div class="row row-sm">
                            <div class="col-lg-12 col-md-12">
                                <div class="card productdesc">
                                    <div class="card-body">
                                        <div class="panel panel-primary">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs">
                                                        <li><a href="#description-tab" class="active" data-bs-toggle="tab">Description</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="description-tab">
                                                        <p class="mb-3 tx-13"><?= $product['description']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            </div>
        <!-- /.card-body -->
        <!-- /.card -->

    </section>
<div class="modal fade" id="buyPlatform" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                You need to buy trading platform along with bot
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/trip.min.js') }}"></script>
    <script src="{{ asset('plugins/wizard/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('plugins/wizard/steps.js') }}"></script>
    <script type="text/javascript">
        var product_pricing = "<?= addslashes(json_encode($product_pricing)); ?>";
        var product_pricing_arr = JSON.parse(product_pricing);
        var  licenseNum = deposit = cluster = trip_completed = previous_group_id = is_cluster_selected = 0;
        var min_node_amount = '<?php echo config("app.MinimumNodeAmount"); ?>';

        $(document).ready(function(e)  {
            $(document).on('click', '.button-plus', function(e) {
                incrementValue(e);
            });
            $('.input-group').on('click', '.button-minus', function(e) {
                decrementValue(e);
            });
            $(".productTextInput").keyup(function() {
                if("{{$product['sku']}}" == "cbm_cashback") {
                    touchSpinLicenseChange(this.value);
                }
                else{
                    var priceAmount = this.value;
                    var product_price = $('.originalPrice').val();
                    var price = this.value * parseFloat(product_price);
                    price = price + price * 0.21;
                    var fp_to_show = final_price.toLocaleString('nl-NL', {maximumFractionDigits:2})
                    $('#product_price').text(price)
                    $(this).closest("div").find(".subTotal").val(parseInt($(this).val()) * priceAmount)
                }
            });
            @if($has_platform > 0 )
                $("#botPrice").hide();
            @endif
            $(function () {
                $("#tradingPlatform").click(function () {
                    if ($(this).is(":checked")) {
                        $("#botPrice").show();

                    } else {
                        $("#botPrice").hide();
                            var platform_price = 0;
                            var qty = parseInt($('.productTextInput').val());
                            var product_original_price = $('.originalPrice').val();
                            var price = qty * parseFloat(product_original_price);
                            price = price + price * 0.21;
                            var final_price= platform_price + price;
                            var fp_to_show = final_price.toLocaleString('nl-NL', {maximumFractionDigits:2})
                            $('#product_price').text(fp_to_show);
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
                var platform_pair = $('option:selected', '#botPrice').val();
                if ((platform_pair == '') || (typeof  platform_pair == "undefined") ) {
                    var platform_price = 0;
                } else {
                    $platform = platform_pair.split('#');
                    var platform_price = parseFloat($platform[1]);
                }
                if("{{$product['sku']}}" == "cbm_cashback"){
                    touchSpinLicenseChange(currentVal + 1);
                }
                else{
                    var product_price = $('.originalPrice').val();
                    var price = (currentVal + 1) * parseFloat(product_price);
                    price = price + price * 0.21;
                    var final_price= platform_price + price;
                    var fp_to_show = final_price.toLocaleString('nl-NL', {maximumFractionDigits:2})
                    $('#product_price').text(fp_to_show);
                }

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
                var platform_pair = $('option:selected', '#botPrice').val();
                if ((platform_pair == '') || (typeof  platform_pair == "undefined") ) {
                    var platform_price = 0;
                } else {
                    $platform = platform_pair.split('#');
                    var platform_price = parseFloat($platform[1]);
                }
                if("{{$product['sku']}}" == "cbm_cashback"){
                    touchSpinLicenseChange(currentVal - 1);
                }
                else{
                    var product_price = $('.originalPrice').val();
                    var price = (currentVal - 1) * parseFloat(product_price);
                    price = price + price * 0.21;
                    var final_price= platform_price + price;
                    var fp_to_show = final_price.toLocaleString('nl-NL', {maximumFractionDigits:2})
                    $('#product_price').text(fp_to_show);
                }
            } else {
                parent.find('input[name=' + fieldName + ']').val(1);
            }
        }

        function licenseBtnClk() {
            $('#licenseBtn').css('display', 'none');
            var getLicenseIdUrl = "{{ Url("product/getLicenseId") }}";
            var licenseNum = $('#license-count').val();
            //To get valid license_pricing id as per the input license quantity
            $.ajax({
                type: "POST",
                url: getLicenseIdUrl,
                data: {
                    "licenseNum": licenseNum
                },
                success: function (data) {
                    dt = JSON.parse(data);
                    var trip_id = 1;

                    if (dt.present) {
                        $('#grp1_radio_' + dt.id).prop("checked", true);
                        $('#grp2_radio_' + dt.id).prop("checked", true);
                        //Update license number based upon radio button selection
                        licenseNum = product_pricing_arr[dt.id].licenses;
                        window.sale_price = product_pricing_arr[dt.id].price_per_license;
                        trip_id = dt.id;

                        is_cluster_selected = 1;
                    }
                    else {
                        //Hide new row's if present
                        if ($('#trading_capital').find('[data-step=new]').length) {
                            $('#trading_capital').find('[data-step=new]').hide();
                            $('#cbm_licenses').find('[data-step=new]').hide();
                        }
                        //Append a row to trading capital table
                        $('#trading_capital').find('[data-step=' + (dt.id - 1) + ']').after("<tr data-step='new'>" +
                            "<td>" +
                            "<span style='margin: 27px;'></span>" +
                            "</td>" +
                            "<td>&euro;" + (licenseNum * 50) +
                            "</td>" +
                            "</tr>");
                        //Append a row to cbm licenses table
                        $('#cbm_licenses').find('[data-step=' + (dt.id - 1) + ']').after("<tr data-step='new'>" +
                            "<td class='grp2_new'><input name='group2' type='radio' id = 'grp2_radio_new' class = 'grp1_radio'>" +
                            "<span style='margin: 27px;' id='grp2_new_license'>" + licenseNum + "</span>" +
                            "</td>" +
                            "<td class='grp2_new'>&euro;" + (licenseNum * dt.product_price) +
                            "</td>" +
                            "<td class='grp2_new'> &euro;<span id='grp2_new_price'>" +
                            dt.product_price +
                            "</span></td>" +
                            "</tr>");

                        $('#grp1_radio_new').prop("checked", true);
                        $('#grp2_radio_new').prop("checked", true);

                        //Update license number based upon radio button selection
                        window.sale_price = dt.product_price;
                        trip_id = "new";

                        is_cluster_selected = 0;
                    }

                    //Update Spinner details
                    updateSpinnerDetails(licenseNum, window.sale_price);

                    /*
                    * Select the background color for the selected rows in both table
                    * only if license num is greater than 255 as otherwise
                    * colors are updated while the trip is ongoing
                    * */
                    if (licenseNum >= 255) {
                        $('#trading_capital').find('[data-step=' + trip_id + ']').addClass('selected_trade_capital');
                        $('#cbm_licenses').find('[data-step=' + trip_id + ']').addClass('selected_cbm_licenses');
                    }
                    tripStart(trip_id);
                }
            });
            $('#cbm_licenses-flow').css('display', 'flex');
        }

        //For the user-guidance trip
        function tripStart(stepId) {

            if (trip_completed == 0) {
                var execute_trip = 1;

                //Trip should not be executed if the number of licenses are greater than 255
                /*if (product_pricing_arr[stepId]) {
                    if (product_pricing_arr[stepId].licenses) {
                        if (product_pricing_arr[stepId].licenses >= 255) {
                            execute_trip = 0;
                        }
                    }
                }*/

                var tripData = [];
                var temp = {
                    sel: $('.grp2_' + stepId + ':last-of-type'),
                    content: "You have currently selected a deposit amount of €" + deposit + ", which would require " + licenseNum + "  licenses.\n" +
                        "We just wanted to show you some options to optimise your purchase.\n" +
                        "\n" +
                        "Read carefully!",
                    nextLabel: "Let's go",
                    skipLabel: "No, Thanks",
                    finishLabel: "Yes, I'II get that deal now!",
                    position: "e"
                };
                //1st message was added which is common for both situations
                tripData.push(temp);

                //For non-cluster selection
                if (stepId == "new") {
                    var nextStepId = $('#trading_capital').find("[data-step='new']").next().attr("data-step");

                    //2nd message
                    temp = {
                        sel: $('.grp2_' + nextStepId + ':last-of-type'),
                        content: "Clustering optimises the amount of cashback you can earn from UTIT. The bigger cluster you deposit, " +
                            "the better optimised you are. Based on your previous selection, your optimal next cluster has " + product_pricing_arr[nextStepId].licenses + " cashback nodes.\n" +
                            "Would you like to raise your deposit to €" + product_pricing_arr[nextStepId].licenses * min_node_amount + " ?",
                        nextLabel: "Yes, Please",
                        skipLabel: "Not Now",
                        finishLabel: "Yes, I'II get that deal now!",
                        canGoPrev: false,
                        position: "e"
                    };
                    tripData.push(temp);

                    //3rd message
                    nextStepId = parseInt(nextStepId) + 1;
                    temp = {
                        sel: $('.grp2_' + nextStepId + ':last-of-type'),
                        content: "Your trading capital can generate profits. Every time a profit of €50 is made, " +
                            "you automatically receive a new cashback node in UTIT if you have an available license. " +
                            "Do you wish to purchase extra licenses to be prepared. Buying more licenses can get you a nice discount.",
                        nextLabel: "Yes, Please",
                        skipLabel: "Not Now",
                        finishLabel: "Yes, I'II get that deal now!",
                        position: "e"
                    };
                    tripData.push(temp);

                } else {
                    var nextStepId = parseInt(stepId) + 1;

                    //2nd message
                    temp = {
                        sel: $('.grp2_' + nextStepId + ':last-of-type'),
                        content: "Your trading capital can generate profits. Every time a profit of €50 is made, " +
                            "you automatically receive a new cashback node in UTIT if you have an available license. " +
                            "Do you wish to purchase extra licenses to be prepared. Buying more licenses can get you a nice discount.",
                        nextLabel: "Yes, Please",
                        skipLabel: "Not Now",
                        finishLabel: "Yes, I'II get that deal now!",
                        position: "e"
                    };
                    tripData.push(temp);
                }

                //Static way to check for 255 licenses
                if (nextStepId < 8) {
                    //last message is common for both conditions
                    var licenseUrl = "{{ Url("product/getLicenseId") }}";
                    $.ajax({
                        type: "POST",
                        url: licenseUrl,
                        data: {
                            "licenseNum": 255
                        },
                        success: function (data) {
                            dt = JSON.parse(data);
                            nextStepId = dt.id;

                            temp = {
                                sel: $('.grp2_' + nextStepId + ':last-of-type'),
                                content: "Last question! promise! \n" +
                                    "The best deal we can offer you right now is 40% discount. Starting at 255 licenses.\n" +
                                    "Remember, buying extra licenses separately will require you to pay full price.",
                                finishLabel: "Yes, I'II get that deal now!",
                                skipLabel: "No, Thanks",
                                position: "e"
                            };
                            tripData.push(temp);
                        }
                    });
                }

                var trip = new Trip(
                    tripData, {
                        showNavigation: true,
                        showCloseBox: true,
                        delay: -1,
                        onTripChange: function (i, tripData) {
                            var className = tripData.sel[0].className;
                            var grpArr = className.split("_");
                            var grpId = grpArr[1];
                        },
                        onTripStart: function (tripIndex, tripObject) {
                            var className = tripObject.sel[0].className;
                            var grpArr = className.split("_");
                            var grpId = grpArr[1];

                            //Remove Skip from the trip
                            $('.trip-prev').css('display', 'none');

                            //Selection Criteria for background color
                            if (is_cluster_selected == 0) {
                                if (tripIndex == 0 || tripIndex == 1) {
                                    $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected_trade_capital');
                                    $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected_cbm_licenses');

                                    $('#trading_capital').find('[data-step=' + previous_group_id + ']').removeClass('selected_trade_capital');
                                    $('#cbm_licenses').find('[data-step=' + previous_group_id + ']').removeClass('selected_cbm_licenses');
                                } else if (tripIndex == 2 || tripIndex == 3) {
                                    $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected_cbm_licenses');
                                    $('#cbm_licenses').find('[data-step=' + previous_group_id + ']').removeClass('selected_cbm_licenses');
                                }
                            } else if (is_cluster_selected == 1) {
                                if (tripIndex == 0) {
                                    $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected_trade_capital');
                                    $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected_cbm_licenses');

                                    $('#trading_capital').find('[data-step=' + previous_group_id + ']').removeClass('selected_trade_capital');
                                    $('#cbm_licenses').find('[data-step=' + previous_group_id + ']').removeClass('selected_cbm_licenses');
                                } else if (tripIndex == 1 || tripIndex == 2) {
                                    $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected_cbm_licenses');
                                    $('#cbm_licenses').find('[data-step=' + previous_group_id + ']').removeClass('selected_cbm_licenses');
                                }
                            }
                        },
                        onTripEnd: function (tripIndex, tripObject) {
                            var className = tripObject.sel[0].className;
                            var grpArr = className.split("_");
                            var grpId = grpArr[1];

                            previous_group_id = grpId;
                        },
                        onEnd: function (tripIndex, tripObject) {
                            //Update license number and deposit based upon radio button selection
                            var grp2_radio_btn_id = $('input[type=radio][name=group2]:checked').attr('id');
                            var grp2_id_arr = grp2_radio_btn_id.split('_');
                            var grp2_id = grp2_id_arr[2];

                            if (grp2_id != "new") {
                                licenseNum = product_pricing_arr[grp2_id].licenses;
                                window.sale_price = product_pricing_arr[grp2_id].price_per_license;
                            } else {
                                licenseNum = $('#grp2_new_license').html();
                                window.sale_price = $('#grp2_new_price').html();
                            }

                            var grp1_radio_btn_id = $('input[type=radio][name=group1]:checked').attr('id');
                            if (typeof  grp1_radio_btn_id == "undefined") {
                                var grp1_id = "new";
                            } else {
                                var grp1_id_arr = grp1_radio_btn_id.split('_');
                                var grp1_id = grp1_id_arr[2];
                            }

                            if (grp1_id != "new") {
                                cluster = product_pricing_arr[grp1_id].licenses;
                                deposit = cluster * 50;
                            } else {
                                cluster = $('#grp2_new_license').html();
                                deposit = cluster * 50;
                            }
                            trip_completed = 1;

                            //On trip completion details will be updated
                            updateSpinnerDetails(licenseNum, window.sale_price);
                        }
                    },
                );
                //To execute trip only if the number of licenses are less than 255
                if (execute_trip == 1) {
                    trip.start();
                }
            }

        }

        //Update spinner in the third step of new flow
        function updateSpinnerDetails(licenseQty, price_license) {
            $('#quantity_price').css('display', 'block');
            $('#cashback').css('display', 'none');
            $("input[name='quantity']").val(licenseQty);
            final_price = (price_license * licenseQty) + (price_license * licenseQty * 0.21);
            var fp_to_show = final_price.toLocaleString('nl-NL', {maximumFractionDigits:2})
            $('#product_price').text(fp_to_show);
        }

        function touchSpinLicenseChange(licenseCount) {
            var getLicensePriceUrl = "{{ Url("product/getLicensePrice") }}";

            //To get valid license_pricing id as per the input license quantity
            $.ajax({
                type: "POST",
                url: getLicensePriceUrl,
                data: {
                    "licenseNum": licenseCount
                },
                success: function (data) {
                    dt = JSON.parse(data);
                    console.log(data);
                    window.sale_price = dt.product_price;
                    final_price = (window.sale_price * licenseCount) + (window.sale_price * licenseCount * 0.21);
                    var fp_to_show = final_price.toLocaleString('nl-NL', {maximumFractionDigits:2})
                    $('#product_price').text(fp_to_show);
                }
            });
        }

        $('body').on('click', '.trip-next', function () {
            var data_trip_step = $(this).parent().parent().attr('data-trip-step');
            if (is_cluster_selected == 0) {
                if (data_trip_step == 1) {
                    //Update license and deposit
                    $('#grp1_radio_' + previous_group_id).prop("checked", true);
                    $('#grp2_radio_' + previous_group_id).prop("checked", true);
                } else if (data_trip_step == 2) {
                    //Update only license
                    $('#grp2_radio_' + previous_group_id).prop("checked", true);
                } else if (data_trip_step == 3) {
                    //Update only license
                    $('#grp2_radio_' + previous_group_id).prop("checked", true);
                }
            } else if (is_cluster_selected == 1) {
                if (data_trip_step == 1) {
                    //Update only license
                    $('#grp2_radio_' + previous_group_id).prop("checked", true);
                } else if (data_trip_step == 2) {
                    //Update only license
                    $('#grp2_radio_' + previous_group_id).prop("checked", true);
                }
            }
        });


        $(document).ready(function () {
            var count = '<?php echo $is_parentProduct?>';
            if (parseFloat(count) > 0) {
                var text = $('#product_price').text();
            }
            $("#botPrice").change(function() {
                var platform_pair = $('option:selected', this).val();
                if (platform_pair == '') {
                    var platform_price = 0;
                } else {
                    $platform = platform_pair.split('#');
                    var platform_price = parseFloat($platform[1]);
                }

                var qty = parseInt($('.productTextInput').val());
                var product_original_price = $('.originalPrice').val();
                var price = qty * parseFloat(product_original_price);
                price = price + price * 0.21;
                var final_price= platform_price + price;
                $('#product_price').text(final_price.toFixed(2));

            });
            /*$('#botPrice').on('change',function () {
                var platform_pair = $('#botPrice').val();
                $platform = platform_pair.split('#');
                var platform_price_final = $platform[1];
                var final_price= parseFloat(platform_price_final) + parseFloat(text);
                var priceAmount = $('.productTextInput').val();
                var product_price = $('.originalPrice').val();
                var price = this.value * parseFloat(product_price);
                price = price + price * 0.21;
                console.log(platform_price_final);
                console.log(text);
                $('#product_price').text(final_price.toFixed(2));
            });*/

            $('#buy').click(function () {
                var platform_pair = $('#botPrice').val();
                var tradingPlatform = $('#tradingPlatform').is(":checked");
                @if($has_platform > 0)
                    if (tradingPlatform == true && platform_pair == '') {
                        $('.error').css('display', 'block');
                        $('.error').focus();
                    } else {
                        $('.error').css('display', 'none');
                        var id = '<?php echo $id; ?>';
                        var qty = $("input[name=quantity]").val();
                        var token = window.btoa(id + '$' + qty + '$' + platform_pair);
                        window.location = '<?php echo Url("checkout/")?>' + '/' + token
                    }
                @else
                if("{{$product['sku']}}" != "cbm_cashback"){
                    if (tradingPlatform == false) {
                        $('#buyPlatform').modal('show');
                    } else {
                        if (tradingPlatform == true && platform_pair == '') {
                            $('.error').css('display', 'block');
                            $('.error').focus();
                        } else {
                            $('.error').css('display', 'none');
                            var id = '<?php echo $id; ?>';
                            var qty = $("input[name=quantity]").val();
                            console.log(qty);
                            var token = window.btoa(id + '$' + qty + '$' + platform_pair);
                            window.location = '<?php echo Url("checkout/")?>' + '/' + token
                        }
                    }
                }
                @endif
            });

            $('#cart').click(function () {
                var platform_pair = $('#botPrice').val();
                var tradingPlatform = $('#tradingPlatform').is(":checked");
                var price = $.trim($('#product_price').text());
                @if($has_platform > 0)
                if (tradingPlatform == true && platform_pair == '') {
                    $('.error').css('display', 'block');
                    $('.error').focus();
                } else {
                    $('.error').css('display', 'none');
                    var id = '<?php echo $id; ?>';
                    var qty = $("input[name=quantity]").val();
                    var token = window.btoa(id + '$' + qty + '$' + price + '$' + platform_pair);
                    window.location = '<?php echo Url("add-cart/")?>' + '/' + token
                }
                @else
                if("{{$product['sku']}}" != "cbm_cashback") {
                    if(tradingPlatform == false){
                        $('#buyPlatform').modal('show');
                    } else {
                        if (tradingPlatform == true && platform_pair == '') {
                            $('.error').css('display', 'block');
                            $('.error').focus();
                        } else {
                            $('.error').css('display', 'none');
                            var id = '<?php echo $id; ?>';
                            var qty = $("input[name=quantity]").val();
                            var token = window.btoa(id + '$' + qty + '$' + price + '$' + platform_pair);
                            window.location = '<?php echo Url("add-cart/")?>' + '/' + token
                        }
                    }
                }
                else {
                    $('.error').css('display', 'none');
                    var id = '<?php echo $id; ?>';
                    var qty = $("input[name=quantity]").val();
                    var token = window.btoa(id + '$' + qty + '$' + price + '$' + platform_pair);
                    window.location = '<?php echo Url("add-cart/")?>' + '/' + token
                }
                @endif
            });

            $("#platform_pair").change(function () {
                var currency = $('#platform_pair').find(":selected").text();
                if (parseFloat(count) > 0) {
                    var child_price = '<?= $child_price; ?>';
                    if (currency != '') {
                        // var text = $('#product_price').text();
                        var total = parseFloat(child_price) + parseFloat(text);
                        $('#product_price').text(parseFloat(total).toFixed(2));
                    }
                }
            });

            //Enable-Disable UnityFund Select Button
            $('body').on('input', '#license-count', function () {
                updateDepositLicense("license");
            });
            $('body').on('input', '#deposit', function () {
                updateDepositLicense("deposit");
            });

            //Step-1 update deposit and licenses based upon each other
            function updateDepositLicense(inputText) {
                var nodeAmt = {{ env('MinimumNodeAmount') }};
                var displayLicenseBtn = 0;
                var displayFundBtn = 0;
                if (inputText == "license") {
                    licenseNum = $('#license-count').val();
                    deposit = licenseNum * nodeAmt;
                    $('#deposit').val(deposit);

                    if (licenseNum % 1 == 0) {
                        if (licenseNum >= 5) {
                            $('#min_prd_card_header').css('display', 'none');
                            displayLicenseBtn = 1;
                            displayFundBtn = 0;
                            if (licenseNum >= 20) {
                                displayFundBtn = 1;
                            }
                        } else {
                            displayLicenseBtn = 0;
                            $('#min_prd_card_header').css('display', 'block');
                            $('#min_prd_card_header_text').html("A minimum of 5 licenses is required to proceed");
                        }
                    } else {
                        displayLicenseBtn = 0;
                        $('#min_prd_card_header').css('display', 'block');
                        $('#min_prd_card_header_text').html("License should be a whole number");
                    }

                }
                else {
                    deposit = $('#deposit').val();
                    licenseNum = deposit / nodeAmt;
                    $('#license-count').val(licenseNum);

                    if (deposit % 50 == 0) {
                        if (deposit >= 250) {
                            $('#min_prd_card_header').css('display', 'none');
                            displayLicenseBtn = 1;
                            displayFundBtn = 0;
                            if (deposit >= 1000) {
                                displayFundBtn = 1;
                            }
                        } else {
                            displayLicenseBtn = 0;
                            $('#min_prd_card_header').css('display', 'block');
                            $('#min_prd_card_header_text').html("A minimum deposit of 250 euro is required to proceed");
                        }
                    } else {
                        displayLicenseBtn = 0;
                        $('#min_prd_card_header').css('display', 'block');
                        $('#min_prd_card_header_text').html("Deposit should be a multiple of 50");
                    }
                }

                if (displayLicenseBtn == 0) {
                    $('#fundBtn').css('display', 'none');
                    $('#licenseBtn').css('display', 'none');

                    $('#license_card_header').css('display', 'none');
                    $('#fund_card_header').css('display', 'none');
                }

                if (displayFundBtn == 1) {
                    $('#min_prd_card_header').css('display', 'none');
                    $('#license_card_header').css('display', 'block');
                    $('#fund_card_header').css('display', 'block');

                    $('#fundBtn').css('display', 'block');
                    $('#licenseBtn').css('display', 'block');
                }

                if (displayLicenseBtn == 1 && displayFundBtn == 0) {
                    $('#min_prd_card_header').css('display', 'none');
                    $('#license_card_header').css('display', 'none');
                    $('#fund_card_header').css('display', 'none');

                    $('#fundBtn').css('display', 'none');
                    $('#licenseBtn').css('display', 'block');
                }
            }
        });
    </script>
@endsection
