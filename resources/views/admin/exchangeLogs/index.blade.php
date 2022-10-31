@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.exchangeLog.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ExchangeLog">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.error') }}
                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.log') }}
                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.order') }}
                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.exchange') }}
                    </th>
                    <th>
                        {{ trans('cruds.exchangeLog.fields.request') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
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
@can('exchange_log_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.exchange-logs.massDestroy') }}",
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.exchange-logs.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id',
  name: 'id',
    render: function (data, type, full, meta) {
        if(data == 0){
            return data;
        }else{
            return '<a href="/admin/exchange-logs/'+full.id+'" target="_blank"> '+data+'</a>';
        }
    }
},
{ data: 'code', name: 'code' },
{ data: 'error', name: 'error' },
{ data: 'log', name: 'log' },
{ data: 'order_id', name: 'order_id' },
{ data: 'exchange', name: 'exchange' },
{ data: 'request', name: 'request' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-ExchangeLog').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection