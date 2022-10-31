@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('cbm_mt_four_account_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.cbm-mt-four-accounts.create') }}">
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
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-CbmMtFourAccount">
                            <thead>
                                <tr>
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
                                    <!-- <td>
                                    </td> -->
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
                            <tbody>
                                @foreach($cbmMtFourAccounts as $key => $cbmMtFourAccount)
                                    <tr data-entry-id="{{ $cbmMtFourAccount->id }}">
                                        <td>
                                            {{ $cbmMtFourAccount->login ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->balance ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->equity ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->email_address ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->agent ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->brand ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->leverage ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->max_equity ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->max_balance ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cbmMtFourAccount->broker->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('cbm_mt_four_account_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.cbm-mt-four-accounts.show', $cbmMtFourAccount->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan



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
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-CbmMtFourAccount:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
})

</script>
@endsection