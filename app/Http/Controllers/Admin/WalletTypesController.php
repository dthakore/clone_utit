<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWalletTypeRequest;
use App\Http\Requests\StoreWalletTypeRequest;
use App\Http\Requests\UpdateWalletTypeRequest;
use App\Models\WalletType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WalletTypesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('wallet_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WalletType::query()->select(sprintf('%s.*', (new WalletType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'wallet_type_show';
                $editGate = 'wallet_type_edit';
                $deleteGate = 'wallet_type_delete';
                $crudRoutePart = 'wallet-types';

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
            $table->editColumn('wallet_type', function ($row) {
                return $row->wallet_type ? $row->wallet_type : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.walletTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('wallet_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletTypes.create');
    }

    public function store(StoreWalletTypeRequest $request)
    {
        $walletType = WalletType::create($request->all());

        return redirect()->route('admin.wallet-types.index');
    }

    public function edit(WalletType $walletType)
    {
        abort_if(Gate::denies('wallet_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletTypes.edit', compact('walletType'));
    }

    public function update(UpdateWalletTypeRequest $request, WalletType $walletType)
    {
        $walletType->update($request->all());

        return redirect()->route('admin.wallet-types.index');
    }

    public function show(WalletType $walletType)
    {
        abort_if(Gate::denies('wallet_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletTypes.show', compact('walletType'));
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
