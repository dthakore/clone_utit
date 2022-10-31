<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTradeRequest;
use App\Http\Requests\UpdateTradeRequest;
use App\Http\Resources\Admin\TradeResource;
use App\Models\Session;
use App\Models\Trade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TradesApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('trade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $sessions = Session::with('trades.cover')
                ->where('bot_id','=', $request->bot_id)
                ->orderBy('id','DESC')
                ->limit(5)
                ->offset($request->total_records)
                ->get();
            $data = [];
            foreach ($sessions as $session) {
                if(count($session->trades) > 0) {
                    array_push($data, $session);
                }
            }
            return response()->json([
                "sessions" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "code" => $e->getCode(),
                "error" => $e->getMessage()
            ]);
        }
    }

    public function sessionAverage(Request $request) {
        return 100;
    }

    public function store(StoreTradeRequest $request)
    {
        $trade = Trade::create($request->all());

        return (new TradeResource($trade))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Trade $trade)
    {
        abort_if(Gate::denies('trade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TradeResource($trade->load(['bot', 'session', 'symbol', 'user', 'cover']));
    }

    public function update(UpdateTradeRequest $request, Trade $trade)
    {
        $trade->update($request->all());

        return (new TradeResource($trade))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Trade $trade)
    {
        abort_if(Gate::denies('trade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trade->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


}
