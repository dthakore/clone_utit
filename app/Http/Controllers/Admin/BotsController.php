<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBotRequest;
use App\Http\Requests\StoreBotRequest;
use App\Http\Requests\UpdateBotRequest;
use App\Models\Bot;
use App\Models\Session;
use App\Models\Symbol;
use App\Models\User;
use App\Models\UserExchange;
use Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BotsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $bots = Bot::with(['user', 'user_exchange', 'symbol', 'active_sessions'])->get();
            $table = Datatables::of($bots);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'bot_show';
                $editGate = 'bot_edit';
                $deleteGate = 'bot_delete';
                $crudRoutePart = 'bots';

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

            $table->addColumn('bot_title', function ($row) {
                return $row->title ? $row->title : '';
            });

            $table->addColumn('user_id', function ($row) {
                return $row->id ? $row->user->id : '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->name) : '';
            });

            $table->addColumn('symbol_name', function ($row) {
                return $row->symbol ? $row->symbol->name : '';
            });

            $table->addColumn('balance', function ($row) {
                return $row->balance ? $row->balance : '';
            });

            $table->editColumn('init_amount', function ($row) {
                return $row->init_amount ? $row->init_amount : '';
            });

            $table->editColumn('take_profit_average_percentage', function ($row) {
                return $row->take_profit_average_percentage ? $row->take_profit_average_percentage : '';
            });

            $table->editColumn('take_profit_average_retracement', function ($row) {
                return $row->take_profit_average_retracement ? $row->take_profit_average_retracement : '';
            });

            $table->editColumn('status', function ($row) {
                return  Bot::IS_ACTIVE_SELECT[$row->status] ;
            });

            $table->rawColumns(['actions', 'placeholder','user', 'user_exchange', 'symbol', 'active_sessions']);
            
            return $table->make(true);
        }
        return view('admin.bots.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bot_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_exchanges = UserExchange::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $active_sessions = Session::pluck('status', 'id');

        return view('admin.bots.create', compact('users', 'user_exchanges', 'symbols', 'active_sessions'));
    }

    public function store(StoreBotRequest $request)
    {
        $bot = Bot::create($request->all());
        $bot->active_sessions()->sync($request->input('active_sessions', []));

        return redirect()->route('admin.bots.index');
    }

    public function edit(Bot $bot)
    {
        abort_if(Gate::denies('bot_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_exchanges = UserExchange::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $active_sessions = Session::pluck('status', 'id');

        $bot->load('user', 'user_exchange', 'symbol', 'active_sessions','covers');

        return view('admin.bots.edit', compact('active_sessions', 'bot', 'symbols', 'user_exchanges', 'users'));
    }

    public function update(UpdateBotRequest $request, Bot $bot)
    {
        $bot->update($request->all());
        $bot->active_sessions()->sync($request->input('active_sessions', []));

        return redirect()->route('admin.bots.index');
    }

    public function show(Bot $bot)
    {
        abort_if(Gate::denies('bot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bot->load('user', 'user_exchange', 'symbol', 'active_sessions');

        return view('admin.bots.show', compact('bot'));
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
