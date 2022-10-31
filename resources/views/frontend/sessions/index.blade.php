@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.session.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Session">
                            <thead>
                                <tr>
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
                            <tbody>
                                @foreach($sessions as $key => $session)
                                    <tr data-entry-id="{{ $session->id }}">
                                        <td>
                                            {{ $session->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->bot->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Session::STATUS_SELECT[$session->status] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->lowest ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->highest ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->last_buy ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->average_buy ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->total_buy ?? '' }}
                                        </td>
                                        <td>
                                            {{ $session->cover ?? '' }}
                                        </td>
                                        <td>



                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-Session:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection