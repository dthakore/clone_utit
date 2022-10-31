@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.dailyBalance.title_singular') }} 
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Dailybalance">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.account') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.agent') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.group') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.balance') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.equity') }}
                    </th>
                    <th>
                        {{ trans('cruds.dailyBalance.fields.created_at') }}
                    </th>
                    {{-- <th>
                        &nbsp;
                    </th> --}}
                </tr>
                {{-- <tr>
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
                    </td>
                </tr> --}}
            </thead>
        </table>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
$(function () {

    let dtOverrideGlobals = {
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.daily-balance.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'account', name: 'account' },
        { data: 'email', name: 'email' },
        { data: 'agent', name: 'agent' },
        { data: 'group', name: 'group' },
        { data: 'balance', name: 'balance' },
        { data: 'equity', name: 'equity' },
        { data: 'created_at', name: 'created_at' }
        // { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  };

  let table = $('.datatable-Dailybalance').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
});

</script>
@endsection