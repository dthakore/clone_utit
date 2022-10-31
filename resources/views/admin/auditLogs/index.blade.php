@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.auditLog.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="row" style="flex-direction: row-reverse;">
                <button type="button" class="btn btn-info filter" data-toggle="modal" data-target="#filterModal"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
            </div>
            <div id="filterModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Filter</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="search-form">
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.auditLog.fields.user_id') }}</label>
                                    <input class="form-control" type="text" id="user_id" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.auditLog.fields.user_name') }}</label>
                                    <input class="form-control" type="text" id="user_name" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.auditLog.fields.user_email') }}</label>
                                    <input class="form-control" type="text" id="user_email" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.auditLog.fields.model_name') }}</label>
                                    <input class="form-control" type="text" id="model_name" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>Created Date</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" id="start_date" type="text" placeholder="From">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" id="end_date" type="text" placeholder="To">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" onclick="clearFilters();">Clear</button>
                            <button type="button" class="btn btn-success" onclick="auditLogFilter();">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-AuditLog">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.auditLog.fields.user_id') }}
                    </th>
                    <th>
                        {{ trans('cruds.auditLog.fields.user_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.auditLog.fields.user_email') }}
                    </th>
{{--                    <th>--}}
{{--                        {{ trans('cruds.auditLog.fields.subject_id') }}--}}
{{--                    </th>--}}
{{--                    <th>--}}
{{--                        {{ trans('cruds.auditLog.fields.subject_type') }}--}}
{{--                    </th>--}}
                    <th>
                        {{ trans('cruds.auditLog.fields.model_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.auditLog.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.auditLog.fields.action') }}
                    </th>
{{--                    <th>--}}
{{--                        {{ trans('cruds.auditLog.fields.host') }}--}}
{{--                    </th>--}}
                    <th>
                        {{ trans('cruds.auditLog.fields.created_at') }}
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
                ajax: {
                    url: "{{ route('admin.audit-logs.index') }}",
                    data: function(d) {
                        d.user_id = $('#user_id').val();
                        d.user_name = $('#user_name').val();
                        d.user_email = $('#user_email').val();
                        d.model_name = $('#model_name').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    {
                        data: 'user_id',
                        name: 'user_id',
                        render: function (data, type, row, meta) {
                            data = '<a target="_blank" href="<?php echo  url('/admin/users/')?>/'+data+'">' + data + '</a>';
                            return data;
                        }
                    },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'user_email', name: 'user_email' },
                    { data: 'model_name', name: 'model_name' },
                    { data: 'description', name: 'description' },
                    // { data: 'subject_id', name: 'subject_id' },
                    // { data: 'subject_type', name: 'subject_type' },
                    { data: 'action', name: 'action' },
                    // { data: 'host', name: 'host' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                orderCellsTop: true,
                order: [[ 7, 'desc' ]],
                pageLength: 10,
            };
            let table = $('.datatable-AuditLog').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            $('#search-form').on('submit', function(e) {
                table.ajax.reload();
                e.preventDefault();
            });

            window.auditLogFilter = function(){
                $('#filterModal .close').click();
                $('#search-form').submit();
            };
            window.clearFilters = function(){
                $('#search-form').trigger('reset');
                $('#filterModal .close').click();
                $('#search-form').submit();
            };

            var route_name = "{{ url('/api/v1/autocomplete-name') }}";
            $('#user_name').typeahead({
                source: function (query, process) {
                    return $.get(route_name, {
                        name: query
                    }, function (data) {
                        return process(data);
                    });
                }
            });

            $('#start_date').datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                maxDate: new Date(),
                inline: true,
                onSelect: function(selected) {
                    $("#end_date").datepicker("option","minDate", selected)
                }
            });

            $('#end_date').datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                minDate: $("#start_date").val(),
                maxDate: new Date(),
                inline: true,
                onSelect: function(selected) {
                    $("#start_date").datepicker("option","maxDate", selected)
                }
            });
        });

    </script>
@endsection
