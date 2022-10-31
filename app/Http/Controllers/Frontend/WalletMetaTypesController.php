<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWalletMetaTypeRequest;
use App\Http\Requests\StoreWalletMetaTypeRequest;
use App\Http\Requests\UpdateWalletMetaTypeRequest;
use App\Models\WalletMetaType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalletMetaTypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('wallet_meta_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletMetaTypes = WalletMetaType::all();

        return view('frontend.walletMetaTypes.index', compact('walletMetaTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('wallet_meta_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.walletMetaTypes.create');
    }

    public function store(StoreWalletMetaTypeRequest $request)
    {
        $walletMetaType = WalletMetaType::create($request->all());

        return redirect()->route('frontend.wallet-meta-types.index');
    }

    public function edit(WalletMetaType $walletMetaType)
    {
        abort_if(Gate::denies('wallet_meta_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.walletMetaTypes.edit', compact('walletMetaType'));
    }

    public function update(UpdateWalletMetaTypeRequest $request, WalletMetaType $walletMetaType)
    {
        $walletMetaType->update($request->all());

        return redirect()->route('frontend.wallet-meta-types.index');
    }

    public function show(WalletMetaType $walletMetaType)
    {
        abort_if(Gate::denies('wallet_meta_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.walletMetaTypes.show', compact('walletMetaType'));
    }

    public function destroy(WalletMetaType $walletMetaType)
    {
        abort_if(Gate::denies('wallet_meta_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletMetaType->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalletMetaTypeRequest $request)
    {
        WalletMetaType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
