$(".tab-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onFinished: function (event, currentIndex) {
        var form = $(this);
        // Submit form input
        form.submit();
    }
});

var form2 = $(".pending-order-validation-wizard").show();
//Pending order validation wizard
$(".pending-order-validation-wizard").steps({
    headerTag: "h6",
    bodyTag: "section",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: "Submit"
    },
    onFinishing: function (event, currentIndex) {
        return form2.validate().settings.ignore = ":disabled", form2.valid()
    },
    onFinished: function (event, currentIndex) {
        $.ajax({
            type: "POST",
            url: "../order/addorder",
            data: $(this).serializeArray(),
            success: function (data) {
                var response = JSON.parse(data);
                swal({
                        title: "Order Placed",
                        text: "Your order has been placed in reserved-pending state.",
                        closeOnConfirm: false
                    },
                    function () {
                        window.location = "../order/detail/" + response.orderId;
                    });
            }
        });
    }
});

var form = $(".validation-wizard").show();


$(".validation-wizard").steps({
    headerTag: "h6"
    , bodyTag: "section"
    , transitionEffect: "fade"
    , titleTemplate: '<span class="step">#index#</span> #title#'
    , labels: {
        finish: "Submit"
    }
    , onStepChanging: function (event, currentIndex, newIndex) {
        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
    }
    /*, onFinishing: function (event, currentIndex) {
        return form.validate().settings.ignore = ":disabled", form.valid()
    }*/
    , onStepChanged: function (event, currentIndex, priorIndex) {
        if (new_product_flow) {
            //Step 2 has been completed
            if (currentIndex == 2 && priorIndex == 1) {
                var getLicenseIdUrl = "../product/getLicenseId";
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
                        } else {
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
            }
            //coming back from "Checkout" section to "Buy Licenses" section
            if (currentIndex == 2 && priorIndex == 3) {
                //Update background selection color
                var grp2_radio_btn_id = $('input[type=radio][name=group2]:checked').attr('id');
                var grp2_id_arr = grp2_radio_btn_id.split('_');
                var grp2_id = grp2_id_arr[2];

                $('#cbm_licenses').find('.selected_cbm_licenses').removeClass('selected_cbm_licenses');
                $('#cbm_licenses').find('[data-step=' + grp2_id + ']').addClass('selected_cbm_licenses');

                var grp1_radio_btn_id = $('input[type=radio][name=group1]:checked').attr('id');
                if (typeof  grp1_radio_btn_id == "undefined") {
                    var grp1_id = "new";
                } else {
                    var grp1_id_arr = grp1_radio_btn_id.split('_');
                    var grp1_id = grp1_id_arr[2];
                }

                $('#trading_capital').find('.selected_trade_capital').removeClass('selected_trade_capital');
                $('#trading_capital').find('[data-step=' + grp1_id + ']').addClass('selected_trade_capital');
            }
            //Step 3 has been completed, now on checkout page
            if (currentIndex == 3) {
                //Trip needs to ended...if not..on checkout page
                $('.trip-block').css('display', 'none');
                updateCheckoutSectionDetails();
            }

            //Trip needs to ended...if not..on checkout page
            if (currentIndex != 2) {
                $('.trip-block').css('display', 'none');
            }

        } else {
            if (currentIndex == 2) {
                licenseNum = $("input[name='step2_qty']").val();
                updateCheckoutSectionDetails();
            }

            if(currentIndex == 3){
                if(net_total == 0){
                    $('#user_wallet_cbox').prop('checked', true);
                }
            }
        }

    },
    onFinished: function (event, currentIndex) {
        var selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
        var payment_method = $('input[name=payment]:checked').val();
        var payment_method_selected = false;
        var payment_system_section_display_property = $('#payment-section').css('display');
        var order_form_data = $(this).serializeArray();

        if($('#user_wallet_cbox').is(':checked') || $('#reserve_wallet_cbox').is(':checked')){
            /*  To check if there are multiple payment methods available
                Only if there is no payment gateway enabled, payment
                method can be made to 'wallet'
             */
            if((payment_system_section_display_property == 'none'))
                payment_method = 'wallet';
            payment_method_selected = true;
        }

        //No payment method selected
        if((payment_system_section_display_property == 'none') && !payment_method_selected){
            swal("OOPS!", "You need to select payment method first!", "error");
            return false;
        } else {
            if((payment_method == 'stripe') && (selected_option == 'card') ){
                stripe.createPaymentMethod(
                    'card',
                    cardElement
                ).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        $(".lds-ellipsis").css('display','none');
                        errorElement.textContent = result.error.message;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "../order/addorder",
                            data: order_form_data,
                            beforeSend: function () {
                                $(".lds-ellipsis").css('display', 'block');
                                $('.wizard-content').addClass('disabledDiv');
                            },
                            success: function (data) {
                                var response = JSON.parse(data);

                                //Setting the orderID is necessary for all payment gateways
                                $('#order_id').val(response['orderId']);
                                // Send paymentMethod.id to server
                                stripeSourceHandler(result.paymentMethod);
                            }
                        });
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "../order/addorder",
                    data: order_form_data,
                    beforeSend: function () {
                        $(".lds-ellipsis").css('display','block');
                        $('.wizard-content').addClass('disabledDiv');
                    },
                    success: function (data) {
                        var response = JSON.parse(data);

                        //Setting the orderID is necessary for all payment gateways
                        $('#order_id').val(response['orderId']);
                        var redirectUrl = stripeSuccessURL;
                        if (response['payment'] == 'Ingenico') {
                            $('#submitInjenico').click();
                        } else if(response['payment'] == 'Wallet'){
                            //For Orders paid through only wallets
                            var successRedirectUrl = reserveWalletSuccessURL + response['orderId'] + "&PAYID=";
                            window.location = successRedirectUrl;
                        } else {
                            var selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
                            if (response['payment'] == 'Stripe') {
                                var cardButton = document.getElementById('card-button');

                                if(selected_option == 'card'){
                                    //Card related procedures are completed above

                                    /*stripe.createPaymentMethod(
                                        'card',
                                        cardElement
                                    ).then(function(result) {
                                        if (result.error) {
                                            // Inform the user if there was an error
                                            var errorElement = document.getElementById('card-errors');
                                            $(".lds-ellipsis").css('display','none');
                                            errorElement.textContent = result.error.message;
                                        } else {
                                            // Send paymentMethod.id to server
                                            stripeSourceHandler(result.paymentMethod);
                                        }
                                    });*/
                                    /*stripe.createSource(cardElement).then(function(result) {
                                        if (result.error) {
                                            // Inform the user if there was an error
                                            var errorElement = document.getElementById('card-errors');
                                            $(".lds-ellipsis").css('display','none');
                                            errorElement.textContent = result.error.message;
                                        } else {
                                            // Send the source to your server
                                            stripeSourceHandler(result.source);
                                        }
                                    });*/
                                } else if(selected_option == 'iDeal'){
                                    var errorMessage = document.getElementById('error-message');
                                    var sourceData = {
                                        type: 'ideal',
                                        amount: Math.round(payable_amount*100),
                                        currency: 'eur',
                                        owner: {
                                            name: full_name
                                        },
                                        redirect: {
                                            return_url: authorizeAsyncURL+'?order_id='+response['orderId']+'&netTotal='+payable_amount
                                        },
                                        statement_descriptor: 'Order Id: '+response['orderId']
                                    };

                                    stripe.createSource(idealBank, sourceData).then(function(result) {
                                        if (result.error) {
                                            // Inform the customer that there was an error.
                                            errorMessage.textContent = result.error.message;
                                            $(".lds-ellipsis").css('display','none');
                                            errorMessage.classList.add('visible');
                                        } else {
                                            // Redirect the customer to the authorization URL.
                                            errorMessage.classList.remove('visible');
                                            stripeSourceHandler(result.source);
                                        }
                                    });
                                } else if((selected_option == 'bancontact') || (selected_option == 'giropay')){
                                    stripe.createSource({
                                        type: selected_option,
                                        amount: Math.round(payable_amount*100),
                                        currency: 'eur',
                                        statement_descriptor: 'Order Id: '+response['orderId'],
                                        owner: {
                                            name: full_name
                                        },
                                        redirect: {
                                            return_url: authorizeAsyncURL+'?order_id='+response['orderId']+'&netTotal='+payable_amount
                                        }
                                    }).then(function(result) {
                                        // handle result.error or result.source
                                        if (result.error) {
                                            // Inform the customer that there was an error.
                                            $('.errorMessage').css('display','block');
                                            $(".lds-ellipsis").css('display','none');
                                        } else {
                                            // Redirect the customer to the authorization URL.
                                            $('.errorMessage').css('display','none');
                                            stripeSourceHandler(result.source);
                                        }
                                    });
                                } else if(selected_option == 'sofort'){
                                    stripe.createSource({
                                        type: selected_option,
                                        amount: Math.round(payable_amount*100),
                                        currency: 'eur',
                                        statement_descriptor: 'Order Id: '+response['orderId'],
                                        owner: {
                                            name: 'succeeding_charge'
                                        },
                                        redirect: {
                                            return_url: authorizeAsyncURL+'?order_id='+response['orderId']+'&netTotal='+payable_amount
                                        },
                                        sofort: {
                                            country: 'BE',
                                            preferred_language: 'nl'
                                        }
                                    }).then(function(result) {
                                        // handle result.error or result.source
                                        if (result.error) {
                                            // Inform the customer that there was an error.
                                            $('.errorMessage').css('display','block');
                                            $(".lds-ellipsis").css('display','none');
                                        } else {
                                            // Redirect the customer to the authorization URL.
                                            $('.errorMessage').css('display','none');
                                            stripeSourceHandler(result.source);
                                        }
                                    });
                                }
                            } else {
                                swal({
                                        title: "Order Placed",
                                        text: "Your order has been placed in pending state.",
                                        closeOnConfirm: false
                                    },
                                    function () {
                                        window.location = "../order/detail/" + response.orderId;
                                    });
                            }
                        }
                    }
                });
            }
        }

    }
});

