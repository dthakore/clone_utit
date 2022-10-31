@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('exchange_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.exchanges.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.exchange.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.exchange.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Exchange">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.exchange.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.exchange.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.exchange.fields.status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.exchange.fields.is_visible') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.exchange.fields.tags') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.exchange.fields.logo') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exchanges as $key => $exchange)
                                    <tr data-entry-id="{{ $exchange->id }}">
                                        <td>
                                            {{ $exchange->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $exchange->name ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $exchange->status ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $exchange->status ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $exchange->is_visible ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $exchange->is_visible ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $exchange->tags ?? '' }}
                                        </td>
                                        <td>
                                            @if($exchange->logo)
                                                <a href="{{ $exchange->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $exchange->logo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @can('exchange_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.exchanges.show', $exchange->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('exchange_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.exchanges.edit', $exchange->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('exchange_delete')
                                                <form action="{{ route('frontend.exchanges.destroy', $exchange->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('exchange_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.exchanges.massDestroy') }}",
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
  let table = $('.datatable-Exchange:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection