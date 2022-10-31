<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MtFourMamAccount;
use App\Models\CbmMtFourAccount;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MtFourMamAccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MtFourMamAccount::get();
            
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'mt_four_mam_account_show';
                $editGate = 'mt_four_mam_account_edit';
                $deleteGate = 'mt_four_mam_account_delete';
                $crudRoutePart = 'mam-account';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            // $table->editColumn('account_id', function ($row) {
            //     return $row->account_id ? $row->account_id : '';
            // });

            $table->rawColumns(['actions', 'placeholder']);
            
            return $table->make(true);
        }
        return view('admin.mamAccount.index');
    }

    public function create()
    {
        $accounts = CbmMtFourAccount::pluck('name', 'login');

        return view('admin.mamAccount.create',compact('accounts'));
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $user = MtFourMamAccount::create($inputs);
        return redirect()->route('admin.mam-account.index');
    }

    public function show($id)
    {
        $mtFourMamAccount = MtFourMamAccount::find($id);
        abort_if(Gate::denies('mt_four_mam_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.mamAccount.show', compact('mtFourMamAccount'));
    }

    public function edit($id)
    {
        abort_if(Gate::denies('mt_four_mam_account_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $mtFourMamAccount = MtFourMamAccount::find($id);
        $accounts = CbmMtFourAccount::pluck('name', 'login');

        return view('admin.mamAccount.edit', compact('mtFourMamAccount','accounts'));
    }

    public function update(Request $request,$id)
    {
        $account = MtFourMamAccount::find($id);
        $account->account_id = $request->account_id;
        // $account->login = $request->login;
        $account->agent = $request->agent;
        $account->group = $request->group;
        $account->broker = $request->broker;
        $account->asset_manager = $request->asset_manager;
        $account->agent_name = $request->agent_name;
        $account->minimum_deposit = $request->minimum_deposit;
        $account->parent_agent = $request->parent_agent;
        $account->brand_name = $request->brand_name;
        $account->save();

        return redirect()->route('admin.mam-account.index');
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('mt_four_mam_account_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $account = MtFourMamAccount::findOrFail($id);
        $account->delete();
        return back();
    }

}
