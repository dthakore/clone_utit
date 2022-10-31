@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('user_position_account_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.user-position-accounts.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.userPositionAccount.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'UserPositionAccount', 'route' => 'admin.user-position-accounts.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.userPositionAccount.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-UserPositionAccount">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.user_account_num') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.login') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.email_address') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.balance') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.equity') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.matrix_node_num') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.matrix') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.user_ownership') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.previous_login') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.userPositionAccount.fields.cluster') }}
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
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\UserPositionAccount::TYPE_SELECT as $key => $item)
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
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userPositionAccounts as $key => $userPositionAccount)
                                    <tr data-entry-id="{{ $userPositionAccount->id }}">
                                        <td>
                                            {{ $userPositionAccount->user_account_num ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->login ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\UserPositionAccount::TYPE_SELECT[$userPositionAccount->type] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->email_address ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->balance ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->equity ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->matrix_node_num ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->matrix ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->user_ownership ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->previous_login ?? '' }}
                                        </td>
                                        <td>
                                            {{ $userPositionAccount->cluster ?? '' }}
                                        </td>
                                        <td>



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
  let table = $('.datatable-UserPositionAccount:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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