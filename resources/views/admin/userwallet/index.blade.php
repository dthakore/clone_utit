@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #006fe6;
        }
    </style>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.userwallet.title_singular') }} {{ trans('global.list') }}
        </div>
        <div class="card-body">
            <form method="POST" id="search-form">
                <div class="col-md-4">
                    <select class="form-control" id="user">
                        <option value="0">Select User</option>
                        @foreach($users as $key => $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <br>
                    <button type="button" class="btn btn-default" onclick="clearFilters();">Clear</button>&nbsp;
                    <button type="button" class="btn btn-success" onclick="walletFilter();">Apply</button>
                </div>
            <br>
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-userwallet">
                <thead>
                <tr>
                    <th>
                        User
                    </th>
                    <th>
                        Balance
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                </thead>
            </table>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript"
            src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $('#user').select2();
            var dTable = $('.datatable-userwallet').DataTable({
                "order": [[1, "desc"]],
                lengthMenu: [
                    [25, 50, 100, 150, -1],
                    ['25 rows', '50 rows', '100 rows', '150 rows', 'Show all']
                ],
                columnDefs: [
                    {orderable: true, targets: 0},
                ],
                dom: 'lrtip',
                processing: true,
                serverSide: true,
                retrieve: true,
                language: {
                    zeroRecords: "We do not have data that meets your filter criteria. Try another one."
                },
                ajax: {
                    url: '{{ route("admin.allwallettransactions.userwallet") }}',
                    data: function (d) {
                        d.user = $('#user').val();
                    }
                },
                columns: [
                    {data: "user_id", name: "user_id", title: "User", searchable: true},
                    {data: "balance", name: "balance", title: "Balance"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                //
                // drawCallback: function () {
                //     $(".m-quick-sidebar-overlay").remove(); // remove overlay black screen
                // }
            });
            $('#search-form').on('submit', function(e) {
                dTable.ajax.reload();
                e.preventDefault();
            });
            window.walletFilter = function(){
                $('#search-form').submit();
            };
            window.clearFilters = function(){
                $('#user').val(0).trigger('change');
                $('#search-form').submit();
            }
        });
    </script>
@endsection
