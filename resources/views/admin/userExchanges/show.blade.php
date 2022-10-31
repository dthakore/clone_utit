@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userExchange.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-exchanges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userExchange.fields.id') }}
                        </th>
                        <td>
                            {{ $userExchange->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExchange.fields.name') }}
                        </th>
                        <td>
                            {{ $userExchange->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExchange.fields.user') }}
                        </th>
                        <td>
                            {{ $userExchange->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExchange.fields.exchange') }}
                        </th>
                        <td>
                            {{ $userExchange->exchange->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-exchanges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection