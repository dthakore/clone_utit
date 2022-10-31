@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('allwallettransaction_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.allwallettransactions.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.allwallettransaction.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'Allwallettransaction', 'route' => 'admin.allwallettransactions.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.allwallettransaction.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Allwallettransaction">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.user') }}
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
                                <tr>
                                    <!-- <td>
                                    </td> -->
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($users as $key => $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($wallet_types as $key => $item)
                                                <option value="{{ $item->wallet_type }}">{{ $item->wallet_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\Allwallettransaction::TRANSACTION_TYPE_SELECT as $key => $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($wallet_meta_types as $key => $item)
                                                <option value="{{ $item->reference_desc }}">{{ $item->reference_desc }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                        <select class="search">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach($denominations as $key => $item)
                                                <option value="{{ $item->denomination_type }}">{{ $item->denomination_type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT as $key => $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allwallettransactions as $key => $allwallettransaction)
                                    <tr data-entry-id="{{ $allwallettransaction->id }}">
                                        <td>
                                            {{ $allwallettransaction->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $allwallettransaction->wallet_type->wallet_type ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Allwallettransaction::TRANSACTION_TYPE_SELECT[$allwallettransaction->transaction_type] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $allwallettransaction->reference->reference_desc ?? '' }}
                                        </td>
                                        <td>
                                            {{ $allwallettransaction->transaction_comment ?? '' }}
                                        </td>
                                        <td>
                                            {{ $allwallettransaction->denomination->denomination_type ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$allwallettransaction->transaction_status] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $allwallettransaction->amount ?? '' }}
                                        </td>
                                        <td>
                                            @can('allwallettransaction_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.allwallettransactions.show', $allwallettransaction->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('allwallettransaction_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.allwallettransactions.edit', $allwallettransaction->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('allwallettransaction_delete')
                                                <form action="{{ route('frontend.allwallettransactions.destroy', $allwallettransaction->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
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
@can('allwallettransaction_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.allwallettransactions.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-Allwallettransaction:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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