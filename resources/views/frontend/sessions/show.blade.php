@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.session.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.sessions.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $session->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.bot') }}
                                    </th>
                                    <td>
                                        {{ $session->bot->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $session->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Session::STATUS_SELECT[$session->status] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.lowest') }}
                                    </th>
                                    <td>
                                        {{ $session->lowest }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.highest') }}
                                    </th>
                                    <td>
                                        {{ $session->highest }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.last_buy') }}
                                    </th>
                                    <td>
                                        {{ $session->last_buy }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.average_buy') }}
                                    </th>
                                    <td>
                                        {{ $session->average_buy }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.total_buy') }}
                                    </th>
                                    <td>
                                        {{ $session->total_buy }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.session.fields.cover') }}
                                    </th>
                                    <td>
                                        {{ $session->cover }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.sessions.index') }}">
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