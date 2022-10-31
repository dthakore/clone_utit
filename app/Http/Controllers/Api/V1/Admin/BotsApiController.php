<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BotFormRequest;
use App\Http\Requests\StoreBotRequest;
use App\Http\Requests\UpdateBotRequest;
use App\Http\Resources\Admin\BotResource;
use App\Models\Bot;
use App\Models\Cover;
use App\Models\Puxeo;
use App\Models\Trade;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BotsApiController extends Controller
{
    /**
     * @return BotResource
     */
    public function index()
    {
        abort_if(Gate::denies('bot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BotResource(Bot::with(['user', 'user_exchange', 'symbol', 'active_sessions'])->where('user_id','=',Auth::id())->get());
    }

    /**
     * Basic bot stats
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function botStats(Request $request) {
        try {
            $trades = Trade::selectRaw('side, sum(executed_amount) as amount')
                ->where('bot_id','=',$request->bot_id)
                ->whereNotNull('closed_at')
                ->groupBy('side')
                ->pluck('amount','side');
            $pending = Trade::where('bot_id','=', $request->bot_id)
                ->whereNull('closed_at')->sum('executed_amount');
            return response()->json([
                "trades" => $trades,
                "pending" => $pending
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                "code" => $exception->getCode(),
                "error" => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function botDelete(Request $request) {
        Bot::where('id','=',$request->bot_id)->delete();
        return response()->json([
            "result" => true,
            "id" => $request->bot_id
        ], 200);
    }

    /**
     * @param Bot $bot
     * @return BotResource
     */
    public function show(Bot $bot)
    {
        abort_if(Gate::denies('bot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BotResource($bot->load(['user', 'user_exchange', 'symbol', 'active_sessions']));
    }

    /**
     * @param StoreBotRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(StoreBotRequest $request)
    {
        $bot = Bot::create($request->all());

        return (new BotResource($bot))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param BotFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(BotFormRequest $request)
    {
        $subscription_plan = [
            "bots" => 10,
            "commission" => 20,
        ];
        try {
            $form = $request->input();
            if(Bot::where('user_id', '=', Auth::id())->count() >= $subscription_plan['bots']) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Your subscription plan is limited to 4 Bots',
                    'data'      => 203,
                ], 203);
            }
            $covers = $form['covers'];
            unset($form['covers']);
            $bot = Bot::create($form)->id;
            $inputs = [];
            foreach ($covers as $cover) {
                $cover['created_at'] = date("Y-m-d H:i:s");
                $cover['updated_at'] = date("Y-m-d H:i:s");
                $cover['bot_id'] = $bot;
                array_push($inputs, $cover);
            }
            Cover::insert($inputs);
            return response()->json([
                'success'   => true,
                'message'   => 'Bot created successfully',
                'data'      => $bot
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Failed to create bot',
                'data'      => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * @param BotFormRequest $request
     * @param Bot $bot
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BotFormRequest $request, Bot $bot)
    {
        try {
            $form = $request->input();
            $ids = [];
            foreach ($request->covers as $cover) {
                $cover['bot_id'] = $bot->id;
                if(!isset($cover['id'])) {
                    $cover['id'] = null;
                }
                $object = Cover::updateOrCreate(['id' => $cover['id'], 'index' => $cover['index']], $cover);
                array_push($ids, $object->id);
            }
            Cover::whereNotIn('id', $ids)
                ->where('bot_id','=',$bot->id)
                ->delete();
            $form['updated_at'] = date("Y-m-d H:i:s");
            unset($form['id']);
            unset($form['covers']);
            unset($form['user']);
            unset($form['user_exchange']);
            unset($form['symbol']);
            unset($form['active_sessions']);
            unset($form['active_sessions']);
            unset($form['active_session_id']);
            $form['take_profit_average_retracement'] = round($form['take_profit_average_retracement'], 2);
            Bot::where('id', '=', $bot->id)->update($form);
            return response()->json([
                'success'   => true,
                'message'   => 'Bot created successfully',
                'data'      => ''
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "code" => $e->getCode(),
                "error" => $e->getMessage()
            ], 500);
        }
        /*return (new BotResource($bot))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);*/
    }

    /**
     * @param Bot $bot
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Bot $bot)
    {
        abort_if(Gate::denies('bot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bot->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * User Balance
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userBalance(Request $request) {
        try {
            return response()->json([
                "user_balance" => Helper::userBalance($request->exchange, $request->symbol),
                "exchange_id" => $request->exchange,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "code" => $e->getCode(),
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
