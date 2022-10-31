@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('trade_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.trades.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.trade.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.trade.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Trade">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.bot') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.session') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.symbol') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.user') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.requested_amount') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.side') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.comment') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.failure_reason') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.exchange_order_status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.original_orders') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.exchange_order_ref') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.exchange_trade_ref') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.requested_price') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.requested_quantity') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.executed_price') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.executed_amount') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.executed_quantity') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.cover') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.trade.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trades as $key => $trade)
                                    <tr data-entry-id="{{ $trade->id }}">
                                        <td>
                                            {{ $trade->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->bot->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->session->status ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->symbol->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->requested_amount ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Trade::SIDE_SELECT[$trade->side] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->comment ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->failure_reason ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->exchange_order_status ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->original_orders ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->exchange_order_ref ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->exchange_trade_ref ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->requested_price ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->requested_quantity ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->executed_price ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->executed_amount ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->executed_quantity ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->cover->index ?? '' }}
                                        </td>
                                        <td>
                                            {{ $trade->status ?? '' }}
                                        </td>
                                        <td>
                                            @can('trade_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.trades.show', $trade->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('trade_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.trades.edit', $trade->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('trade_delete')
                                                <form action="{{ route('frontend.trades.destroy', $trade->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('trade_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.trades.massDestroy') }}",
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
  let table = $('.datatable-Trade:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection