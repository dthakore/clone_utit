@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.session.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Session">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.session.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.bot') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.lowest') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.highest') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.last_buy') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.average_buy') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.total_buy') }}
                    </th>
                    <th>
                        {{ trans('cruds.session.fields.cover') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.sessions.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'bot_title', name: 'bot.title' },
{ data: 'user_name', name: 'user.name' },
{ data: 'user.name', name: 'user.name' },
{ data: 'status', name: 'status' },
{ data: 'lowest', name: 'lowest' },
{ data: 'highest', name: 'highest' },
{ data: 'last_buy', name: 'last_buy' },
{ data: 'average_buy', name: 'average_buy' },
{ data: 'total_buy', name: 'total_buy' },
{ data: 'cover', name: 'cover' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Session').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection