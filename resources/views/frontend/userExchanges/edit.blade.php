@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.userExchange.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.user-exchanges.update", [$userExchange->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.userExchange.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $userExchange->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.name_helper') }}</span>
                        </div>
                        <input type="hidden" name="user_id" value="{{ $userExchange->user->id }}"/>
                       <div class="form-group">
                            <label  for="key">{{ trans('cruds.userExchange.fields.key') }}</label>
                            <input class="form-control" type="password" name="key" id="key">
                            {{--@if($errors->has('key'))--}}
                                {{--<div class="invalid-feedback">--}}
                                    {{--{{ $errors->first('key') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                            {{--<span class="help-block">{{ trans('cruds.userExchange.fields.key_helper') }}</span>--}}
                        </div>
                        <div class="form-group">
                            <label  for="secret">{{ trans('cruds.userExchange.fields.secret') }}</label>
                            <input class="form-control" type="password" name="secret" id="secret">
                            {{--@if($errors->has('secret'))--}}
                                {{--<div class="invalid-feedback">--}}
                                    {{--{{ $errors->first('secret') }}--}}
                                {{--</div>--}}
                            {{--@endif--}}
                            {{--<span class="help-block">{{ trans('cruds.userExchange.fields.secret_helper') }}</span>--}}
                        </div>
                        <div class="form-group">
                            <label class="required" for="exchange_id">{{ trans('cruds.userExchange.fields.exchange') }}</label>
                            <select class="form-control select2" name="exchange_id" id="exchange_id" required>
                                @foreach($exchanges as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('exchange_id') ? old('exchange_id') : $userExchange->exchange->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('exchange'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exchange') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.exchange_helper') }}</span>
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
