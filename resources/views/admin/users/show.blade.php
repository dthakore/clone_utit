@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.user.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>&nbsp;
                    <a class="btn btn-default" target="_blank" href="{{ route('admin.users.login',$user->id) }}">
                        {{ trans('global.user_login') }}
                        <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                    </a>&nbsp;
                    <a class="btn btn-default" target="_blank" href="{{ route('admin.users.tree',$user->id) }}">
                        {{ trans('global.tree_view') }}
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </a>&nbsp;
                    <a class="btn btn-default" target="_blank" href="{{ route('admin.users.edit',$user->id) }}">
                        {{ trans('global.edit_user') }}
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="card">
                    <ul class="nav nav-tabs mb-2" role="tablist" id="relationship-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#general_info" role="tab" data-toggle="tab">
                                {{ trans('global.general_info') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sponsor_users" role="tab" data-toggle="tab">
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                        @can('wallet_management_access')
                            <li class="nav-item">
                                <a class="nav-link" href="#user_allwallettransactions" role="tab" data-toggle="tab">
                                    {{ trans('cruds.allwallettransaction.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('order_access')
                            <li class="nav-item">
                                <a class="nav-link" href="#user_orders" role="tab" data-toggle="tab">
                                    {{ trans('cruds.order.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_alert_access')
                            <li class="nav-item">
                                <a class="nav-link" href="#user_user_alerts" role="tab" data-toggle="tab">
                                    {{ trans('cruds.userAlert.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" role="tabpanel" id="general_info">
                            {{-- @includeIf('admin.users',$user->id) --}}
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $user->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.first_name') }}
                                    </th>
                                    <td>
                                        {{ $user->first_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.middle_name') }}
                                    </th>
                                    <td>
                                        {{ $user->middle_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.last_name') }}
                                    </th>
                                    <td>
                                        {{ $user->last_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.email') }}
                                    </th>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.sponsor') }}
                                    </th>
                                    <td>
                                        {{ $user->sponsor->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.date_of_birth') }}
                                    </th>
                                    <td>
                                        {{ $user->date_of_birth }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.gender') }}
                                    </th>
                                    <td>
                                        {{ App\Models\User::GENDER_RADIO[$user->gender] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.language') }}
                                    </th>
                                    <td>
                                        {{ App\Models\User::LANGUAGE_SELECT[$user->language] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.is_enabled') }}
                                    </th>
                                    <td>
                                        {{ App\Models\User::IS_ENABLED_SELECT[$user->is_enabled] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.is_active') }}
                                    </th>
                                    <td>
                                        {{ App\Models\User::IS_ACTIVE_SELECT[$user->is_active] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.is_special') }}
                                    </th>
                                    <td>
                                        {{ App\Models\User::IS_ACTIVE_SELECT[$user->is_special] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.building_num') }}
                                    </th>
                                    <td>
                                        {{ $user->building_num }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.street') }}
                                    </th>
                                    <td>
                                        {{ $user->street }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.region') }}
                                    </th>
                                    <td>
                                        {{ $user->region }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.postcode') }}
                                    </th>
                                    <td>
                                        {{ $user->postcode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.city') }}
                                    </th>
                                    <td>
                                        {{ $user->city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.country') }}
                                    </th>
                                    <td>
                                        {{ $user->country->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.phone') }}
                                    </th>
                                    <td>
                                        {{ $user->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.business_name') }}
                                    </th>
                                    <td>
                                        {{ $user->business_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.vat_number') }}
                                    </th>
                                    <td>
                                        {{ $user->vat_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.bus_address_building_num') }}
                                    </th>
                                    <td>
                                        {{ $user->bus_address_building_num }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.bus_address_street') }}
                                    </th>
                                    <td>
                                        {{ $user->bus_address_street }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.bus_address_region') }}
                                    </th>
                                    <td>
                                        {{ $user->bus_address_region }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.bus_address_city') }}
                                    </th>
                                    <td>
                                        {{ $user->bus_address_city }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.bus_address_postcode') }}
                                    </th>
                                    <td>
                                        {{ $user->bus_address_postcode }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.bus_address_country') }}
                                    </th>
                                    <td>
                                        {{ $user->bus_address_country->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.business_phone') }}
                                    </th>
                                    <td>
                                        {{ $user->business_phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.notification_mail') }}
                                    </th>
                                    <td>
                                        {{ $user->notification_mail }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.marketting_mail') }}
                                    </th>
                                    <td>
                                        {{ $user->marketting_mail }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.roles') }}
                                    </th>
                                    <td>
                                        @foreach($user->roles as $key => $roles)
                                            <span class="label label-info">{{ $roles->title }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.rank') }}
                                    </th>
                                    <td>
                                        {{ $user->rank->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Product
                                    </th>
                                    <td>
                                        {{ $user->product->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $user->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $user->updated_at }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="sponsor_users">
                            @includeIf('admin.users.relationships.sponsorUsers', ['users' => $user->sponsorUsers])
                        </div>
                        <div class="tab-pane" role="tabpanel" id="user_allwallettransactions">
                            @includeIf('admin.users.relationships.userAllwallettransactions', ['allwallettransactions' => $user->userAllwallettransactions])
                        </div>
                        <div class="tab-pane" role="tabpanel" id="user_orders">
                            @includeIf('admin.users.relationships.userOrders', ['orders' => $user->userOrders])
                        </div>
                        <div class="tab-pane" role="tabpanel" id="user_user_alerts">
                            @includeIf('admin.users.relationships.userUserAlerts', ['userAlerts' => $user->userUserAlerts])
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.users.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
