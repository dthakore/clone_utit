<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreUserPositionAccountRequest;
use App\Models\UserPositionAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserPositionAccountsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_position_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserPositionAccount::query()->select(sprintf('%s.*', (new UserPositionAccount())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_position_account_show';
                $editGate = 'user_position_account_edit';
                $deleteGate = 'user_position_account_delete';
                $crudRoutePart = 'user-position-accounts';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('user_account_num', function ($row) {
                return $row->user_account_num ? $row->user_account_num : '';
            });
            $table->editColumn('login', function ($row) {
                return $row->login ? $row->login : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type && isset(UserPositionAccount::TYPE_SELECT[$row->type]) ? UserPositionAccount::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('email_address', function ($row) {
                return $row->email_address ? $row->email_address : '';
            });
            $table->editColumn('balance', function ($row) {
                return $row->balance ? $row->balance : '';
            });
            $table->editColumn('equity', function ($row) {
                return $row->equity ? $row->equity : '';
            });
            $table->editColumn('matrix_node_num', function ($row) {
                return $row->matrix_node_num ? $row->matrix_node_num : '';
            });
            $table->editColumn('matrix', function ($row) {
                return $row->matrix ? $row->matrix : '';
            });
            $table->editColumn('user_ownership', function ($row) {
                return $row->user_ownership ? $row->user_ownership : '';
            });
            $table->editColumn('previous_login', function ($row) {
                return $row->previous_login ? $row->previous_login : '';
            });
            $table->editColumn('cluster', function ($row) {
                return $row->cluster ? $row->cluster : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.userPositionAccounts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_position_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userPositionAccounts.create');
    }

    public function store(StoreUserPositionAccountRequest $request)
    {
        $userPositionAccount = UserPositionAccount::create($request->all());

        return redirect()->route('admin.user-position-accounts.index');
    }
}
