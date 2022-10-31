@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.userExpertRequest.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User-Request-Expert">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.id') }}
                        </th>
                        <th>
                            User
                        </th>
                        <th>
                            Expert
                        </th>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.created_at') }}
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
            
            let dtOverrideGlobals = {
                    // buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: {
                        url: "{{ route('admin.user-expert-request.index') }}",
                    },
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'expert_id', name: 'expert_id'},
                        {data: 'status', name: 'status'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'}
                    ],
                    orderCellsTop: true,
                    order: [[1, 'asc']],
                    pageLength: 25,
                };
            let table = $('.datatable-User-Request-Expert').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        
        });

    </script>
@endsection
