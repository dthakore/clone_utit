@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.allwallettransaction.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.allwallettransactions.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.wallet_type') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->wallet_type->wallet_type ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.transaction_type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Allwallettransaction::TRANSACTION_TYPE_SELECT[$allwallettransaction->transaction_type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.reference') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->reference->reference_desc ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.reference_num') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->reference_num }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.transaction_comment') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->transaction_comment }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.denomination') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->denomination->denomination_type ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.transaction_status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT[$allwallettransaction->transaction_status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.amount') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.allwallettransaction.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $allwallettransaction->updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.allwallettransactions.index') }}">
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