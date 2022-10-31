@extends('layouts.admin')
@section('content')
@can('user_exchange_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.user-exchanges.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userExchange.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.userExchange.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-UserExchange">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userExchange.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userExchange.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.userExchange.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.userExchange.fields.exchange') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userExchanges as $key => $userExchange)
                        <tr data-entry-id="{{ $userExchange->id }}">
                            <td>

                            </td>
                            <td>
                               <a href="{{ route('admin.user-exchanges.show', $userExchange->id) }}" target="_blank">{{ $userExchange->id ?? '' }}</a>
                            </td>
                            <td>
                                {{ $userExchange->name ?? '' }}
                            </td>
                            <td>
                                {{ $userExchange->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $userExchange->exchange->name ?? '' }}
                            </td>
                            <td>
                                @can('user_exchange_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.user-exchanges.show', $userExchange->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_exchange_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.user-exchanges.edit', $userExchange->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_exchange_delete')
                                    <form action="{{ route('admin.user-exchanges.destroy', $userExchange->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_exchange_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-exchanges.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-UserExchange:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection