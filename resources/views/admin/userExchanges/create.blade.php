@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userExchange.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-exchanges.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.userExchange.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="user_id">{{ trans('cruds.userExchange.fields.user') }}</label>
                            <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <span class="text-danger">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.user_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="key">{{ trans('cruds.userExchange.fields.key') }}</label>
                            <input class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" type="password" name="key" id="key" required>
                            @if($errors->has('key'))
                                <span class="text-danger">{{ $errors->first('key') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.key_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="secret">{{ trans('cruds.userExchange.fields.secret') }}</label>
                            <input class="form-control {{ $errors->has('secret') ? 'is-invalid' : '' }}" type="password" name="secret" id="secret" required>
                            @if($errors->has('secret'))
                                <span class="text-danger">{{ $errors->first('secret') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.secret_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="exchange_id">{{ trans('cruds.userExchange.fields.exchange') }}</label>
                            <select class="form-control select2 {{ $errors->has('exchange') ? 'is-invalid' : '' }}" name="exchange_id" id="exchange_id" required>
                                @foreach($exchanges as $id => $entry)
                                    <option value="{{ $id }}" {{ old('exchange_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('exchange'))
                                <span class="text-danger">{{ $errors->first('exchange') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.exchange_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" align="right">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection