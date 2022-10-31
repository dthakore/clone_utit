@can('allwallettransaction_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.allwallettransactions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.allwallettransaction.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.allwallettransaction.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userAllwallettransactions">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
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
                </thead>
                <tbody>
                    @foreach($allwallettransactions as $key => $allwallettransaction)
                        <tr data-entry-id="{{ $allwallettransaction->id }}">
                            <td>

                            </td>
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
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.allwallettransactions.show', $allwallettransaction->id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                @endcan

                                @can('allwallettransaction_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.allwallettransactions.edit', $allwallettransaction->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('allwallettransaction_delete')
                                    <form action="{{ route('admin.allwallettransactions.destroy', $allwallettransaction->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></button>
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('allwallettransaction_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.allwallettransactions.massDestroy') }}",
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
  let table = $('.datatable-userAllwallettransactions:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection