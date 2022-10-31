<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserExchangeRequest;
use App\Http\Requests\StoreUserExchangeRequest;
use App\Http\Requests\UpdateUserExchangeRequest;
use App\Models\Exchange;
use App\Models\User;
use App\Models\UserExchange;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserExchangesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_exchange_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userExchanges = UserExchange::with(['user', 'exchange'])->where('user_id','=',Auth::id())->get();

        return view('frontend.userExchanges.index', compact('userExchanges'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_exchange_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exchanges = Exchange::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.userExchanges.create', compact('exchanges', 'users'));
    }

    public function store(StoreUserExchangeRequest $request)
    {
        $userExchange = UserExchange::create($request->all());

        return redirect()->route('frontend.user-exchanges.index');
    }

    public function edit(UserExchange $userExchange)
    {
        abort_if(Gate::denies('user_exchange_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exchanges = Exchange::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userExchange->load('user', 'exchange');

        return view('frontend.userExchanges.edit', compact('exchanges', 'userExchange', 'users'));
    }

    public function update(UpdateUserExchangeRequest $request, UserExchange $userExchange)
    {
        $data = $request->all();
        $exchange = $userExchange->load('user', 'exchange');

        if($data['key'] == ''){
            $data['key'] = $exchange->key;
        }
        if($data['secret'] == ''){
            $data['secret'] = $exchange->secret;
        }
        $userExchange->update($data);

        return redirect()->route('frontend.user-exchanges.index');
    }

    public function show(UserExchange $userExchange)
    {
        abort_if(Gate::denies('user_exchange_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userExchange->load('user', 'exchange');

        return view('frontend.userExchanges.show', compact('userExchange'));
    }

    public function destroy(UserExchange $userExchange)
    {
        abort_if(Gate::denies('user_exchange_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userExchange->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserExchangeRequest $request)
    {
        UserExchange::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
