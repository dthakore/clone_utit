@extends('layouts.admin')
@section('content')
@can('allwallettransaction_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.allwallettransactions.create') }}">
                {{ trans('global.add') }} Wallet Transaction
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Allwallettransaction', 'route' => 'admin.allwallettransactions.parseCsvImport'])
        </div>
    </div>
@endcan
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color : #006fe6;
    }
</style>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.allwallettransaction.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="row pull-right">
            <button type="button" class="btn btn-info filter" data-toggle="modal" data-target="#filterModal">Filter</button>
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
                        <form method="POST" id="search-form">
                            <div class="col-md-12">
                                <label>User ID</label>
                                <input class="form-control" type="text" id="search_user_id" placeholder="Search" autocomplete="off">
                            </div>
                        <div class="col-md-12">
                            <label>{{ trans('cruds.allwallettransaction.fields.user') }}</label>
                            <select class="form-control multiple-select" id="user" multiple="multiple">
                                <option value="0">{{ trans('global.all') }}</option>
                                @foreach($users as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>{{ trans('cruds.allwallettransaction.fields.transaction_type') }}</label>
                            <select class="form-control"  id="transaction_type">
                                <option value="0">{{ trans('global.all') }}</option>
                                @foreach(App\Models\Allwallettransaction::TRANSACTION_TYPE_SELECT as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>{{ trans('cruds.allwallettransaction.fields.reference') }}</label>
                            <select class="form-control multiple-select" id="reference" multiple="multiple">
                                <option value="0">{{ trans('global.all') }}</option>
                                @foreach($wallet_meta_types as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->reference_desc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>{{ trans('cruds.allwallettransaction.fields.transaction_comment') }}</label>
                            <input class="form-control" type="text" id="transaction_comment" placeholder="{{ trans('global.search') }}">
                        </div>
                        <div class="col-md-12">
                            <label>{{ trans('cruds.allwallettransaction.fields.transaction_status') }}</label>
                            <select class="form-control" id="transaction_status">
                                <option value="0">{{ trans('global.all') }}</option>
                                @foreach(App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>{{ trans('cruds.allwallettransaction.fields.amount') }}</label>
                        </div>
                        <div class="row" style="margin-left: 0;margin-right: 0">
                            <div class="col-md-6">
                                <input class="form-control" id="fromAmount" type="number" placeholder="From">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="toAmount" type="number" placeholder="To">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Date</label>
                        </div>
                        <div class="row" style="margin-left: 0;margin-right: 0">
                            <div class="col-md-6">
                                <input class="form-control" id="StartDate" type="text" placeholder="From">
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="EndDate" type="text" placeholder="To">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Allwallettransaction">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        User ID
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.wallet_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.transaction_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.reference') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.denomination') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.allwallettransaction.fields.amount') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
{{--                <tr>--}}
{{--                    <td>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($users as $key => $item)--}}
{{--                                <option value="{{ $item->name }}">{{ $item->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($wallet_types as $key => $item)--}}
{{--                                <option value="{{ $item->wallet_type }}">{{ $item->wallet_type }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search" strict="true">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach(App\Models\Allwallettransaction::TRANSACTION_TYPE_SELECT as $key => $item)--}}
{{--                                <option value="{{ $key }}">{{ $item }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($wallet_meta_types as $key => $item)--}}
{{--                                <option value="{{ $item->reference_desc }}">{{ $item->reference_desc }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($denominations as $key => $item)--}}
{{--                                <option value="{{ $item->denomination_type }}">{{ $item->denomination_type }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search" strict="true">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach(App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT as $key => $item)--}}
{{--                                <option value="{{ $key }}">{{ $item }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                    </td>--}}
{{--                </tr>--}}
            </thead>
        </table>
    </div>
</div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
            var oldExportAction = function (self, e, dt, button, config) {
                if (button[0].className.indexOf('buttons-excel') >= 0) {
                    if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                    } else {
                        $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    }
                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                }
            };
            var newExportAction = function (e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function (e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function (e, settings) {
                        // Call the original action function
                        oldExportAction(self, e, dt, button, config);
                        dt.one('preXhr', function (e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            };


    window.walletFilter = function(){
        $('#filterModal .close').click();
        $('#search-form').submit();
    };
    window.clearFilters = function(){
        $('#transaction_type').val(0).trigger('change');
        $('#search_user_id').val('').trigger('change');
        $('#StartDate').val('').trigger('change');
        $('#EndDate').val('').trigger('change');
        $('#transaction_status').val(0).trigger('change');
        $('#user').val(0).trigger('change');
        $('#reference').val('').trigger('change');
        $('#transaction_comment').val('');
        $('#transaction_status').val(0).trigger('change');
        $('#fromAmount').val('').trigger('change');
        $('#toAmount').val('').trigger('change');
        $('#filterModal .close').click();
        $('#search-form').submit();
    };
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let exportAll = {
          text: 'Export All',
          extend: 'excel',
      className: 'btn-default',
      action: newExportAction
      }
      dtButtons.push(exportAll)
@can('allwallettransaction_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.allwallettransactions.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  var dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
{{--    ajax: "{{ route('admin.allwallettransactions.index') }}",--}}
      ajax: {
          url: '{{ route("admin.allwallettransactions.index") }}',
          data: function (d) {
              d.transaction_type = $('#transaction_type').val();
              d.userid = $('#search_user_id').val();
              d.start_date = $('#StartDate').val();
              d.end_date = $('#EndDate').val();
              d.status = $('#transaction_status').val();
              d.user = $('#user').val();
              d.reference = $('#reference').val();
              d.transaction_comment = $('#transaction_comment').val();
              d.transaction_status = $('#transaction_status').val();
              d.fromAmount = $('#fromAmount').val();
              d.toAmount = $('#toAmount').val();
              d.user_id = '<?php echo (isset($_GET['id']) && $_GET['id']>0)?$_GET['id']:"" ?>';
          }
      },
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'user_id',
  name: 'user.id',
    render: function (data, type, full, meta) {
        if(data == 0){
            return data;
        }else{
            return '<a href="/admin/users/'+full.id+'" target="_blank"> '+data+'</a>';
        }
    }
},
{ data: 'user_name', name: 'user.name' },
{ data: 'user_email', name: 'user.email' },
{ data: 'wallet_type_wallet_type', name: 'wallet_type.wallet_type' },
{ data: 'transaction_type', name: 'transaction_type' },
{ data: 'reference_reference_desc', name: 'reference.reference_desc' },
{ data: 'transaction_comment', name: 'transaction_comment' },
{ data: 'denomination_denomination_type', name: 'denomination.denomination_type' },
{ data: 'transaction_status', name: 'transaction_status' },
{ data: 'amount', name: 'amount' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
    language: {
        loadingRecords: '&nbsp;',
        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Processing...</span> '
    }
  };
  var table = $('.datatable-Allwallettransaction').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
        $('#search-form').on('submit', function(e) {
            table.ajax.reload();
            e.preventDefault();
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
});

    $(document).ready(function(){

        $('.multiple-select').select2();

        $("#StartDate").datepicker().on('changeDate', function(selected){
            dateFormat: "dd/mm/yy",
            startDate = new Date(selected.date.valueOf());
            $('#EndDate').datepicker('setStartDate', startDate);
        });

        $("#EndDate").datepicker().on('changeDate', function(selected){
            dateFormat: "dd/mm/yy",
            startDate = new Date(selected.date.valueOf());
            $('#StartDate').datepicker('setEndDate', startDate);
        });
    });

</script>
@endsection
