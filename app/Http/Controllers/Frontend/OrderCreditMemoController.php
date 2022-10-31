<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderCreditMemoRequest;
use App\Models\OrderCreditMemo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderCreditMemoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_credit_memo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderCreditMemos = OrderCreditMemo::all();

        return view('frontend.orderCreditMemos.index', compact('orderCreditMemos'));
    }

    public function show(OrderCreditMemo $orderCreditMemo)
    {
        abort_if(Gate::denies('order_credit_memo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.orderCreditMemos.show', compact('orderCreditMemo'));
    }

    public function destroy(OrderCreditMemo $orderCreditMemo)
    {
        abort_if(Gate::denies('order_credit_memo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderCreditMemo->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderCreditMemoRequest $request)
    {
        OrderCreditMemo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
