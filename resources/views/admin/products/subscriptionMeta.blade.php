<div class="card">
    <!-- <div class="card-header">
        Feature {{ trans('global.list') }}
    </div> -->
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            Title
                        </th>
                        <th>
                            Value
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptionMeta as $key => $meta)
                        <tr data-entry-id="{{ $meta->id }}">
                            <td>
                                {{ $meta->title ?? '' }}
                            </td>
                            <td>
                                {{ $meta->value ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- @section('scripts')
<script>
$(function () {
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 3, 'asc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-subscriptionMeta:not(.ajaxTable)').DataTable()
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
});
</script>
@endsection -->