<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAllwallettransactionRequest;
use App\Http\Requests\StoreAllwallettransactionRequest;
use App\Http\Requests\UpdateAllwallettransactionRequest;
use App\Models\Allwallettransaction;
use App\Models\Denomination;
use App\Models\User;
use App\Models\WalletMetaType;
use App\Models\WalletType;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AllwallettransactionsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {

        abort_if(Gate::denies('allwallettransaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = Allwallettransaction::with(['user', 'wallet_type', 'reference', 'denomination'])->select(sprintf('%s.*', (new Allwallettransaction())->table));
        if ($request->ajax()) {
            $start = '';
            $end = '';
            $priceStart = 0.00;
            $priceEnd = 100000.00;
            if($request->get('fromAmount') != null){
                $priceStart = number_format($request->get('fromAmount'), 2, '.', '');
            }
            if($request->get('toAmount') != null){
                $priceEnd = number_format($request->get('toAmount'), 2, '.', '');;
            }

            if($request->get('start_date') != null){
                $start = date('Y-m-d 00:00:00',strtotime($request->get('start_date')));
            }
            if($request->get('end_date') != null){
                $end = date('Y-m-d 23:59:59',strtotime($request->get('end_date')));
            }

            if ($start != '' && $end != '') {
                $query->whereBetween('all_wallet_transactions.created_at', [$start, $end]);
            } else if ($start != '') {
                $query->where("all_wallet_transactions.created_at", "like", "%{$start}%");
            }
            if ($request->has('transaction_type') && $request->get('transaction_type') != null && $request->get('transaction_type') != 0) {
                $query->where('transaction_type', $request->get('transaction_type'));
            }

            if ($request->has('transaction_status') && $request->get('transaction_status') != null && $request->get('transaction_status') != 0) {
                $query->where('transaction_status', $request->get('transaction_status'));
            }
            if ($request->has('userid') && $request->get('userid') != null) {
                $query->where("user_id", $request->get('userid'));
            }
            if ($request->has('user') && $request->get('user') != null) {
                $user = $request->get('user');
                if($user[0] != 0){
                    $query->whereIn('user_id', $request->get('user'));
                }
            }
            if ($request->has('user_id') && $request->get('user_id') != null && $request->get('user_id') != '') {
                $query->whereIn('user_id', [$request->get('user_id')]);
            }

            if ($request->has('reference') && $request->get('reference') != null) {
                $ref = $request->get('reference');
                if($ref[0] != 0){
                    $query->whereIn('reference_id', $request->get('reference'));
                }
            }
            if ($request->has('transaction_comment') && $request->get('transaction_comment') != null) {
                $comment = $request->get('transaction_comment');
                $query->where('transaction_comment', "like", "%$comment%");
            }

            if ($priceStart > 0) {
                $query->whereBetween("amount", [$priceStart , $priceEnd]);
            }

//            if ($start != '' && $end != '') {
//                $query->whereBetween('all_wallet_transactions.created_at', ["'{$start} 00:00:00'", "{$end} 23:59:59"]);
//            } else if ($start != '') {
//                $query->where("created_at", "like", "%{$start}%");
//            }

            $query->orderBy('id', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'allwallettransaction_show';
                $editGate = 'allwallettransaction_edit';
                $deleteGate = 'allwallettransaction_delete';
                $crudRoutePart = 'allwallettransactions';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('user_email', function ($row) {
                return $row->user->email;
            });

            $table->addColumn('user_id', function ($row) {
                return $row->user_id;
            });

            $table->addColumn('wallet_type_wallet_type', function ($row) {
                return $row->wallet_type ? $row->wallet_type->wallet_type : '';
            });

            $table->editColumn('transaction_type', function ($row) {
                return $row->transaction_type ? Allwallettransaction::TRANSACTION_TYPE_SELECT[$row->transaction_type] : '';
            });
            $table->addColumn('reference_reference_desc', function ($row) {
                return $row->reference ? $row->reference->reference_desc : '';
            });

            $table->editColumn('transaction_comment', function ($row) {
                return $row->transaction_comment ? $row->transaction_comment : '';
            });
            $table->addColumn('denomination_denomination_type', function ($row) {
                return $row->denomination ? $row->denomination->denomination_type : '';
            });

            $table->editColumn('transaction_status', function ($row) {
                return $row->transaction_status ? Allwallettransaction::TRANSACTION_STATUS_SELECT[$row->transaction_status] : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'wallet_type', 'reference', 'denomination']);

            return $table->make(true);
        }

        $users             = User::get();
        $wallet_types      = WalletType::get();
        $wallet_meta_types = WalletMetaType::get();
        $denominations     = Denomination::get();

        return view('admin.allwallettransactions.index', compact('users', 'wallet_types', 'wallet_meta_types', 'denominations'));
    }

    public function userWallet(Request $request){
        abort_if(Gate::denies('allwallettransaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            if ($request->has('user') && $request->get('user') != '' && $request->get('user') > 0) {
                $user=$request->get('user');
                $sql = "select user_id,sum( (case when transaction_type = 1 then 1 else -1 end) * amount) as balance from all_wallet_transactions where user_id='$user' group by user_id";
            } else{
                $sql = "select user_id,sum( (case when transaction_type = 1 then 1 else -1 end) * amount) as balance from all_wallet_transactions group by user_id";
            }
            $query = DB::select(DB::Raw($sql));

            $table = Datatables::of($query);
            $table->editColumn('user_id', function ($row) {
//                return $row->transaction_status ? Allwallettransaction::TRANSACTION_STATUS_SELECT[$row->transaction_status] : '';
                return User::where('id',$row->user_id)->get()->first()->name;
            });
            $table->addColumn('action', function ($row) {
                $url = Url('admin/allwallettransactions?id='.$row->user_id);
                $action = '<a target="_blank" href="'.$url.'" class="btn btn-primary">View</a>';
                return '<div class="tagFormat">' . $action . '</div>';

            });
            return $table->make(true);
        }

        $users             = User::get();
        $wallet_types      = WalletType::get();
        $wallet_meta_types = WalletMetaType::get();
        $denominations     = Denomination::get();

        return view('admin.userwallet.index', compact('users', 'wallet_types', 'wallet_meta_types', 'denominations'));
    }


    public function create()
    {
        abort_if(Gate::denies('allwallettransaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_types = WalletType::pluck('wallet_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $references = WalletMetaType::pluck('reference_desc', 'id')->prepend(trans('global.pleaseSelect'), '');

        $denominations = Denomination::pluck('denomination_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.allwallettransactions.create', compact('users', 'wallet_types', 'references', 'denominations'));
    }

    public function store(StoreAllwallettransactionRequest $request)
    {
        session(['audit_log' => "(Admin)User ".auth()->id()." created new wallet", 'audit_log_category' => "Deposit/Withdrawal"]);
        $allwallettransaction = Allwallettransaction::create($request->all());

        return redirect()->route('admin.allwallettransactions.index');
    }

    public function edit(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_types = WalletType::pluck('wallet_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $references = WalletMetaType::pluck('reference_desc', 'id')->prepend(trans('global.pleaseSelect'), '');

        $denominations = Denomination::pluck('denomination_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $allwallettransaction->load('user', 'wallet_type', 'reference', 'denomination');

        return view('admin.allwallettransactions.edit', compact('users', 'wallet_types', 'references', 'denominations', 'allwallettransaction'));
    }

    public function update(UpdateAllwallettransactionRequest $request, Allwallettransaction $allwallettransaction)
    {
        session(['audit_log' => "(Admin)User ".auth()->id()." updated wallet", 'audit_log_category' => "Deposit/Withdrawal"]);
        $allwallettransaction->update($request->all());

        return redirect()->route('admin.allwallettransactions.index');
    }

    public function show(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allwallettransaction->load('user', 'wallet_type', 'reference', 'denomination');

        return view('admin.allwallettransactions.show', compact('allwallettransaction'));
    }

    public function destroy(Allwallettransaction $allwallettransaction)
    {
        abort_if(Gate::denies('allwallettransaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        session(['audit_log' => "(Admin)User ".auth()->id()." deleted wallet", 'audit_log_category' => "Deposit/Withdrawal"]);

        $allwallettransaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyAllwallettransactionRequest $request)
    {
        Allwallettransaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
