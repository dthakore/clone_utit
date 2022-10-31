<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreMtFourDepositWithdrawRequest;
use App\Models\MtFourDepositWithdraw;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MtFourDepositWithdrawController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mtFourDepositWithdraws = MtFourDepositWithdraw::all();

        return view('frontend.mtFourDepositWithdraws.index', compact('mtFourDepositWithdraws'));
    }

    public function create()
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mtFourDepositWithdraws.create');
    }

    public function store(StoreMtFourDepositWithdrawRequest $request)
    {
        $mtFourDepositWithdraw = MtFourDepositWithdraw::create($request->all());

        return redirect()->route('frontend.mt-four-deposit-withdraws.index');
    }

    public function show(MtFourDepositWithdraw $mtFourDepositWithdraw)
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mtFourDepositWithdraws.show', compact('mtFourDepositWithdraw'));
    }
}
