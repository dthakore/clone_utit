<?php

namespace App\Http\Controllers\Admin;

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
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TradesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('trade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Trade::with(['bot', 'session', 'symbol', 'user', 'cover'])->select(sprintf('%s.*', (new Trade())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'trade_show';
                $editGate = 'trade_edit';
                $deleteGate = 'trade_delete';
                $crudRoutePart = 'trades';

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
                return $row->bot ? $row->bot->title : '';
            });

            $table->addColumn('session_status', function ($row) {
                return $row->session ? $row->session->status : '';
            });

            $table->addColumn('symbol_name', function ($row) {
                return $row->symbol ? $row->symbol->name : '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('user.name', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->name) : '';
            });
            $table->editColumn('requested_amount', function ($row) {
                return $row->requested_amount ? $row->requested_amount : '';
            });
            $table->editColumn('side', function ($row) {
                return $row->side ? Trade::SIDE_SELECT[$row->side] : '';
            });
            $table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : '';
            });
            $table->editColumn('failure_reason', function ($row) {
                return $row->failure_reason ? $row->failure_reason : '';
            });
            $table->editColumn('exchange_order_status', function ($row) {
                return $row->exchange_order_status ? $row->exchange_order_status : '';
            });
            $table->editColumn('original_orders', function ($row) {
                return $row->original_orders ? $row->original_orders : '';
            });
            $table->editColumn('exchange_order_ref', function ($row) {
                return $row->exchange_order_ref ? $row->exchange_order_ref : '';
            });
            $table->editColumn('exchange_trade_ref', function ($row) {
                return $row->exchange_trade_ref ? $row->exchange_trade_ref : '';
            });
            $table->editColumn('requested_price', function ($row) {
                return $row->requested_price ? $row->requested_price : '';
            });
            $table->editColumn('requested_quantity', function ($row) {
                return $row->requested_quantity ? $row->requested_quantity : '';
            });
            $table->editColumn('executed_price', function ($row) {
                return $row->executed_price ? $row->executed_price : '';
            });
            $table->editColumn('executed_amount', function ($row) {
                return $row->executed_amount ? $row->executed_amount : '';
            });
            $table->editColumn('executed_quantity', function ($row) {
                return $row->executed_quantity ? $row->executed_quantity : '';
            });
            $table->addColumn('cover_index', function ($row) {
                return $row->cover ? $row->cover->index : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'bot', 'session', 'symbol', 'user', 'cover']);

            return $table->make(true);
        }

        return view('admin.trades.index');
    }

    public function create()
    {
        abort_if(Gate::denies('trade_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bots = Bot::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessions = Session::pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $symbols = Symbol::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $covers = Cover::pluck('index', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.trades.create', compact('bots', 'covers', 'sessions', 'symbols', 'users'));
    }

    public function store(StoreTradeRequest $request)
    {
        $trade = Trade::create($request->all());

        return redirect()->route('admin.trades.index');
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

        return view('admin.trades.edit', compact('bots', 'covers', 'sessions', 'symbols', 'trade', 'users'));
    }

    public function update(UpdateTradeRequest $request, Trade $trade)
    {
        $trade->update($request->all());

        return redirect()->route('admin.trades.index');
    }

    public function show(Trade $trade)
    {
        abort_if(Gate::denies('trade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trade->load('bot', 'session', 'symbol', 'user', 'cover');

        return view('admin.trades.show', compact('trade'));
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
