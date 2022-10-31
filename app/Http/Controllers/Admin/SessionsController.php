<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SessionsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Session::with(['bot', 'user'])->select(sprintf('%s.*', (new Session())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'session_show';
                $editGate = 'session_edit';
                $deleteGate = 'session_delete';
                $crudRoutePart = 'sessions';

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

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('user.name', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->name) : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Session::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('lowest', function ($row) {
                return $row->lowest ? $row->lowest : '';
            });
            $table->editColumn('highest', function ($row) {
                return $row->highest ? $row->highest : '';
            });
            $table->editColumn('last_buy', function ($row) {
                return $row->last_buy ? $row->last_buy : '';
            });
            $table->editColumn('average_buy', function ($row) {
                return $row->average_buy ? $row->average_buy : '';
            });
            $table->editColumn('total_buy', function ($row) {
                return $row->total_buy ? $row->total_buy : '';
            });
            $table->editColumn('cover', function ($row) {
                return $row->cover ? $row->cover : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'bot', 'user']);

            return $table->make(true);
        }

        return view('admin.sessions.index');
    }
}
