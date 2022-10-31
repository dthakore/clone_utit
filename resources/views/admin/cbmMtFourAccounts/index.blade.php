@extends('layouts.admin')
@section('content')
@can('cbm_mt_four_account_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.cbm-mt-four-accounts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.cbmMtFourAccount.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CbmMtFourAccount', 'route' => 'admin.cbm-mt-four-accounts.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.cbmMtFourAccount.title_singular') }} {{ trans('global.list') }}
        <div class="row" style="flex-direction: row-reverse;">
            <a class="btn btn-success exportData" id="exportData"  href="#">Export All</a>
            &nbsp;&nbsp;
            <button type="button" class="btn btn-info filter" data-toggle="modal" data-target="#filterModal"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
        </div>
    </div>

    <div class="card-body">
        
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CbmMtFourAccount">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.login') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.balance') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.equity') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.email_address') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.agent') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.brand') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.leverage') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.max_equity') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.max_balance') }}
                    </th>
                    <th>
                        {{ trans('cruds.cbmMtFourAccount.fields.broker') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($mt_four_brokers as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<div id="filterModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Filter</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{-- action="{{ route('admin.cbm-mt-four-accounts.index') }}" --}}
                <form method="POST" id="search-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input name="exportAllClicked" type="hidden" id="exportAllClicked" value="0">
                    <div class="col-md-12">
                        <label>{{ trans('cruds.cbmMtFourAccount.fields.login') }}</label>
                        <input class="form-control" type="text" id="login" name="login" placeholder="{{ trans('global.search') }}">
                    </div>
                    <div class="col-md-12">
                        <label>{{ trans('cruds.cbmMtFourAccount.fields.email') }}</label>
                        <input class="form-control" type="text" id="email" name="email" placeholder="{{ trans('global.search') }}">
                    </div>
                    <div class="col-md-12">
                        <label>{{ trans('cruds.cbmMtFourAccount.fields.agent') }}</label>
                        <input class="form-control" type="text" id="agent" name="agent" placeholder="{{ trans('global.search') }}">
                    </div>
                    <div class="col-md-12">
                        <label>{{ trans('cruds.cbmMtFourAccount.fields.broker') }}</label>
                        <select class="form-control select2" id="broker" name="broker[]" multiple="multiple">
                            @foreach($mt_four_brokers as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <label>{{ trans('cruds.cbmMtFourAccount.fields.balance') }}</label>
                    </div>
                    <div class="row" style="margin-left: 0;margin-right: 0">
                        <div class="col-md-6">
                            <input class="form-control" id="fromAmount" name="fromAmount" type="number" placeholder="From">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" id="toAmount" name="toAmount" type="number" placeholder="To">
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="clearFilters();">Clear</button>
                <button type="button" class="btn btn-success" onclick="walletFilter();">Apply</button>
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    window.walletFilter = function(){
        $('#exportAllClicked').val(0);
        $('#filterModal .close').click();
        $('#search-form').submit();
    };
    window.clearFilters = function(){
        $('#fromAmount').val(0).trigger('change');
        $('#toAmount').val(0).trigger('change');
        $('#login').val('').trigger('change');
        $('#email').val('').trigger('change');
        $('#agent').val('').trigger('change');
        $('#broker').val('');
        
        $('#filterModal .close').click();
        $('#search-form').submit();
    };
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: {
                url: "{{ route('admin.cbm-mt-four-accounts.index') }}",
                data: function (d) {
                    d.fromAmount = $('#fromAmount').val();
                    d.toAmount = $('#toAmount').val();
                    d.login = $('#login').val();
                    d.email = $('#email').val();
                    d.agent = $('#agent').val();
                    d.broker = $('#broker').val();
                    
                }
            },
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'login', name: 'login' },
                { data: 'name', name: 'name' },
                { data: 'balance', name: 'balance' },
                { data: 'equity', name: 'equity' },
                { data: 'email_address', name: 'email_address' },
                { data: 'agent', name: 'agent' },
                { data: 'brand', name: 'brand' },
                { data: 'leverage', name: 'leverage' },
                { data: 'max_equity', name: 'max_equity' },
                { data: 'max_balance', name: 'max_balance' },
                { data: 'broker_name', name: 'broker.name' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            orderCellsTop: true,
            order: [[ 1, 'asc' ]],
            pageLength: 25,
        };
        let table = $('.datatable-CbmMtFourAccount').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    
        let visibleColumnsIndexes = null;
        $('.datatable thead').on('input', '.search', function () {
            let strict = $(this).attr('strict') || false
            let value = strict && this.value ? "^" + this.value + "$" : this.value

            let index = $(this).parent().index()
            if (visibleColumnsIndexes !== null) {
                index = visibleColumnsIndexes[index]
            }

            table
                .column(index)
                .search(value, strict)
                .draw()
        });
        table.on('column-visibility.dt', function(e, settings, column, state) {
            visibleColumnsIndexes = []
            table.columns(":visible").every(function(colIdx) {
                visibleColumnsIndexes.push(colIdx);
            });
        })
        $('#search-form').on('submit', function(e) {
            var exportVal = $('#exportAllClicked').val();
            if(exportVal === '0'){
                table.ajax.reload();
                e.preventDefault();
            }  
        });
        $('#exportData').on('click', function(e) {
            $('#exportAllClicked').val(1);
            $('#search-form').attr('action', "{{ route('admin.cbmMt4AccountsExport') }}")
            $('#search-form').submit();
        });
    });
</script>
@endsection