<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExchangeLogRequest;
use App\Models\ExchangeLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExchangeLogsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('exchange_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ExchangeLog::query()->select(sprintf('%s.*', (new ExchangeLog())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'exchange_log_show';
                $editGate = 'exchange_log_edit';
                $deleteGate = 'exchange_log_delete';
                $crudRoutePart = 'exchange-logs';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });
            $table->editColumn('error', function ($row) {
                return $row->error ? $row->error : '';
            });
            $table->editColumn('log', function ($row) {
                return $row->log ? $row->log : '';
            });
            $table->editColumn('order_id', function ($row) {
                return $row->order_id ? $row->order_id : '';
            });
            $table->editColumn('exchange', function ($row) {
                return $row->exchange ? $row->exchange : '';
            });
            $table->editColumn('request', function ($row) {
                return $row->request ? $row->request : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.exchangeLogs.index');
    }

    public function show(ExchangeLog $exchangeLog)
    {
        abort_if(Gate::denies('exchange_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.exchangeLogs.show', compact('exchangeLog'));
    }

    public function destroy(ExchangeLog $exchangeLog)
    {
        abort_if(Gate::denies('exchange_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exchangeLog->delete();

        return back();
    }

    public function massDestroy(MassDestroyExchangeLogRequest $request)
    {
        ExchangeLog::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
