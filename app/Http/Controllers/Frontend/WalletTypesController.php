<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWalletTypeRequest;
use App\Http\Requests\StoreWalletTypeRequest;
use App\Http\Requests\UpdateWalletTypeRequest;
use App\Models\WalletType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletTypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('wallet_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletTypes = WalletType::all();

        return view('frontend.walletTypes.index', compact('walletTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('wallet_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.walletTypes.create');
    }

    public function store(StoreWalletTypeRequest $request)
    {
        $walletType = WalletType::create($request->all());

        return redirect()->route('frontend.wallet-types.index');
    }

    public function edit(WalletType $walletType)
    {
        abort_if(Gate::denies('wallet_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.walletTypes.edit', compact('walletType'));
    }

    public function update(UpdateWalletTypeRequest $request, WalletType $walletType)
    {
        $walletType->update($request->all());

        return redirect()->route('frontend.wallet-types.index');
    }

    public function show(WalletType $walletType)
    {
        abort_if(Gate::denies('wallet_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.walletTypes.show', compact('walletType'));
    }

    public function destroy(WalletType $walletType)
    {
        abort_if(Gate::denies('wallet_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletType->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalletTypeRequest $request)
    {
        WalletType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
