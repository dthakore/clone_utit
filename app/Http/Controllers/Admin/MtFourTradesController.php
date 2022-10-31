<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMtFourTradeRequest;
use App\Models\MtFourTrade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MtFourTradesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('mt_four_trade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MtFourTrade::query()->select(sprintf('%s.*', (new MtFourTrade())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'mt_four_trade_show';
                $editGate = 'mt_four_trade_edit';
                $deleteGate = 'mt_four_trade_delete';
                $crudRoutePart = 'mt-four-trades';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('login', function ($row) {
                return $row->login ? $row->login : '';
            });
            $table->editColumn('agent_number', function ($row) {
                return $row->agent_number ? $row->agent_number : '';
            });
            $table->editColumn('symbol', function ($row) {
                return $row->symbol ? $row->symbol : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : '';
            });
            $table->editColumn('lots', function ($row) {
                return $row->lots ? $row->lots : '';
            });

            $table->editColumn('profit', function ($row) {
                return $row->profit ? $row->profit : '';
            });
            $table->editColumn('agent_commission', function ($row) {
                return $row->agent_commission ? $row->agent_commission : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.mtFourTrades.index');
    }

    public function show(MtFourTrade $mtFourTrade)
    {
        abort_if(Gate::denies('mt_four_trade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mtFourTrades.show', compact('mtFourTrade'));
    }

    public function destroy(MtFourTrade $mtFourTrade)
    {
        abort_if(Gate::denies('mt_four_trade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mtFourTrade->delete();

        return back();
    }

    public function massDestroy(MassDestroyMtFourTradeRequest $request)
    {
        MtFourTrade::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
