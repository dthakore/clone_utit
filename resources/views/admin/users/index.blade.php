@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'User', 'route' => 'admin.users.parseCsvImport'])
        </div>
    </div>
@endcan
<!-- <style>
    table.dataTable th:nth-child(6){
    width: 100px;
    max-width: 100px;
    /* word-break: break-all;
    white-space: pre-line; */
    }

    table.dataTable td:nth-child(6){
    width: 100px;
    max-width: 100px;
    /* word-break: break-all;
    white-space: pre-line; */
    }
</style> -->
<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
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
                                <label>{{ trans('cruds.user.fields.id') }}</label>
                                <input class="form-control" type="text" id="search_user_id" placeholder="Search" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control" type="text" id="search_name" placeholder="Search" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control" type="text" id="email" placeholder="Search" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.sponsor') }}</label>
                                <input class="form-control" type="text" id="sponsor" placeholder="Search" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.city') }}</label>
                                <input class="form-control" type="text" id="city" placeholder="Search" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.phone') }}</label>
                                <input class="form-control" type="text" id="phone" placeholder="Search" autocomplete="off">
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.country') }}</label>
                                <select class="form-control select2" id="country">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($countries as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.rank') }}</label>
                                <select class="form-control" id="rank">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($ranks as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.roles') }}</label>
                                <select class="form-control" id="role">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($roles as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.product') }}</label>
                                <select class="form-control" id="product">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($products as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>{{ trans('cruds.user.fields.verified') }}</label>
                                <select class="form-control" id="verified">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach(App\Models\User::IS_ACTIVE_SELECT as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
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
                        <button type="button" class="btn btn-success" onclick="walletFilter();">Apply</button>
                    </div>
                </div>

            </div>
        </div>
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.user.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.sponsor') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.user.fields.city') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.user.fields.country') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.user.fields.rank') }}
                    </th> --}}
                    <th>
                        &nbsp;
                    </th>
                </tr>
{{--                <tr>--}}
{{--                    <td>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input type="hidden" name="sponsor_id" id="sponsor_id"/>--}}
{{--                        <select class="search" style="width: 176px;">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($users as $key => $item)--}}
{{--                                <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    --}}{{-- <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td> --}}
{{--                    <td>--}}
{{--                        <select class="search" style="width: 176px;">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($countries as $key => $item)--}}
{{--                                <option value="{{ $item->name }}">{{ $item->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    --}}{{-- <td>--}}
{{--                        <select class="search">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($ranks as $key => $item)--}}
{{--                                <option value="{{ $item->name }}">{{ $item->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td> --}}
{{--                    <td>--}}
{{--                    </td>--}}
{{--                </tr>--}}
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
$(function () {
    window.walletFilter = function(){
        $('#filterModal .close').click();
        $('#search-form').submit();
    };
    window.clearFilters = function(){
        $('#search_user_id').val('').trigger('change');
        $('#search_name').val('').trigger('change');
        $('#email').val('').trigger('change');
        $('#sponsor').val('').trigger('change');
        $('#city').val('').trigger('change');
        $('#phone').val('').trigger('change');
        $('#country').val('').trigger('change');
        $('#rank').val('').trigger('change');
        $('#role').val('').trigger('change');
        $('#product').val('').trigger('change');
        $('#verified').val('').trigger('change');
        $('#start_date').val('').trigger('change');
        $('#end_date').val('').trigger('change');
        $('#is_special').val('').trigger('change');
        $('#filterModal .close').click();
        $('#search-form').submit();
    };

  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    // export all button
    var oldExportAction = function (self, e, dt, button, config) {
        if (button[0].className.indexOf('buttons-excel') >= 0) {
            if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
            } else {
                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            }
        } else if (button[0].className.indexOf('buttons-print') >= 0) {
            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
        }
    };

    var newExportAction = function (e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function (e, settings) {
                // Call the original action function
                oldExportAction(self, e, dt, button, config);
                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    };

    let exportAll = {
        text: 'Export All',
        extend: 'excel',
        className: 'btn-default',
        action: newExportAction
    }
    dtButtons.push(exportAll)

    @can('user_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.users.massDestroy') }}",
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
        ajax: {
            url: "{{ route('admin.users.index') }}",
            data: function(d) {
                d.sponsor_id = $('#sponsor_id').val();
                d.user_id = $('#search_user_id').val();
                d.name = $('#search_name').val();
                d.email = $('#email').val();
                d.sponsor = $('#sponsor').val();
                d.city = $('#city').val();
                d.phone = $('#phone').val();
                d.country = $('#country').val();
                d.rank = $('#rank').val();
                d.role = $('#role').val();
                d.product = $('#product').val();
                d.verified = $('#verified').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
        { data: 'placeholder', name: 'placeholder' },
    { data: 'id',
      name: 'id',
        render: function (data, type, full, meta) {
            return '<a href="/admin/users/'+full.id+'" target="_blank"> '+data+'</a>';
        }
    },
    { data: 'name',
      name: 'name',
        render: function (data, type, full, meta) {
            return '<a href="/admin/users/'+full.id+'" target="_blank"> '+data+'</a>';

        }
    },
    { data: 'email', name: 'email' },
    { data: 'sponsor_name', name: 'sponsor_name' ,bSortable: false},
    // { data: 'city', name: 'city' },
    { data: 'country_name', name: 'country.name' },
    // { data: 'rank_name', name: 'rank.name' },
    { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 25,
    };
    let table = $('.datatable-User').DataTable(dtOverrideGlobals);
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
        console.log(table);
        if(index == 3){
            $('#sponsor_id').val(value)
            table.ajax.reload();
        }else{
            console.log(table);
            table
                .column(index)
                .search(value, strict)
                .draw()
        }
    });
    table.on('column-visibility.dt', function(e, settings, column, state) {
        visibleColumnsIndexes = []
        table.columns(":visible").every(function(colIdx) {
            visibleColumnsIndexes.push(colIdx);
        });
    });

    $('#search-form').on('submit', function(e) {
        table.ajax.reload();
        e.preventDefault();
    });

    var route_name = "{{ url('/api/v1/autocomplete-name') }}";
    // var route_email = "{{ url('/api/v1/autocomplete-email') }}";
    // var route_id = "{{ url('/api/v1/autocomplete-id') }}";
    // $('#search_user_id').typeahead({
    //     source: function (query, process) {
    //         return $.get(route_id, {
    //             id: query
    //         }, function (data) {
    //             return process(data);
    //         });
    //     }
    // });
    $('#search_name').typeahead({
        source: function (query, process) {
            return $.get(route_name, {
                name: query
            }, function (data) {
                return process(data);
            });
        }
    });
    $('#sponsor').typeahead({
        source: function (query, process) {
            return $.get(route_name, {
                name: query
            }, function (data) {
                return process(data);
            });
        }
    });
    // $('#email').typeahead({
    //     source: function (query, process) {
    //         return $.get(route_email, {
    //             email: query
    //         }, function (data) {
    //             return process(data);
    //         });
    //     }
    // });

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
