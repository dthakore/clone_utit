@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.cbmMtFourAccount.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.cbm-mt-four-accounts.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.login') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->login }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.currency') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->currency }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.balance') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->balance }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.prev_balance') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->prev_balance }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.equity') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->equity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.prev_equity') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->prev_equity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.email_address') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->email_address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.group') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->group }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.agent') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->agent }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.brand') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->brand }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.registration_date') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->registration_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.address') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.leverage') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->leverage }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.city') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.state') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->state }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.postcode') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->postcode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.country') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->country }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.phone_number') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->phone_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.max_equity') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->max_equity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.max_balance') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->max_balance }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.broker') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->broker->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.cbmMtFourAccount.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $cbmMtFourAccount->updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.cbm-mt-four-accounts.index') }}">
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