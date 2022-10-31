<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreCbmMtFourAccountRequest;
use App\Models\CbmMtFourAccount;
use App\Models\MtFourBroker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\MtFourAccountsExport;
use Maatwebsite\Excel\Facades\Excel;

class CbmMtFourAccountsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        
        abort_if(Gate::denies('cbm_mt_four_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            // dd($request->get('login'));
            $query = CbmMtFourAccount::with(['broker'])->select(sprintf('%s.*', (new CbmMtFourAccount())->table));
            $priceStart = 0.00;
            $priceEnd = 100000.00;
            if($request->has('login') && $request->get('login') != null){
                $query->where("login", "like", "%{$request->get('login')}%");
            }
            if($request->has('email') && $request->get('email') != null){
                $query->where("email_address", "like", "%{$request->get('email')}%");
            }
            if($request->has('agent') && $request->get('agent') != null){
                $query->where("agent", "like", "%{$request->get('agent')}%");
            }
            if($request->has('broker') && $request->get('broker') != null){
                $query->whereIn("broker_id",$request->get('broker'));
            }
            if($request->get('fromAmount') != null){
                $priceStart = number_format($request->get('fromAmount'), 2, '.', '');
            }
            if($request->get('toAmount') != null){
                $priceEnd = number_format($request->get('toAmount'), 2, '.', '');;
            }
            if ($priceStart > 0) {
                $query->whereBetween("balance", [$priceStart , $priceEnd]);
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $row->id = $row->login;
                $viewGate = 'cbm_mt_four_account_show';
                $editGate = 'cbm_mt_four_account_edit';
                $deleteGate = 'cbm_mt_four_account_delete';
                $crudRoutePart = 'cbm-mt-four-accounts';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('balance', function ($row) {
                return $row->balance ? $row->balance : '';
            });
            $table->editColumn('equity', function ($row) {
                return $row->equity ? $row->equity : '';
            });
            $table->editColumn('email_address', function ($row) {
                return $row->email_address ? $row->email_address : '';
            });
            $table->editColumn('agent', function ($row) {
                return $row->agent ? $row->agent : '';
            });
            $table->editColumn('brand', function ($row) {
                return $row->brand ? $row->brand : '';
            });
            $table->editColumn('leverage', function ($row) {
                return $row->leverage ? $row->leverage : '';
            });
            $table->editColumn('max_equity', function ($row) {
                return $row->max_equity ? $row->max_equity : '';
            });
            $table->editColumn('max_balance', function ($row) {
                return $row->max_balance ? $row->max_balance : '';
            });
            $table->addColumn('broker_name', function ($row) {
                return $row->broker ? $row->broker->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'broker']);

            return $table->make(true);
        }

        $mt_four_brokers = MtFourBroker::get();

        return view('admin.cbmMtFourAccounts.index', compact('mt_four_brokers'));
    }

    public function exportTransaction(Request $request)
    {
        $data['login']  = $request->input('login');
        $data['email']    = $request->input('email');
        $data['agent']  = $request->input('agent');
        $data['broker']    = $request->input('broker');
        $data['fromAmount']  = $request->input('fromAmount');
        $data['toAmount']    = $request->input('toAmount');

        return Excel::download(new MtFourAccountsExport($data), 'cbmMt4Accounts.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX] );
        
    }

    public function create()
    {
        // dd('aa');
        abort_if(Gate::denies('cbm_mt_four_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cbmMtFourAccounts.create');
    }

    public function store(StoreCbmMtFourAccountRequest $request)
    {
        //dd('a1a');
        $cbmMtFourAccount = CbmMtFourAccount::create($request->all());

        return redirect()->route('admin.cbm-mt-four-accounts.index');
    }

    public function show(CbmMtFourAccount $cbmMtFourAccount)
    {
        abort_if(Gate::denies('cbm_mt_four_account_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cbmMtFourAccount->load('broker');

        return view('admin.cbmMtFourAccounts.show', compact('cbmMtFourAccount'));
    }
}