function stripeSourceHandler(source){
    var sourceId = source.id;
    var selected_option = $('ul#stripe-payment-methods a.active').attr('data-name');
    var orderId = $('#order_id').val();

    //Update Stripe sub payment method in order_payment transaction_mode
    var payment_data = {
        'order_id': orderId,
        'selected_option': selected_option
    };
    $.ajax({
        type: "POST",
        url: orderPaymentDetailsURL,
        data: payment_data
    });


    if((selected_option == 'iDeal') || (selected_option == 'bancontact') || (selected_option == 'sofort') || (selected_option == 'giropay')) {
        //Redirect to authorization page
        window.location = source.redirect['url'];
    } else if(selected_option == 'card') {
        var stripeData = {
            'netTotal': payable_amount,
            'order_id': orderId,
            'full_name': full_name,
            'email': email,
            'source_id': sourceId,
            'selected_option': selected_option
        };
        $.ajax({
            type: "POST",
            url: updateStripeUrl,
            data: stripeData,
            success: function (data) {
                var resp = JSON.parse(data);
                if(resp.status == true){
                    var redirectUrl = stripeSuccessURL + orderId + "&PAYID=" + resp.secret;
                } else {
                    var redirectUrl = stripeCancelURL + orderId + "&PAYID=" + resp.secret;
                }
                window.location = redirectUrl;
            }
        });
    }

}

