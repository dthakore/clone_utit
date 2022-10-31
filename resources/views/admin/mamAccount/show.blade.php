@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mamAccount.title') }}
    </div>

    <div class="tab-content">
        <div class="tab-pane active show" role="tabpanel" id="general_info">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.id') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.account_id') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->account_id }}
                    </td>
                </tr>
                {{-- <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.login') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->login }}
                    </td>
                </tr> --}}
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.agent') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->agent }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.group') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->group }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.broker') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->broker }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.asset_manager') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->asset_manager }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.agent_name') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->agent_name }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.minimum_deposit') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->minimum_deposit }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.parent_agent') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->parent_agent }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.mamAccount.fields.brand_name') }}
                    </th>
                    <td>
                        {{ $mtFourMamAccount->brand_name }}
                    </td>
                </tr>
                
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection