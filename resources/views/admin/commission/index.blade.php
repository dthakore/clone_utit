@extends('layouts.admin')
@section('content')
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
<div class="card">
    <div class="card-header">
        Commission Distribution
    </div>
    <div class="card-body">
        <div class="block block-themed block-rounded">
            <div class="block-content">
                <div class="row">
                    <div class="col-md-4">
                        <label>Start Date</label>
                        <div class="form-group">
                            <div class='input-group'>
                                <input type='text' class="form-control" name="start_date" id="start_date"/>
                            </div>
                            <span class="start_msg"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>End Date</label>
                        <div class="form-group">
                            <div class='input-group'>
                                <input type='text' class="form-control" name="end_date" id="end_date"/>
                            </div>
                            <span class="end_msg"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p id="msg" style="text-align: center;margin-left: 8px;"></p>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-12">
                        <div class="card card-primary card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#all-trades-tabs" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">All Trades</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-home-tab" data-toggle="pill" href="#commission-distribution-tabs" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Commission Distribution</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade active show" id="all-trades-tabs" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        <button class="btn btn-minw btn-primary" type="button" id="fetchAlltrades">Fetch All Trades</button>
                                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                                            1. Find all trades with Reference ID between selected start date and end date.<br>
                                        </p>
                                        <p style="background: whitesmoke !important; display: none" id="tradesMsg"></p>
                                        <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                        </div>
                                        <div class="all-trades-logs pusher-logs">
                                            <p>Logs will appear here</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="commission-distribution-tabs" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        <button class="btn btn-minw btn-primary" type="button" id="distributeCommission">Distribute Commission</button>
                                        <p style="margin-top: 15px"> On button click, following process will be executed sequentially: <br>
                                            1. Find user hierarchy tree till parent. <br>
                                            2. Compute commission amount based on the commission rule. <br>
                                            3. Commission related rows will be added to all_wallet_transactions table. <br>
                                        </p>
                                        <p style="background: whitesmoke !important; display: none" id="commissionMsg"></p>
                                        <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                        </div>
                                        <div class="commission-distribution-logs pusher-logs">
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
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
    });

    var channel = pusher.subscribe('commissions');
    //commission distribution logs
    channel.bind('wallet-distribution', function(data) {
        $(".commission-distribution-logs").append('<p>'+data.log+'</p>');
    });
    //all trades logs
    channel.bind('all-trades', function(data) {
        $(".all-trades-logs").append('<p>'+data.log+'</p>');
    });

    $('#start_date').datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
        inline: true
    });

    $('#end_date').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        //minDate: $("#start_date").val(),
        maxDate: new Date(),
        inline: true
    });

    $('#fetchAlltrades').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if(start_date == '' && end_date == ''){
            $('#msg').css('color','red');
            $('#msg').html("Please enter start date and end date.");
        } else if(start_date == ''){
            $('#msg').css('color','red');
            $('#msg').html("Please enter start date");
        } else if(end_date == ''){
            $('#msg').css('color','red');
            $('#msg').html("Please enter end date.");
        } else {
            $(".all-trades-logs").html("");
            $('#msg').css('color','green');
            $('#msg').html("Fetching all trades from "+ start_date +" to "+ end_date);
            $.ajax({
                url: "{{ route('admin.all.trades') }}",
                type: "POST",
                timeout: 0,
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                beforeSend:function () {
                    $('.btn').prop('disabled',true);
                    $('#tradesMsg').css('display','none');
                    $('.loader').css('display','block');
                },
                success: function(data) {
                    $('.loader').css('display','none');
                    $('.btn').prop('disabled',false);
                    $('#tradesMsg').css('display','block');
                    $('#tradesMsg').html(data);
                }
            });
        }
    });

    $('#distributeCommission').click(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if(start_date == '' && end_date == ''){
            $('#msg').css('color','red');
            $('#msg').html("Please enter start date and end date.");
        } else if(start_date == ''){
            $('#msg').css('color','red');
            $('#msg').html("Please enter start date");
        } else if(end_date == ''){
            $('#msg').css('color','red');
            $('#msg').html("Please enter end date.");
        } else {
            $(".commission-distribution-logs").html("");
            $('#msg').css('color','green');
            $('#msg').html("Calculating commission from "+ start_date +" to "+ end_date);
            $.ajax({
                url: "{{ route('admin.commission.distribute') }}",
                type: "POST",
                timeout: 0,
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                beforeSend:function () {
                    $('.btn').prop('disabled',true);
                    $('#commissionMsg').css('display','none');
                    $('.loader').css('display','block');
                },
                success: function(data) {
                    $('.loader').css('display','none');
                    $('.btn').prop('disabled',false);
                    $('#commissionMsg').css('display','block');
                    $('#commissionMsg').html(data);
                }
            });
        }
    });
});
</script>
@endsection