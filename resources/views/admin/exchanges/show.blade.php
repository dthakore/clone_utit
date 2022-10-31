@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.exchange.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exchanges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.exchange.fields.id') }}
                        </th>
                        <td>
                            {{ $exchange->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchange.fields.name') }}
                        </th>
                        <td>
                            {{ $exchange->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchange.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $exchange->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchange.fields.is_visible') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $exchange->is_visible ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchange.fields.tags') }}
                        </th>
                        <td>
                            {{ $exchange->tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchange.fields.logo') }}
                        </th>
                        <td>
                            @if($exchange->logo)
                                <a href="{{ $exchange->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $exchange->logo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exchanges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection