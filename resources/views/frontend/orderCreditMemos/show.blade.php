@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.orderCreditMemo.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.order-credit-memos.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.order') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->order }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.invoice_number') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->invoice_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.order_total') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->order_total }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.vat') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->vat }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.refund_amount') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->refund_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.memo_status') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->memo_status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.orderCreditMemo.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $orderCreditMemo->created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.order-credit-memos.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection