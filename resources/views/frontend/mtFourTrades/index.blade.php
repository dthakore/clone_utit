@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.mtFourTrade.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-MtFourTrade">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.login') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.agent_number') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.symbol') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.type') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.lots') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.close_time') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.profit') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.agent_commission') }}
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
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mtFourTrades as $key => $mtFourTrade)
                                    <tr data-entry-id="{{ $mtFourTrade->id }}">
                                        <td>
                                            {{ $mtFourTrade->login ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->agent_number ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->symbol ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->type ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->lots ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->close_time ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->profit ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourTrade->agent_commission ?? '' }}
                                        </td>
                                        <td>
                                            @can('mt_four_trade_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.mt-four-trades.show', $mtFourTrade->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan


                                            @can('mt_four_trade_delete')
                                                <form action="{{ route('frontend.mt-four-trades.destroy', $mtFourTrade->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('mt_four_trade_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.mt-four-trades.massDestroy') }}",
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
  let table = $('.datatable-MtFourTrade:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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