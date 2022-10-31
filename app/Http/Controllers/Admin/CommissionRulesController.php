<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommissionRuleRequest;
use App\Http\Requests\StoreCommissionRuleRequest;
use App\Http\Requests\UpdateCommissionRuleRequest;
use App\Models\CommissionRule;
use App\Models\Denomination;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Rank;
use App\Models\WalletMetaType;
use App\Models\WalletType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CommissionRulesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('commission_rule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CommissionRule::with(['commission_plan', 'rank', 'product', 'category', 'wallet_type', 'wallet_reference', 'denomination'])->select(sprintf('%s.*', (new CommissionRule())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'commission_rule_show';
                $editGate = 'commission_rule_edit';
                $deleteGate = 'commission_rule_delete';
                $crudRoutePart = 'commission-rules';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->addColumn('commission_plan_name', function ($row) {
                return $row->commission_plan ? $row->commission_plan->name : '';
            });

            $table->editColumn('user_level', function ($row) {
                return $row->user_level ? CommissionRule::USER_LEVEL_SELECT[$row->user_level] : '';
            });
            $table->addColumn('rank_name', function ($row) {
                return $row->rank ? $row->rank->name : '';
            });

            $table->editColumn('amount_type', function ($row) {
                return $row->amount_type ? CommissionRule::AMOUNT_TYPE_RADIO[$row->amount_type] : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'commission_plan', 'rank']);

            return $table->make(true);
        }

        $plans              = Plan::get();
        $ranks              = Rank::get();
        $products           = Product::get();
        $product_categories = ProductCategory::get();
        $wallet_types       = WalletType::get();
        $wallet_meta_types  = WalletMetaType::get();
        $denominations      = Denomination::get();

        return view('admin.commissionRules.index', compact('plans', 'ranks', 'products', 'product_categories', 'wallet_types', 'wallet_meta_types', 'denominations'));
    }

    public function create()
    {
        abort_if(Gate::denies('commission_rule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commission_plans = Plan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ranks = Rank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = ProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_types = WalletType::pluck('wallet_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_references = WalletMetaType::pluck('reference_key', 'id')->prepend(trans('global.pleaseSelect'), '');

        $denominations = Denomination::pluck('denomination_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.commissionRules.create', compact('commission_plans', 'ranks', 'products', 'categories', 'wallet_types', 'wallet_references', 'denominations'));
    }

    public function store(StoreCommissionRuleRequest $request)
    {
        $commissionRule = CommissionRule::create($request->all());

        return redirect()->route('admin.commission-rules.index');
    }

    public function edit(CommissionRule $commissionRule)
    {
        abort_if(Gate::denies('commission_rule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commission_plans = Plan::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ranks = Rank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = ProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_types = WalletType::pluck('wallet_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $wallet_references = WalletMetaType::pluck('reference_key', 'id')->prepend(trans('global.pleaseSelect'), '');

        $denominations = Denomination::pluck('denomination_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $commissionRule->load('commission_plan', 'rank', 'product', 'category', 'wallet_type', 'wallet_reference', 'denomination');

        return view('admin.commissionRules.edit', compact('commission_plans', 'ranks', 'products', 'categories', 'wallet_types', 'wallet_references', 'denominations', 'commissionRule'));
    }

    public function update(UpdateCommissionRuleRequest $request, CommissionRule $commissionRule)
    {
        $commissionRule->update($request->all());

        return redirect()->route('admin.commission-rules.index');
    }

    public function show(CommissionRule $commissionRule)
    {
        abort_if(Gate::denies('commission_rule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commissionRule->load('commission_plan', 'rank', 'product', 'category', 'wallet_type', 'wallet_reference', 'denomination');

        return view('admin.commissionRules.show', compact('commissionRule'));
    }

    public function destroy(CommissionRule $commissionRule)
    {
        abort_if(Gate::denies('commission_rule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commissionRule->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommissionRuleRequest $request)
    {
        CommissionRule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
