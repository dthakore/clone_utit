@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.experts.create') }}">
            {{ trans('global.add') }} Expert
        </a>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.followExpert.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Expert">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>
                            {{ trans('cruds.followExpert.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.followExpert.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.followExpert.fields.account') }}
                        </th>
                        <th>
                            {{ trans('cruds.followExpert.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.followExpert.fields.agent') }}
                        </th>
                        <th>
                            {{ trans('cruds.followExpert.fields.agent_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.followExpert.fields.group') }}
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
                    ajax: {
                        url: "{{ route('admin.experts.index') }}",
                    },
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'account', name: 'account'},
                        {data: 'type', name: 'type'},
                        {data: 'agent', name: 'agent'},
                        {data: 'agent_name', name: 'agent_name'},
                        {data: 'group', name: 'group'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'}
                    ],
                    orderCellsTop: true,
                    order: [[1, 'asc']],
                    pageLength: 25,
                };
            let table = $('.datatable-Expert').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
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
            });

        });

    </script>
@endsection
