@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('mt_four_broker_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.mt-four-brokers.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.mtFourBroker.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.mtFourBroker.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-MtFourBroker">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.server_login') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.server_address') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.server_port') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.agent') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.mtFourBroker.fields.comment') }}
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
                                        <select class="search" strict="true">
                                            <option value>{{ trans('global.all') }}</option>
                                            @foreach(App\Models\MtFourBroker::STATUS_SELECT as $key => $item)
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
                                @foreach($mtFourBrokers as $key => $mtFourBroker)
                                    <tr data-entry-id="{{ $mtFourBroker->id }}">
                                        <td>
                                            {{ $mtFourBroker->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourBroker->server_login ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourBroker->server_address ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourBroker->server_port ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourBroker->agent ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\MtFourBroker::STATUS_SELECT[$mtFourBroker->status] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $mtFourBroker->comment ?? '' }}
                                        </td>
                                        <td>
                                            @can('mt_four_broker_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.mt-four-brokers.show', $mtFourBroker->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('mt_four_broker_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.mt-four-brokers.edit', $mtFourBroker->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('mt_four_broker_delete')
                                                <form action="{{ route('frontend.mt-four-brokers.destroy', $mtFourBroker->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('mt_four_broker_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.mt-four-brokers.massDestroy') }}",
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
    pageLength: 10,
  });
  let table = $('.datatable-MtFourBroker:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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