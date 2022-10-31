<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MtfourDailyBalance;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MtFourDailyBalanceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('mt_four_daily_balance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MtfourDailyBalance::select(sprintf('%s.*', (new MtfourDailyBalance())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->editColumn('account', function ($row) {
                return $row->account ? $row->account : '';
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('agent', function ($row) {
                return $row->agent ? $row->agent : '';
            });

            $table->editColumn('group', function ($row) {
                return $row->group ? $row->group : '';
            });

            $table->editColumn('balance', function ($row) {
                return $row->balance ? $row->balance : '';
            });

            $table->editColumn('equity', function ($row) {
                return $row->equity ? $row->equity : '';
            });

            $table->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at : '';
            });

            $table->rawColumns(['actions', 'placeholder']);
            // dd($table->make(true));
            return $table->make(true);
        }
        return view('admin.MtFourDailyBalance.index');
    }
}
