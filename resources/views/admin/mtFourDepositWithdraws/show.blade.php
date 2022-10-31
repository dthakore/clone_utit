@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mtFourDepositWithdraw.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mt-four-deposit-withdraws.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.id') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.login') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.ticket') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->ticket }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.symbol') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->symbol }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.email') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.api_type') }}
                        </th>
                        <td>
                            {{ App\Models\MtFourDepositWithdraw::API_TYPE_SELECT[$mtFourDepositWithdraw->api_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.lots') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->lots }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.type') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.open_price') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->open_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.open_time') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->open_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.close_price') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->close_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.close_time') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->close_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.profit') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->profit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.commission') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->commission }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.agent_commission') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->agent_commission }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.comment') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->comment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.magic_number') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->magic_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.stop_loss') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->stop_loss }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.take_profit') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->take_profit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.swap') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->swap }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.reason') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->reason }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.is_accounted_for') }}
                        </th>
                        <td>
                            {{ App\Models\MtFourDepositWithdraw::IS_ACCOUNTED_FOR_SELECT[$mtFourDepositWithdraw->is_accounted_for] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourDepositWithdraw.fields.created_at') }}
                        </th>
                        <td>
                            {{ $mtFourDepositWithdraw->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mt-four-deposit-withdraws.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection