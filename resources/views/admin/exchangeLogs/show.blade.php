@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.exchangeLog.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exchange-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.id') }}
                        </th>
                        <td>
                            {{ $exchangeLog->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.code') }}
                        </th>
                        <td>
                            {{ $exchangeLog->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.error') }}
                        </th>
                        <td>
                            {{ $exchangeLog->error }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.log') }}
                        </th>
                        <td>
                            {{ $exchangeLog->log }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.order') }}
                        </th>
                        <td>
                            {{ $exchangeLog->order_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.exchange') }}
                        </th>
                        <td>
                            {{ $exchangeLog->exchange }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exchangeLog.fields.request') }}
                        </th>
                        <td>
                            {{ $exchangeLog->request }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exchange-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection