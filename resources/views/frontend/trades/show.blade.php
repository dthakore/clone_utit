@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.trade.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.trades.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $trade->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.bot') }}
                                    </th>
                                    <td>
                                        {{ $trade->bot->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.session') }}
                                    </th>
                                    <td>
                                        {{ $trade->session->status ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.symbol') }}
                                    </th>
                                    <td>
                                        {{ $trade->symbol->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $trade->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.requested_amount') }}
                                    </th>
                                    <td>
                                        {{ $trade->requested_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.side') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Trade::SIDE_SELECT[$trade->side] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.comment') }}
                                    </th>
                                    <td>
                                        {{ $trade->comment }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.failure_reason') }}
                                    </th>
                                    <td>
                                        {{ $trade->failure_reason }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.exchange_order_status') }}
                                    </th>
                                    <td>
                                        {{ $trade->exchange_order_status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.original_orders') }}
                                    </th>
                                    <td>
                                        {{ $trade->original_orders }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.exchange_order_ref') }}
                                    </th>
                                    <td>
                                        {{ $trade->exchange_order_ref }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.exchange_trade_ref') }}
                                    </th>
                                    <td>
                                        {{ $trade->exchange_trade_ref }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.requested_price') }}
                                    </th>
                                    <td>
                                        {{ $trade->requested_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.requested_quantity') }}
                                    </th>
                                    <td>
                                        {{ $trade->requested_quantity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.executed_price') }}
                                    </th>
                                    <td>
                                        {{ $trade->executed_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.executed_amount') }}
                                    </th>
                                    <td>
                                        {{ $trade->executed_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.executed_quantity') }}
                                    </th>
                                    <td>
                                        {{ $trade->executed_quantity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.cover') }}
                                    </th>
                                    <td>
                                        {{ $trade->cover->index ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.trade.fields.status') }}
                                    </th>
                                    <td>
                                        {{ $trade->status }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.trades.index') }}">
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