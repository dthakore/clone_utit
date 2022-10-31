@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('cover_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.covers.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.cover.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.cover.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Cover">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cover.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.cover.fields.bot') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.cover.fields.index') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.cover.fields.cover_percentage') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.cover.fields.buy_x_times') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.cover.fields.cover_pullback') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($covers as $key => $cover)
                                    <tr data-entry-id="{{ $cover->id }}">
                                        <td>
                                            {{ $cover->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cover->bot->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cover->index ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cover->cover_percentage ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cover->buy_x_times ?? '' }}
                                        </td>
                                        <td>
                                            {{ $cover->cover_pullback ?? '' }}
                                        </td>
                                        <td>

                                            @can('cover_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.covers.edit', $cover->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('cover_delete')
                                                <form action="{{ route('frontend.covers.destroy', $cover->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('cover_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.covers.massDestroy') }}",
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
  let table = $('.datatable-Cover:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection