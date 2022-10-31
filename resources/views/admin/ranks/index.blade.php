@can('rank_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ranks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.rank.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rank.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Rank">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.rank.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.rank.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.rank.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.rank.fields.abbreviation') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
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
        </table>
        </br>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">Compute Ranks</div><hr>
                <input type="button" class="btn btn-primary" style="float: right;" name="computerank" id="rankCompute" value="Compute Ranks"/>
            </div>
            <div class="col-md-12">
                <div style="height: 150px;" id="computeResult"></div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('rank_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ranks.massDestroy') }}",
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
    ajax: "{{ route('admin.ranks.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id',
  name: 'id',
    render: function (data, type, full, meta) {
        if(data == 0){
            return data;
        }else{
            return '<a href="/admin/ranks/'+full.id+'" target="_blank"> '+data+'</a>';
        }
    }
},
{ data: 'name', name: 'name' },
{ data: 'description', name: 'description' },
{ data: 'abbreviation', name: 'abbreviation' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Rank').DataTable(dtOverrideGlobals);
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
});

//compute rank
$('#rankCompute').click(function () {
    $.ajax({
        headers: {'x-csrf-token': _token},
        url: "{{ url('admin/compute-rank') }}",
        type: "POST",
        success: function (response) {
            //console.log(response);
            var Result = JSON.parse(response);
            if (Result.users == 0){
                $('#computeResult').html("Users not eligible for rank update");
            }else{
                $('#computeResult').html('Ranks Successfully Updated, ' + Result.users + " Users's rank updated");
            }
        }
    });
});
</script>
@endsection