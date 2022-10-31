<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserExchangeRequest;
use App\Http\Requests\StoreUserExchangeRequest;
use App\Http\Requests\UpdateUserExchangeRequest;
use App\Models\Exchange;
use App\Models\User;
use App\Models\UserExchange;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserExchangesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_exchange_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userExchanges = UserExchange::with(['user', 'exchange'])->get();

        return view('admin.userExchanges.index', compact('userExchanges'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_exchange_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exchanges = Exchange::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userExchanges.create', compact('users', 'exchanges'));
    }

    public function store(StoreUserExchangeRequest $request)
    {
        $userExchange = UserExchange::create($request->all());

        return redirect()->route('admin.user-exchanges.index');
    }

    public function edit(UserExchange $userExchange)
    {
        abort_if(Gate::denies('user_exchange_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exchanges = Exchange::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userExchange->load('user', 'exchange');

        return view('admin.userExchanges.edit', compact('users', 'exchanges', 'userExchange'));
    }

    public function update(UpdateUserExchangeRequest $request, UserExchange $userExchange)
    {
        $userExchange->update($request->all());

        return redirect()->route('admin.user-exchanges.index');
    }

    public function show(UserExchange $userExchange)
    {
        abort_if(Gate::denies('user_exchange_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userExchange->load('user', 'exchange');

        return view('admin.userExchanges.show', compact('userExchange'));
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