$(".pending-order-validation-wizard").validate({
    ignore: ".ignore",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
        $(element).addClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    errorPlacement: function (error, element) {
        error.insertBefore(element)
    },
    rules: {
        terms: {
            required: true
        },
        service: {
            required: true
        }
    },
    messages: {
        terms: 'Please agree to Terms and Conditions',
        service: 'Please agree to Refund policy'
    }
});

$(".validation-wizard").validate({
    ignore: ".ignore",
    errorClass: "text-danger",
    successClass: "text-success",
    highlight: function (element, errorClass) {
        $(element).addClass(errorClass);
    },
    unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    },
    errorPlacement: function (error, element) {
        error.insertBefore(element)
    },
    rules: {
        address: {
            required: true
        },
        terms: {
            required: true
        },
        service: {
            required: true
        },
        building_num: {
            required: true
        },
        street: {
            required: true
        },
        city: {
            required: true
        },
        postcode: {
            required: true
        },
        country: {
            required: true
        },
        business_name: {
            required: true
        },
        vat_number: {
            required: true
        },
        busAddress_building_num: {
            required: true
        },
        busAddress_street: {
            required: true
        },
        busAddress_region: {
            required: true
        },
        busAddress_city: {
            required: true
        },
        busAddress_postcode: {
            required: true
        },
        busAddress_country: {
            required: true
        },
        payment: {
            required: true
        }
    },
    messages: {
        terms: 'Please agree to Terms and Conditions',
        service: 'Please agree to Refund policy',
        address: 'Please Complete your profile',
        payment: 'Please Select Payment Method',
        building_num: 'Please enter Building number',
        street: 'Please enter Street',
        city: 'Please enter City',
        postcode: 'Please enter Postcode',
        country: 'Please select Country',
        business_name: 'Please enter Company Name',
        vat_number: 'Please enter Vat number',
        busAddress_building_num: 'Please enter Building number',
        busAddress_street: 'Please enter Street',
        busAddress_region: 'Please enter Region',
        busAddress_city: 'Please enter City',
        busAddress_postcode: 'Please enter Postcode',
        busAddress_country: 'Please select Country'
    }
});

function updateCheckoutSectionDetails() {
    var adds_type = $('input[name=address]').val();
    var country_id = 0;
    var vat_type = '';
    if (adds_type == 'personal') {
        country_id = $('#personal-country-select').val();
        vat_type = "personal";
    } else {
        country_id = $('#business-country-select').val();
        vat_type = "business";
    }
    calculateVat(country_id, vat_type);
    updateCheckoutDetails();
}
