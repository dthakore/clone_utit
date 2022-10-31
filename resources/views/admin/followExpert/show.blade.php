@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} Expert
    </div>

    <div class="tab-content">
        <div class="tab-pane active show" role="tabpanel" id="general_info">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.id') }}
                    </th>
                    <td>
                        {{ $expert->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.name') }}
                    </th>
                    <td>
                        {{ $expert->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.account') }}
                    </th>
                    <td>
                        {{ $expert->account }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.type') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::EXPERT_TYPE[$expert->type] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.agent') }}
                    </th>
                    <td>
                        {{ $expert->agent }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.agent_name') }}
                    </th>
                    <td>
                        {{ $expert->agent_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.group') }}
                    </th>
                    <td>
                        {{ $expert->group }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.broker') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::BROKER_TYPE[$expert->broker] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.asset_manager') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::ASSET_MANAGER[$expert->asset_manager] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.minimum_deposit') }}
                    </th>
                    <td>
                        {{ $expert->minimum_deposit }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.asset_type') }}
                    </th>
                    <td>
                        {{ $expert->asset_type }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.setting') }}
                    </th>
                    <td>
                        {{ $expert->setting }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.total_investors') }}
                    </th>
                    <td>
                        {{ $expert->total_investors }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.aum') }}
                    </th>
                    <td>
                        {{ $expert->aum }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.is_forex') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::IS_FOREX[$expert->is_forex] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.is_verified') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::IS_VERIFIED[$expert->is_verified] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.is_manual_trader') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::IS_MANUAL_TRADER[$expert->is_manual_trader] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.currency') }}
                    </th>
                    <td>
                        {{ App\Models\Expert::CURRENCY[$expert->currency] ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.followExpert.fields.performance_fee') }}
                    </th>
                    <td>
                        {{ $expert->performance_fee }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection