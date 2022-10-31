@extends('layouts.admin')
@section('content')
    @can('order_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                {{-- <a class="btn btn-success" href="{{ route('admin.orders.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
                </a> --}}
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Order', 'route' => 'admin.orders.parseCsvImport'])
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
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
                                    <label>{{ trans('cruds.order.fields.user') }}</label>
                                    <input class="form-control" type="text" id="user_name" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.user.fields.sponsor') }}</label>
                                    <input class="form-control" type="text" id="sponsor" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.order.fields.invoice_number') }}</label>
                                    <input class="form-control" type="text" id="invoice_number" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>Payment Method</label>
                                    <input class="form-control" type="text" id="payment_method" placeholder="Search" autocomplete="off">
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.order.fields.product') }}</label>
                                    <select class="form-control" id="product">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach($products as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label>{{ trans('cruds.order.fields.order_status') }}</label>
                                    <select class="form-control" id="status">
                                        <option value>{{ trans('global.all') }}</option>
                                        @foreach(App\Models\Order::ORDER_STATUS_SELECT as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label>Order Date</label>
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
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Order">
                <thead>
                <tr>
                    <th width="10"></th>
                    <th>
                        {{ trans('cruds.order.fields.order') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.order_status') }}
                    </th>
                    <th>
{{--                        <input type="hidden" name="payment_method" id="payment_method"/>--}}
                        Payment Method
                    </th>
{{--                    <th>--}}
{{--                        {{ trans('cruds.order.fields.order_origin') }}--}}
{{--                    </th>--}}
                    <th>
                        {{ trans('cruds.order.fields.net_total') }}
                    </th>
                    <th>
{{--                    <input type="hidden" name="invoice_number" id="invoice_number"/>--}}
                        {{ trans('cruds.order.fields.invoice_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.order.fields.created_at') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
{{--                <tr>--}}
{{--                    <td>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" style="width: 120px;" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        --}}{{-- <select class="search" style="width: 120px;">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach($users as $key => $item)--}}
{{--                                <option value="{{ $item->name }}">{{ $item->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select> --}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <select class="search" strict="true">--}}
{{--                            <option value>{{ trans('global.all') }}</option>--}}
{{--                            @foreach(App\Models\Order::ORDER_STATUS_SELECT as $key => $item)--}}
{{--                                <option value="{{ $key }}">{{ $item }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">--}}
{{--                    </td>--}}
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
            // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            //         @can('order_delete')
            // let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            // let deleteButton = {
            //     text: deleteButtonTrans,
            //     url: "{{ route('admin.orders.massDestroy') }}",
            //     className: 'btn-danger',
            //     action: function (e, dt, node, config) {
            //         var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
            //             return entry.id
            //         });

            //         if (ids.length === 0) {
            //             alert('{{ trans('global.datatables.zero_selected') }}')

            //             return
            //         }

            //         if (confirm('{{ trans('global.areYouSure') }}')) {
            //             $.ajax({
            //                 headers: {'x-csrf-token': _token},
            //                 method: 'POST',
            //                 url: config.url,
            //                 data: {ids: ids, _method: 'DELETE'}
            //             })
            //                 .done(function () {
            //                     location.reload()
            //                 })
            //         }
            //     }
            // }
            // dtButtons.push(deleteButton)
            //         @endcan

            let dtOverrideGlobals = {
                    // buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    {{--ajax: {--}}
                    {{--    url: "{{ route('admin.orders.index') }}",--}}
                    {{--    data: function(d) {--}}
                    {{--        d.invoice_number = $('#invoice_number').val();--}}
                    {{--        d.payment_method = $('#payment_method').val();--}}
                    {{--    }--}}
                    {{--},--}}
            ajax: {
                url: "{{ route('admin.orders.index') }}",
                    data: function(d) {
                    d.user_name = $('#user_name').val();
                    d.sponsor = $('#sponsor').val();
                    d.product = $('#product').val();
                    d.status = $('#status').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.invoice_number = $('#invoice_number').val();
                    d.payment_method = $('#payment_method').val();
                }
            },
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {   data: 'order',
                            name: 'order',
                            render: function (data, type, row, meta) {
                                data = '<a target="_blank" href="<?php echo  url('/admin/orders/')?>/'+row.id+'">' + data + '</a>';
                                return data;
                            }
                        },
                        {
                            data: 'user_name',
                            name: 'user.name',
                            render: function (data, type, row, meta) {
                                data = '<a target="_blank" href="<?php echo  url('/admin/users/')?>/'+row.user_id+'">' + data + '</a>';
                                return data;
                            }
                        },
                        {data: 'order_status', name: 'order_status'},
                        {data: 'payment_method', name: 'payment_method'},
                        // {data: 'order_origin', name: 'order_origin'},
                        {data: 'net_total', name: 'net_total'},
                        {
                            data: "invoice_number",
                            name: 'invoice_number',
                            render: function (data, type, row, meta) {
                                data = '<a target="_blank" href="<?php echo  url('/invoice/')?>/'+data+'">' + data + '</a>';
                                return data;
                            }
                        },
                        //{data: 'invoice_number', name: 'invoice_number'},
                        {data: 'created_at', name: 'created_at'},
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

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }
                if(index == 4){
                    $('#payment_method').val(value)
                    table.ajax.reload();
                }
                if(index == 7){
                    $('#invoice_number').val(value)
                    table.ajax.reload();
                }else{
                    table
                        .column(index)
                        .search(value, strict)
                        .draw()
                }
            });
            table.on('column-visibility.dt', function (e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function (colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            });

        $('#search-form').on('submit', function(e) {
            table.ajax.reload();
            e.preventDefault();
        });
        window.walletFilter = function(){
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
        $('#sponsor').typeahead({
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
