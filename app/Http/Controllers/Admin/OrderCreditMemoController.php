<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderCreditMemoRequest;
use App\Models\OrderCreditMemo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrderCreditMemoController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_credit_memo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = OrderCreditMemo::query()->select(sprintf('%s.*', (new OrderCreditMemo())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'order_credit_memo_show';
                $editGate = 'order_credit_memo_edit';
                $deleteGate = 'order_credit_memo_delete';
                $crudRoutePart = 'order-credit-memos';

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
            $table->editColumn('order', function ($row) {
                return $row->order ? $row->order : '';
            });
            $table->editColumn('invoice_number', function ($row) {
                return $row->invoice_number ? $row->invoice_number : '';
            });
            $table->editColumn('order_total', function ($row) {
                return $row->order_total ? $row->order_total : '';
            });
            $table->editColumn('vat', function ($row) {
                return $row->vat ? $row->vat : '';
            });
            $table->editColumn('refund_amount', function ($row) {
                return $row->refund_amount ? $row->refund_amount : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.orderCreditMemos.index');
    }

    public function show(OrderCreditMemo $orderCreditMemo)
    {
        abort_if(Gate::denies('order_credit_memo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.orderCreditMemos.show', compact('orderCreditMemo'));
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
