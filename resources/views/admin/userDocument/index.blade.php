@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.user-documents.create') }}">
            {{ trans('global.add') }} User Document
        </a>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.userDocument.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-UserDoc">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>
                            {{ trans('cruds.userDocument.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userDocument.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.userDocument.fields.path') }}
                        </th>
                        <th>
                            {{ trans('cruds.userDocument.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.userDocument.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.userDocument.fields.comment') }}
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
                        url: "{{ route('admin.user-documents.index') }}",
                    },
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        { 
                            data: 'path',
                            name: 'path',
                                render: function (data, type, full, meta) {
                                    if(data == 0){
                                        return data;
                                    }else{
                                        return '<a href="'+full.path+'" target="_blank"> View</a>';
                                    }
                                }
                        },
                        {data: 'type', name: 'type'},
                        {data: 'status', name: 'status'},
                        {data: 'comment', name: 'comment'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'}
                    ],
                    orderCellsTop: true,
                    order: [[1, 'asc']],
                    pageLength: 25,
                };
            let table = $('.datatable-UserDoc').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        
        });

    </script>
@endsection
