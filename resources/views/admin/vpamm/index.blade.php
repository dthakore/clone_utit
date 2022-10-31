@extends('layouts.admin')
@section('styles')
<style>
    /* .ui-datepicker-calendar {
        display: none;
    } */
    .pusher-logs {
        background: black;
        padding: 10px;
        color: lawngreen;
        font-size: 13px;
        font-family: 'Courier New';
    }
    .pusher-logs p{
        margin-bottom: 0;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.vpamm.title') }}
    </div>

    <div class="card-body">
        <div class="resultHTML">
        </div>
        
        <table class=" ajaxTable datatable datatable-vpamm">
            <tr>
                <th class="col-md-1">
                    {{ trans('cruds.vpamm.fields.name') }}
                </th>
                <th class="col-md-1">
                    {{ trans('cruds.vpamm.fields.start_date') }}
                </th>
                <th class="col-md-1">
                    {{ trans('cruds.vpamm.fields.end_date') }}
                </th>
            </tr>
            <tr>
                <td class="col-md-4">
                    <select class="search form-control" strict="true" id="mtFourBroker">
                        <option value>Select broker</option>
                        @foreach($mtFourBrokers as $key => $mtFourBroker)
                            <option value="{{ $mtFourBroker->id }}">{{ $mtFourBroker->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="col-sm-3">
                    <input class="search form-control" id="StartDate" type="text" placeholder="Select Date">
                </td>
                <td class="col-sm-3">
                    <input class="search form-control" id="EndDate" type="text" placeholder="Select Date">
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-lg-6 errorInfo" style="margin-left: 8px;">
            </div>
        </div>
        <div class="row">
            <p id="msg" style="text-align: center;margin-left: 16px;"></p>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-12">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade active show" id="accounts-tabs" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                <button class="btn btn-success importData" id="importData" >{{ trans('global.import') }}</button>
                                <p style="margin-top: 15px">
                                </p>
                                <p style="background: whitesmoke !important; display: none" id="tradesMsg"></p>
                                <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                                <div class="accounts-logs pusher-logs">
                                    <p>Logs will appear here</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {

        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('mtfourTrades');
        //commission distribution logs
        // channel.bind('wallet-distribution', function(data) {
        //     $(".commission-distribution-logs").append('<p>'+data.log+'</p>');
        // });
        //all trades logs
        channel.bind('accounts', function(data) {
            $(".accounts-logs").append('<p>'+data.log+'</p>');
        });

        $("#StartDate").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            maxDate: new Date(),
            inline: true,
            onSelect: function(selected) {
                $("#EndDate").datepicker("option","minDate", selected)
            }
        });

        $("#EndDate").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            minDate: $("#StartDate").val(),
            maxDate: new Date(),
            inline: true,
            onSelect: function(selected) {
            $("#StartDate").datepicker("option","maxDate", selected)
            }
        });
       
        $('.importData').click(function () {
            let mtFourBroker = $('#mtFourBroker').val();
            let startDate = $('#StartDate').val();
            let endDate = $('#EndDate').val();
            if(mtFourBroker == '' && startDate == '' && endDate == ''){
                $('.errorInfo').css('color','red');
                $('.errorInfo').html("Please select info!")
            } else if(mtFourBroker == '') {
                $('.errorInfo').css('color','red');
                $('.errorInfo').html("Please select Broker")
            } else if(startDate == '') {
                $('.errorInfo').css('color','red');
                $('.errorInfo').html("Please select start date")
            } else if(endDate == '') {
                $('.errorInfo').css('color','red');
                $('.errorInfo').html("Please select end date")
            }else{
                $('#importData').prop("disabled", true);
                $(".accounts-logs").html("");
                $('.errorInfo').html("");
                $(".loader").css("display", "block");
                $('#msg').css('color','green');
                $('#msg').html("Fetching data from "+ startDate +" to "+ endDate);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.importApidata')}}",
                    data: {
                        mtFourBroker: mtFourBroker,
                        StartDate   : startDate,
                        EndDate     : endDate
                    },
                    success: function (data) {
                        data = JSON.parse(data)
                        // console.log(data)
                        // if(data.result === false){
                        //     $('.resultHTML').html("<div class='alert alert-danger'>" + data.message + "</div>")  
                        // }else{
                        //     $('.resultHTML').html("<div class='alert alert-info'>" + data.message + "</div>") 
                        // }
                        $('#tradesMsg').css('display','block');
                        $('#tradesMsg').html(data);
                        $('#importData').prop("disabled", false);
                        $(".loader").css("display", "none");
                    },
                    error: function (file, response) {
                        $('#importData').prop("disabled", false);
                        $(".loader").css("display", "none");
                        $('.resultHTML').css('color','red');
                        // $('.resultHTML').html("Something went wrong! please try again.")  
                    }
                });
            }
        });
    });
</script>
@endsection
