@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mtFourBroker.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mt-four-brokers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.id') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.name') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.server_login') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->server_login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.server_password') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->server_password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.server_address') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->server_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.server_port') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->server_port }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.agent') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->agent }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.location') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\MtFourBroker::STATUS_SELECT[$mtFourBroker->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mtFourBroker.fields.comment') }}
                        </th>
                        <td>
                            {{ $mtFourBroker->comment }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mt-four-brokers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection