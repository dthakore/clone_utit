$(document).ready(function() {
    //business checked
    var business = ($('input[name=billing_info]:checked').val());
    if (business == "business") {
        $(".business_checked").removeClass("hide");
    } else {
        $(".business_checked").addClass("hide");
    }

    //fill full name
    $('#first_name, #last_name, #middle_name').change(function() {
        var first = $("#first_name").val().replace(/\s+/g, '');
        $("#first_name").val(first);
        var middle = $("#middle_name").val().replace(/\s+/g, '');
        $("#middle_name").val(middle);
        var last = $("#last_name").val().replace(/\s+/g, '');
        $("#last_name").val(last);
        $("#name").val(first + " " + middle + " " + last);
    });

    //for business billing info
    $('#user-form input').on('change', function() {
        var value = ($('input[name=billing_info]:checked').val());
        if (value == "business") {
            $(".business_checked").removeClass("hide");
            if ($('#business_address').is(":checked")) {
                $(".diff_address").removeClass("hide");
            } else {
                $(".diff_address").addClass("hide");
            }
        } else {
            $(".business_checked").addClass("hide");
        }

    });

    //for business address
    $('#business_address').on('change', function() {
        if ($('#business_address').is(":checked")) {
            $(".diff_address").removeClass("hide");
        } else {
            $(".diff_address").addClass("hide");
        }
    });
});