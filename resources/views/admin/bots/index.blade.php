@extends('layouts.admin')
@section('content')
@can('bot_create')
<!--    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bots.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bot.title_singular') }}
            </a>
        </div>
    </div>-->
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bot.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Bot">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>
                        {{ trans('cruds.bot.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.bot.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.bot.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.bot.fields.symbol') }}
                    </th>
                    <th>
                        {{ trans('cruds.bot.fields.balance') }}
                    </th>
                    <th>
                        Init
                    </th>
                    <th>
                        TP(AVG)
                    </th>
                    <th>
                        TP-Retrace(AVG)
                    </th>
                    <th>
                        {{ trans('cruds.bot.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td></td>
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Bot::IS_ACTIVE_SELECT as $key => $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
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
    //end export all button

@can('bot_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bots.massDestroy') }}",
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
    ajax: "{{ route('admin.bots.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id',
          name: 'id',
            render: function (data, type, full, meta) {
                if(data == 0){
                    return data;
                }else{
                    return '<a href="/admin/bots/'+full.id+'" target="_blank"> '+data+'</a>';
                }
            } 
        },
        { data: 'bot_title', name: 'title' },
        { data: 'user_name',
          name: 'user.name',
            render: function (data, type, full, meta) {
                if(data == 0){
                    return data;
                }else{
                    return '<a href="/admin/users/'+full.user_id+'" target="_blank"> '+data+'</a>';
                }
            } 
         },
        { data: 'symbol_name', name: 'symbol.name' },
        { data: 'balance', name: 'balance' },
        { data: 'init_amount', name: 'init_amount' },
        { data: 'take_profit_average_percentage', name: 'take_profit_average_percentage' },
        { data: 'take_profit_average_retracement', name: 'take_profit_average_retracement' },
        { data: 'status', name: 'status'},
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Bot').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

    let visibleColumnsIndexes = null;
    window.jQuery('.datatable thead').on('input', '.search', function () {
        let strict = window.jQuery(this).attr('strict') || false
        let value = strict && this.value ? "^" + this.value + "$" : this.value

        let index = window.jQuery(this).parent().index()
        if (visibleColumnsIndexes !== null) {
            index = visibleColumnsIndexes[index]
        }

        if(index == 4){
            $('#sponsor_id').val(value)
            table.ajax.reload();
        }else{
            //console.log(table);
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
    })

})

</script>
@endsection
