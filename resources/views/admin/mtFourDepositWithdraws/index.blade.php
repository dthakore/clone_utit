@extends('layouts.admin')
@section('content')
@can('mt_four_deposit_withdraw_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.mt-four-deposit-withdraws.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.mtFourDepositWithdraw.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'MtFourDepositWithdraw', 'route' => 'admin.mt-four-deposit-withdraws.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.mtFourDepositWithdraw.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-MtFourDepositWithdraw">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.login') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.ticket') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.api_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.close_time') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.profit') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.comment') }}
                    </th>
                    <th>
                        {{ trans('cruds.mtFourDepositWithdraw.fields.is_accounted_for') }}
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
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\MtFourDepositWithdraw::API_TYPE_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
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
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\MtFourDepositWithdraw::IS_ACCOUNTED_FOR_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.mt-four-deposit-withdraws.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'login', name: 'login' },
{ data: 'ticket', name: 'ticket' },
{ data: 'email', name: 'email' },
{ data: 'api_type', name: 'api_type' },
{ data: 'close_time', name: 'close_time' },
{ data: 'profit', name: 'profit' },
{ data: 'comment', name: 'comment' },
{ data: 'is_accounted_for', name: 'is_accounted_for' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-MtFourDepositWithdraw').DataTable(dtOverrideGlobals);
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
});

</script>
@endsection