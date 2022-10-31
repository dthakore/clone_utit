<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWalletMetaTypeRequest;
use App\Http\Requests\StoreWalletMetaTypeRequest;
use App\Http\Requests\UpdateWalletMetaTypeRequest;
use App\Models\WalletMetaType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WalletMetaTypesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('wallet_meta_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WalletMetaType::query()->select(sprintf('%s.*', (new WalletMetaType())->table));
            $query->orderBy('id', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'wallet_meta_type_show';
                $editGate = 'wallet_meta_type_edit';
                $deleteGate = 'wallet_meta_type_delete';
                $crudRoutePart = 'wallet-meta-types';

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
            $table->editColumn('reference_key', function ($row) {
                return $row->reference_key ? $row->reference_key : '';
            });
            $table->editColumn('reference_desc', function ($row) {
                return $row->reference_desc ? $row->reference_desc : '';
            });
            $table->editColumn('reference_data', function ($row) {
                return $row->reference_data ? $row->reference_data : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.walletMetaTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('wallet_meta_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletMetaTypes.create');
    }

    public function store(StoreWalletMetaTypeRequest $request)
    {
        $walletMetaType = WalletMetaType::create($request->all());

        return redirect()->route('admin.wallet-meta-types.index');
    }

    public function edit(WalletMetaType $walletMetaType)
    {
        abort_if(Gate::denies('wallet_meta_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletMetaTypes.edit', compact('walletMetaType'));
    }

    public function update(UpdateWalletMetaTypeRequest $request, WalletMetaType $walletMetaType)
    {
        $walletMetaType->update($request->all());

        return redirect()->route('admin.wallet-meta-types.index');
    }

    public function show(WalletMetaType $walletMetaType)
    {
        abort_if(Gate::denies('wallet_meta_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.walletMetaTypes.show', compact('walletMetaType'));
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
