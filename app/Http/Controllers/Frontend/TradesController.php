<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTradeRequest;
use App\Http\Requests\StoreTradeRequest;
use App\Http\Requests\UpdateTradeRequest;
use App\Models\Bot;
use App\Models\Cover;
use App\Models\Session;
use App\Models\Symbol;
use App\Models\Trade;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TradesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('trade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trades = Trade::with(['bot', 'session', 'symbol', 'user', 'cover'])->where('user_id','',Auth::id())->get();

        return view('frontend.trades.index', compact('trades'));
    }

    public function create()
    {
        abort_if(Gate::denies('trade_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bots = Bot::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessions = Session::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $covers = Cover::pluck('index', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.trades.create', compact('bots', 'covers', 'sessions', 'symbols', 'users'));
    }

    public function store(StoreTradeRequest $request)
    {
        $trade = Trade::create($request->all());

        return redirect()->route('frontend.trades.index');
    }

    public function edit(Trade $trade)
    {
        abort_if(Gate::denies('trade_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bots = Bot::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessions = Session::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $covers = Cover::pluck('index', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trade->load('bot', 'session', 'symbol', 'user', 'cover');

        return view('frontend.trades.edit', compact('bots', 'covers', 'sessions', 'symbols', 'trade', 'users'));
    }

    public function update(UpdateTradeRequest $request, Trade $trade)
    {
        $trade->update($request->all());

        return redirect()->route('frontend.trades.index');
    }

    public function show(Trade $trade)
    {
        abort_if(Gate::denies('trade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trade->load('bot', 'session', 'symbol', 'user', 'cover');

        return view('frontend.trades.show', compact('trade'));
    }

    public function destroy(Trade $trade)
    {
        abort_if(Gate::denies('trade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trade->delete();

        return back();
    }

    public function massDestroy(MassDestroyTradeRequest $request)
    {
        Trade::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
