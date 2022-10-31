@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.mtFourTrade.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.mt-four-trades.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.login') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->login }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.agent_number') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->agent_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.ticket') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->ticket }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.symbol') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->symbol }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.ccy') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->ccy }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.type') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.lots') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->lots }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.open_price') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->open_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.open_time') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->open_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.close_price') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->close_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.close_time') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->close_time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.profit') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->profit }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.commission') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->commission }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.agent_commission') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->agent_commission }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.comment') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->comment }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.magic_number') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->magic_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.stop_loss') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->stop_loss }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.take_profit') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->take_profit }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.swap') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->swap }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.reason') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->reason }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.is_accounted_for') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->is_accounted_for }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.mtFourTrade.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $mtFourTrade->created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.mt-four-trades.index') }}">
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