@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.mam-account.create') }}">
            {{ trans('global.add') }} Account
        </a>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.mamAccount.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Order">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.account_id') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.mamAccount.fields.login') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.mamAccount.fields.agent') }}
                        </th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.group') }}
                        </th>
                        <th>
                        {{ trans('cruds.mamAccount.fields.broker') }}
                        </th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.asset_manager') }}
                        </th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.agent_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.minimum_deposit') }}
                        </th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.parent_agent') }}
                        </th>
                        <th>
                            {{ trans('cruds.mamAccount.fields.brand_name') }}
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
                        url: "{{ route('admin.mam-account.index') }}",
                    },
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'account_id', name: 'account_id'},
                        // {data: 'login', name: 'login'},
                        {data: 'agent', name: 'agent'},
                        {data: 'group', name: 'group'},
                        {data: 'broker', name: 'broker'},
                        {data: 'asset_manager', name: 'asset_manager'},
                        {data: 'agent_name', name: 'agent_name'},
                        {data: 'minimum_deposit', name: 'minimum_deposit'},
                        {data: 'parent_agent', name: 'parent_agent'},
                        {data: 'brand_name', name: 'brand_name'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'}
                    ],
                    orderCellsTop: true,
                    order: [[1, 'asc']],
                    pageLength: 25,
                };
            let table = $('.datatable-Order').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        
        });

    </script>
@endsection
