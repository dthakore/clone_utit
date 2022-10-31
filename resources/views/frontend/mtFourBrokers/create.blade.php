@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.mtFourBroker.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.mt-four-brokers.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.mtFourBroker.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="server_login">{{ trans('cruds.mtFourBroker.fields.server_login') }}</label>
                            <input class="form-control" type="number" name="server_login" id="server_login" value="{{ old('server_login', '') }}" step="1" required>
                            @if($errors->has('server_login'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('server_login') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.server_login_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="server_password">{{ trans('cruds.mtFourBroker.fields.server_password') }}</label>
                            <input class="form-control" type="text" name="server_password" id="server_password" value="{{ old('server_password', '') }}" required>
                            @if($errors->has('server_password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('server_password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.server_password_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="server_address">{{ trans('cruds.mtFourBroker.fields.server_address') }}</label>
                            <input class="form-control" type="text" name="server_address" id="server_address" value="{{ old('server_address', '') }}" required>
                            @if($errors->has('server_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('server_address') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.server_address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="server_port">{{ trans('cruds.mtFourBroker.fields.server_port') }}</label>
                            <input class="form-control" type="number" name="server_port" id="server_port" value="{{ old('server_port', '') }}" step="1" required>
                            @if($errors->has('server_port'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('server_port') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.server_port_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="agent">{{ trans('cruds.mtFourBroker.fields.agent') }}</label>
                            <input class="form-control" type="number" name="agent" id="agent" value="{{ old('agent', '') }}" step="1">
                            @if($errors->has('agent'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agent') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.agent_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="location">{{ trans('cruds.mtFourBroker.fields.location') }}</label>
                            <input class="form-control" type="text" name="location" id="location" value="{{ old('location', '') }}">
                            @if($errors->has('location'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('location') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.location_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.mtFourBroker.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\MtFourBroker::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="comment">{{ trans('cruds.mtFourBroker.fields.comment') }}</label>
                            <textarea class="form-control" name="comment" id="comment">{{ old('comment') }}</textarea>
                            @if($errors->has('comment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('comment') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourBroker.fields.comment_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection