@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.commissionRule.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.commission-rules.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.commission_plan') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->commission_plan->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.user_level') }}
                                    </th>
                                    <td>
                                        {{ App\Models\CommissionRule::USER_LEVEL_SELECT[$commissionRule->user_level] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.rank') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->rank->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.product') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->product->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.category') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->category->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.amount_type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\CommissionRule::AMOUNT_TYPE_RADIO[$commissionRule->amount_type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.amount') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.wallet_type') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->wallet_type->wallet_type ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.wallet_reference') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->wallet_reference->reference_key ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.denomination') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->denomination->denomination_type ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.wallet_status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\CommissionRule::WALLET_STATUS_RADIO[$commissionRule->wallet_status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.commissionRule.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $commissionRule->updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.commission-rules.index') }}">
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