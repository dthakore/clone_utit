@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('mt_four_deposit_withdraw_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.mt-four-deposit-withdraws.create') }}">
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
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-MtFourDepositWithdraw">
                            <thead>
                                <tr>
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
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\MtFourDepositWithdraw::API_TYPE_SELECT as $key => $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
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
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mtFourDepositWithdraws as $key => $mtFourDepositWithdraw)
                                    <tr data-entry-id="{{ $mtFourDepositWithdraw->id }}">
                                        <td>
                                            {{ $mtFourDepositWithdraw->login ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourDepositWithdraw->ticket ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourDepositWithdraw->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\MtFourDepositWithdraw::API_TYPE_SELECT[$mtFourDepositWithdraw->api_type] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourDepositWithdraw->close_time ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourDepositWithdraw->profit ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourDepositWithdraw->comment ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\MtFourDepositWithdraw::IS_ACCOUNTED_FOR_SELECT[$mtFourDepositWithdraw->is_accounted_for] ?? '' }}
                                        </td>
                                        <td>
                                            @can('mt_four_deposit_withdraw_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.mt-four-deposit-withdraws.show', $mtFourDepositWithdraw->id) }}">
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
  let table = $('.datatable-MtFourDepositWithdraw:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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