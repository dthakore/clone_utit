@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12" style="margin-bottom: 10px;" align="right">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addFunds" data-whatever="@mdo">Add Funds</button>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 style="color: blue">€ {{ $balance }}</h2>
                            <h6>Current Balance</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 style="color: teal">€ {{ $maxBalance }}</h2>
                            <h6>Maximum Balance</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 style="color: blue">€ {{$totalPayouts}}</h2>
                            <h6>Total Payouts</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <h2 style="color: blue">€ {{ $reserve_balance }}</h2>
                            <h6>Reserve Wallet Balance</h6>
                        </div>
                        <div class="col-5" style="text-align: center">
                            <a href="#" id="payout_settings"><i class="fa fa-2x fa-cog"></i></a>
                            <h6 style="margin-top: 10px">Settings</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addFunds" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Funds</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-funds-form">
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount:</label>
                            <input type="text" class="form-control" name="amount" id="amount">
                            <span class="error hide amount">This field is required</span>
                        </div>
                        <div class="loader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="form-group">
                            <label for="currency" class="col-form-label">Currency:</label>
                            <select name="currency" id="currency" class="form-control">
                                <option value="" disabled selected>Select Currency</option>
                                <option value="usd">USD</option>
                                <option value="eur">EUR</option>
                                <option value="usdt">USDT</option>
                            </select>
                            <span class="error hide currency">This field is required</span>
                        </div>
                        @if (isset($qrCode['pay_address']))
                            <div class="form-group">
                                <label class="col-form-label">QR Code:</label>
                                {!! QrCode::size(200)->generate($qrCode['pay_address']) !!}
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="add-funds-to-wallet">Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    {{ trans('cruds.allwallettransaction.title_singular') }} {{ trans('global.list') }}
                </div> -->
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active all" data-toggle="tab" href="#all_trans_tab"
                                                role="tab"><span
                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">All</span></a></li>
                        <li class="nav-item"><a class="nav-link aff" data-toggle="tab" href="#affiliates_tab"
                                                role="tab"><span
                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                        class="hidden-xs-down">Affiliate Earnings</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#commissions_tab"
                                                role="tab"><span
                                        class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                        class="hidden-xs-down">Cashback</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payouts_tab" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span> <span
                                        class="hidden-xs-down">Payouts</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#order_payments_tab" role="tab"><span
                                        class="hidden-sm-up"><i class="ti-email"></i></span><span
                                        class="hidden-xs-down">Order Payments</span></a></li>
                    </ul>
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="all_trans_tab" role="tabpanel">
                            <div class="p-20">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- <div class="checkbox-group" style="text-align: center">
                                                <input type="checkbox" name="all_trans" id="all_trans_affiliates"
                                                    value="2" class="filled-in chk-col-custom-light-blue" checked="">
                                                <label for="all_trans_affiliates" class="margin-right-10">Affiliate Earnings</label>

                                                <input type="checkbox" name="all_trans" id="all_trans_cashback"
                                                    value="1" class="filled-in chk-col-teal" checked="">
                                                <label for="all_trans_cashback" class="margin-right-10">Cashback</label>

                                                <input type="checkbox" name="all_trans" id="all_trans_payouts" value="3"
                                                    class="filled-in chk-col-yellow" checked="">
                                                <label for="all_trans_payouts" class="margin-right-10">Payouts</label>

                                                <input type="checkbox" name="all_trans" id="all_trans_order_payments" value="4"
                                                    class="filled-in chk-col-purple" checked="">
                                                <label for="all_trans_order_payments" class="margin-right-10">Order Payments</label>
                                            </div> -->
                                            <div class="table-responsive">
                                                <table class=" table table-bordered table-striped table-hover datatable datatable-Allwallettransaction">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                                                            </th>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                                                            </th>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.amount') }}
                                                            </th>
                                                            <th>
                                                                Date
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($allwallettransactions as $key => $allwallettransaction)
                                                            <tr data-entry-id="{{ $allwallettransaction->id }}">
                                                                <td>
                                                                    {{ $allwallettransaction->transaction_comment ?? '' }}
                                                                </td>
                                                                @php
                                                                  $status = App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$allwallettransaction->transaction_status] ?? '';
                                                                    if( $status == 'Pending' ){
                                                                        $label = 'warning';
                                                                    }elseif( $status == 'On Hold' ){
                                                                        $label = 'info';
                                                                    }elseif( $status == 'Approved' ){
                                                                        $label = 'success';
                                                                    }elseif( $status == 'Rejected' ){
                                                                        $label = 'danger';
                                                                    }
                                                                @endphp
                                                                <td>
                                                                    <span class='label label-{{$label}}'>{{ $status }}</span>
                                                                </td>
                                                                <td>
                                                                    € {{ $allwallettransaction->amount ?? '' }}
                                                                </td>
                                                                <td>
                                                                    {{ date('d F, Y',strtotime($allwallettransaction->created_at)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="affiliates_tab" role="tabpanel">
                            <div class="p-20">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- <div class="checkbox-group" style="text-align: center">
                                                <input type="checkbox" name="affiliates" id="affiliate_first_tier"
                                                    value="1" class="filled-in chk-col-custom-light-blue" checked="">
                                                <label for="affiliate_first_tier" class="margin-right-10">First Tier</label>

                                                <input type="checkbox" name="affiliates" id="affiliate_second_tier"
                                                    value="2" class="filled-in chk-col-custom-dark-blue" checked="">
                                                <label for="affiliate_second_tier" class="margin-right-10">Second Tier</label>
                                            </div> -->
                                            <div class="table-responsive">
                                                <table class=" table table-bordered table-striped table-hover datatable datatable-affiliate_transaction">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                                                            </th>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                                                            </th>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.amount') }}
                                                            </th>
                                                            <th>
                                                                Date
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($affiliate_wallet as $key => $affiliate_transaction)
                                                            <tr data-entry-id="{{ $affiliate_transaction->id }}">
                                                                <td>
                                                                    {{ $affiliate_transaction->transaction_comment ?? '' }}
                                                                </td>
                                                                @php
                                                                  $status = App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$affiliate_transaction->transaction_status] ?? '';
                                                                    if( $status == 'Pending' ){
                                                                        $label = 'warning';
                                                                    }elseif( $status == 'On Hold' ){
                                                                        $label = 'info';
                                                                    }elseif( $status == 'Approved' ){
                                                                        $label = 'success';
                                                                    }elseif( $status == 'Rejected' ){
                                                                        $label = 'danger';
                                                                    }
                                                                @endphp
                                                                <td>
                                                                    <span class='label label-{{$label}}'>{{ $status }}</span>
                                                                </td>
                                                                <td>
                                                                    € {{ $affiliate_transaction->amount ?? '' }}
                                                                </td>
                                                                <td>
                                                                    {{ date('d F, Y',strtotime($affiliate_transaction->created_at)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="commissions_tab" role="tabpanel">
                            <div class="p-20">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" table table-bordered table-striped table-hover datatable datatable-commission_transaction">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                                                            </th>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                                                            </th>
                                                            <th>
                                                                {{ trans('cruds.allwallettransaction.fields.amount') }}
                                                            </th>
                                                            <th>
                                                                Date
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($cashback_wallet as $key => $commission_transaction)
                                                            <tr data-entry-id="{{ $commission_transaction->id }}">
                                                                <td>
                                                                    {{ $commission_transaction->transaction_comment ?? '' }}
                                                                </td>
                                                                @php
                                                                  $status = App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$commission_transaction->transaction_status] ?? '';
                                                                    if( $status == 'Pending' ){
                                                                        $label = 'warning';
                                                                    }elseif( $status == 'On Hold' ){
                                                                        $label = 'info';
                                                                    }elseif( $status == 'Approved' ){
                                                                        $label = 'success';
                                                                    }elseif( $status == 'Rejected' ){
                                                                        $label = 'danger';
                                                                    }
                                                                @endphp
                                                                <td>
                                                                    <span class='label label-{{$label}}'>{{ $status }}</span>
                                                                </td>
                                                                <td>
                                                                    € {{ $commission_transaction->amount ?? '' }}
                                                                </td>
                                                                <td>
                                                                    {{ date('d F, Y',strtotime($commission_transaction->created_at)) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="payouts_tab" role="tabpanel">
                            <div class="alert alert-info">Please note that you are eligible for payout when the total balance in your wallet reaches 50€. An administration fee of 5€ will be deducted with every payout.</div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class=" table table-bordered table-striped table-hover datatable datatable-payout_transaction">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                                                        </th>
                                                        <th>
                                                            {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                                                        </th>
                                                        <th>
                                                            {{ trans('cruds.allwallettransaction.fields.amount') }}
                                                        </th>
                                                        <th>
                                                            Date
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($payout_wallet as $key => $payout_transaction)
                                                        <tr data-entry-id="{{ $payout_transaction->id }}">
                                                            <td>
                                                                {{ $payout_transaction->transaction_comment ?? '' }}
                                                            </td>
                                                            @php
                                                                $status = App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$payout_transaction->transaction_status] ?? '';
                                                                if( $status == 'Pending' ){
                                                                    $label = 'warning';
                                                                }elseif( $status == 'On Hold' ){
                                                                    $label = 'info';
                                                                }elseif( $status == 'Approved' ){
                                                                    $label = 'success';
                                                                }elseif( $status == 'Rejected' ){
                                                                    $label = 'danger';
                                                                }
                                                            @endphp
                                                            <td>
                                                                <span class='label label-{{$label}}'>{{ $status }}</span>
                                                            </td>
                                                            <td>
                                                                € {{ $payout_transaction->amount ?? '' }}
                                                            </td>
                                                            <td>
                                                                {{ date('d F, Y',strtotime($payout_transaction->created_at)) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="order_payments_tab" role="tabpanel">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class=" table table-bordered table-striped table-hover datatable datatable-order_transaction">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                                                        </th>
                                                        <th>
                                                            {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                                                        </th>
                                                        <th>
                                                            {{ trans('cruds.allwallettransaction.fields.amount') }}
                                                        </th>
                                                        <th>
                                                            Date
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order_payment as $key => $order_transaction)
                                                        <tr data-entry-id="{{ $order_transaction->id }}">
                                                            <td>
                                                                {{ $order_transaction->transaction_comment ?? '' }}
                                                            </td>
                                                            @php
                                                                $status = App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$order_transaction->transaction_status] ?? '';
                                                                if( $status == 'Pending' ){
                                                                    $label = 'warning';
                                                                }elseif( $status == 'On Hold' ){
                                                                    $label = 'info';
                                                                }elseif( $status == 'Approved' ){
                                                                    $label = 'success';
                                                                }elseif( $status == 'Rejected' ){
                                                                    $label = 'danger';
                                                                }
                                                            @endphp
                                                            <td>
                                                                <span class='label label-{{$label}}'>{{ $status }}</span>
                                                            </td>
                                                            <td>
                                                                € {{ $order_transaction->amount ?? '' }}
                                                            </td>
                                                            <td>
                                                                {{ date('d F, Y',strtotime($order_transaction->created_at)) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
<script>
$(document).ready(function(){
    // walletDatatable('Allwallettransaction');
    // walletDatatable('affiliate_transaction');
    // walletDatatable('commission_transaction');
    // walletDatatable('payout_transaction');
    // walletDatatable('order_transaction');
    // //set wallet transactions datatable
    // function walletDatatable(table_name) {

    //     let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    //     $.extend(true, $.fn.dataTable.defaults, {
    //     orderCellsTop: true,
    //     order: [[ 1, 'desc' ]],
    //     pageLength: 10,
    //     });
    //     let table = $('.datatable-'+table_name+':not(.ajaxTable)').DataTable({ buttons: dtButtons })
    //     $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
    //         $($.fn.dataTable.tables(true)).DataTable()
    //             .columns.adjust();
    //     });

    //     table.on('column-visibility.dt', function(e, settings, column, state) {
    //         visibleColumnsIndexes = []
    //         table.columns(":visible").every(function(colIdx) {
    //             visibleColumnsIndexes.push(colIdx);
    //         });
    //     });
    // }

    $('#add-funds-to-wallet').click(function(){
        var amount = $('#amount').val();
        var currency = $('#currency').val();
        if(amount == '' && currency == null){
            $('.error').removeClass('hide');
        } else if(amount == ''){
            $('.amount').removeClass('hide');
        } else if(currency == null){
            $('.currency').removeClass('hide');
        } else {
            $.ajax({
                url: "{{ route('frontend.add.funds') }}",
                type: "POST",
                timeout: 0,
                data: {
                    amount: amount,
                    currency: currency
                },
                beforeSend:function () {
                    $('.btn').prop('disabled',true);
                    $('.loader').css('display','block');
                },
                success: function(data) {
                    $('.loader').css('display','none');
                    $('.btn').prop('disabled',false);
                    if(data.status == 1) {
                        $("#addFunds").modal('hide');
                        toastr.success(data.message);
                        location.reload();
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }
    });
});
</script>
@endsection
