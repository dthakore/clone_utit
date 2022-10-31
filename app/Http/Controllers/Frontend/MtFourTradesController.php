<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMtFourTradeRequest;
use App\Models\MtFourTrade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MtFourTradesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mt_four_trade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mtFourTrades = MtFourTrade::all();

        return view('frontend.mtFourTrades.index', compact('mtFourTrades'));
    }

    public function show(MtFourTrade $mtFourTrade)
    {
        abort_if(Gate::denies('mt_four_trade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mtFourTrades.show', compact('mtFourTrade'));
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
