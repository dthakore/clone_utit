<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreMtFourDepositWithdrawRequest;
use App\Models\MtFourDepositWithdraw;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MtFourDepositWithdrawController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MtFourDepositWithdraw::query()->select(sprintf('%s.*', (new MtFourDepositWithdraw())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'mt_four_deposit_withdraw_show';
                $editGate = 'mt_four_deposit_withdraw_edit';
                $deleteGate = 'mt_four_deposit_withdraw_delete';
                $crudRoutePart = 'mt-four-deposit-withdraws';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('login', function ($row) {
                return $row->login ? $row->login : '';
            });
            $table->editColumn('ticket', function ($row) {
                return $row->ticket ? $row->ticket : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('api_type', function ($row) {
                return $row->api_type ? MtFourDepositWithdraw::API_TYPE_SELECT[$row->api_type] : '';
            });

            $table->editColumn('profit', function ($row) {
                return $row->profit ? $row->profit : '';
            });
            $table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : '';
            });
            $table->editColumn('is_accounted_for', function ($row) {
                return $row->is_accounted_for ? MtFourDepositWithdraw::IS_ACCOUNTED_FOR_SELECT[$row->is_accounted_for] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.mtFourDepositWithdraws.index');
    }

    public function create()
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mtFourDepositWithdraws.create');
    }

    public function store(StoreMtFourDepositWithdrawRequest $request)
    {
        $mtFourDepositWithdraw = MtFourDepositWithdraw::create($request->all());

        return redirect()->route('admin.mt-four-deposit-withdraws.index');
    }

    public function show(MtFourDepositWithdraw $mtFourDepositWithdraw)
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mtFourDepositWithdraws.show', compact('mtFourDepositWithdraw'));
    }
}
