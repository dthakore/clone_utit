<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreCbmMtFourAccountRequest;
use App\Models\CbmMtFourAccount;
use App\Models\MtFourBroker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CbmMtFourAccountsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('cbm_mt_four_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cbmMtFourAccounts = CbmMtFourAccount::with(['broker'])->get();

        $mt_four_brokers = MtFourBroker::get();

        return view('frontend.cbmMtFourAccounts.index', compact('cbmMtFourAccounts', 'mt_four_brokers'));
    }

    public function create()
    {
        abort_if(Gate::denies('cbm_mt_four_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.cbmMtFourAccounts.create');
    }

    public function store(StoreCbmMtFourAccountRequest $request)
    {
        $cbmMtFourAccount = CbmMtFourAccount::create($request->all());

        return redirect()->route('frontend.cbm-mt-four-accounts.index');
    }

    public function show(CbmMtFourAccount $cbmMtFourAccount)
    {
        abort_if(Gate::denies('cbm_mt_four_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cbmMtFourAccount->load('broker');

        return view('frontend.cbmMtFourAccounts.show', compact('cbmMtFourAccount'));
    }
}
