<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBotRequest;
use App\Http\Requests\StoreBotRequest;
use App\Http\Requests\UpdateBotRequest;
use App\Models\Bot;
use App\Models\Cover;
use App\Models\Session;
use App\Models\Symbol;
use App\Models\User;
use App\Models\UserExchange;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;
use Symfony\Component\HttpFoundation\Response;

class BotsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bots = Bot::with(['user', 'user_exchange', 'symbol', 'active_sessions'])->get();

        return view('frontend.bots.index', compact('bots'));
    }

    public function create()
    {
        abort_if(Gate::denies('bot_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        abort_if( Bot::where('user_id','=', Auth::id())->count() >= Helper::productMeta('trading-pairs'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /*$users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');*/

        $user_exchanges = UserExchange::where('user_id','=',Auth::id())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('pair', 'id')->prepend(trans('global.pleaseSelect'), '');

        $active_sessions = Session::pluck('status', 'id');

        return view('frontend.bots.create', compact('active_sessions', 'symbols', 'user_exchanges'));
    }

    public function store(StoreBotRequest $request)
    {
        $bot = Bot::create($request->all());
        $bot->active_sessions()->sync($request->input('active_sessions', []));

        return redirect()->route('frontend.bots.index');
    }

    public function edit(Bot $bot)
    {

        abort_if(Gate::denies('bot_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_exchanges = UserExchange::where('user_id','=',Auth::id())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $active_sessions = Session::pluck('status', 'id');

        //$covers = Cover::where('bot_id','=', $bot->id)->get();

        $bot->load('user', 'user_exchange', 'symbol', 'active_sessions','covers');

        return view('frontend.bots.edit', compact('active_sessions', 'bot', 'symbols', 'user_exchanges', 'users'));
    }

    public function update(UpdateBotRequest $request, Bot $bot)
    {
        $bot->update($request->all());
        $bot->active_sessions()->sync($request->input('active_sessions', []));

        return redirect()->route('frontend.bots.index');
    }

    public function show(Bot $bot)
    {
        abort_if(Gate::denies('bot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bot->load('user', 'user_exchange', 'symbol', 'active_sessions');

        return view('frontend.bots.show', compact('bot'));
    }

    public function destroy(Bot $bot)
    {
        abort_if(Gate::denies('bot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bot->delete();

        return back();
    }

    public function massDestroy(MassDestroyBotRequest $request)
    {
        Bot::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
