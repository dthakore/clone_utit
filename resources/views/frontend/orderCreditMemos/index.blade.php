@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.orderCreditMemo.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-OrderCreditMemo">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.order') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.invoice_number') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.order_total') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.vat') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.refund_amount') }}
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
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderCreditMemos as $key => $orderCreditMemo)
                                    <tr data-entry-id="{{ $orderCreditMemo->id }}">
                                        <td>
                                            {{ $orderCreditMemo->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $orderCreditMemo->order ?? '' }}
                                        </td>
                                        <td>
                                            {{ $orderCreditMemo->invoice_number ?? '' }}
                                        </td>
                                        <td>
                                            {{ $orderCreditMemo->order_total ?? '' }}
                                        </td>
                                        <td>
                                            {{ $orderCreditMemo->vat ?? '' }}
                                        </td>
                                        <td>
                                            {{ $orderCreditMemo->refund_amount ?? '' }}
                                        </td>
                                        <td>
                                            @can('order_credit_memo_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.order-credit-memos.show', $orderCreditMemo->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan


                                            @can('order_credit_memo_delete')
                                                <form action="{{ route('frontend.order-credit-memos.destroy', $orderCreditMemo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('order_credit_memo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.order-credit-memos.massDestroy') }}",
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
  let table = $('.datatable-OrderCreditMemo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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