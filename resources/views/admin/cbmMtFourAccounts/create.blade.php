@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cbmMtFourAccount.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cbm-mt-four-accounts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="login">{{ trans('cruds.mamAccount.fields.login') }}</label>
                            <input class="form-control {{ $errors->has('login') ? 'is-invalid' : '' }}" type="text" name="login" id="login" value="{{ old('login', '') }}">
                            @if($errors->has('login'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.cbmMtFourAccount.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="currency">{{ trans('cruds.cbmMtFourAccount.fields.currency') }}</label>
                            <input class="form-control {{ $errors->has('currency') ? 'is-invalid' : '' }}" type="text" name="currency" id="currency" value="{{ old('currency', '') }}">
                            @if($errors->has('currency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('currency') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="balance">{{ trans('cruds.cbmMtFourAccount.fields.balance') }}</label>
                            <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="text" name="balance" id="balance" value="{{ old('balance', '') }}">
                            @if($errors->has('balance'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('balance') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prev_balance">{{ trans('cruds.cbmMtFourAccount.fields.prev_balance') }}</label>
                            <input class="form-control {{ $errors->has('prev_balance') ? 'is-invalid' : '' }}" type="text" name="prev_balance" id="prev_balance" value="{{ old('prev_balance', '') }}">
                            @if($errors->has('prev_balance'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('prev_balance') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="equity">{{ trans('cruds.cbmMtFourAccount.fields.equity') }}</label>
                            <input class="form-control {{ $errors->has('equity') ? 'is-invalid' : '' }}" type="text" name="equity" id="equity" value="{{ old('equity', '') }}">
                            @if($errors->has('equity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('equity') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prev_equity">{{ trans('cruds.cbmMtFourAccount.fields.prev_equity') }}</label>
                            <input class="form-control {{ $errors->has('prev_equity') ? 'is-invalid' : '' }}" type="text" name="prev_equity" id="prev_equity" value="{{ old('prev_equity', '') }}">
                            @if($errors->has('prev_equity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('prev_equity') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email_address">{{ trans('cruds.cbmMtFourAccount.fields.email_address') }}</label>
                            <input class="form-control {{ $errors->has('email_address') ? 'is-invalid' : '' }}" type="text" name="email_address" id="email_address" value="{{ old('email_address', '') }}">
                            @if($errors->has('email_address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email_address') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="group">{{ trans('cruds.cbmMtFourAccount.fields.group') }}</label>
                            <input class="form-control {{ $errors->has('group') ? 'is-invalid' : '' }}" type="text" name="group" id="group" value="{{ old('group', '') }}">
                            @if($errors->has('group'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('group') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="agent">{{ trans('cruds.cbmMtFourAccount.fields.agent') }}</label>
                            <input class="form-control {{ $errors->has('agent') ? 'is-invalid' : '' }}" type="text" name="agent" id="agent" value="{{ old('agent', '') }}">
                            @if($errors->has('agent'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agent') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="brand">{{ trans('cruds.cbmMtFourAccount.fields.brand') }}</label>
                            <input class="form-control {{ $errors->has('brand') ? 'is-invalid' : '' }}" type="text" name="brand" id="brand" value="{{ old('brand', '') }}">
                            @if($errors->has('brand'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('brand') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">{{ trans('cruds.cbmMtFourAccount.fields.address') }}</label>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                            @if($errors->has('address'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="leverage">{{ trans('cruds.cbmMtFourAccount.fields.leverage') }}</label>
                            <input class="form-control {{ $errors->has('leverage') ? 'is-invalid' : '' }}" type="text" name="leverage" id="leverage" value="{{ old('leverage', '') }}">
                            @if($errors->has('leverage'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('leverage') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="city">{{ trans('cruds.cbmMtFourAccount.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}">
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="state">{{ trans('cruds.cbmMtFourAccount.fields.state') }}</label>
                            <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', '') }}">
                            @if($errors->has('state'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('state') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="postcode">{{ trans('cruds.cbmMtFourAccount.fields.postcode') }}</label>
                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', '') }}">
                            @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="country">{{ trans('cruds.cbmMtFourAccount.fields.country') }}</label>
                            <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}">
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone_number">{{ trans('cruds.cbmMtFourAccount.fields.phone_number') }}</label>
                            <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}">
                            @if($errors->has('phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="max_equity">{{ trans('cruds.cbmMtFourAccount.fields.max_equity') }}</label>
                            <input class="form-control {{ $errors->has('max_equity') ? 'is-invalid' : '' }}" type="text" name="max_equity" id="max_equity" value="{{ old('max_equity', '') }}">
                            @if($errors->has('max_equity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_equity') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="max_balance">{{ trans('cruds.cbmMtFourAccount.fields.max_balance') }}</label>
                            <input class="form-control {{ $errors->has('max_balance') ? 'is-invalid' : '' }}" type="text" name="max_balance" id="max_balance" value="{{ old('max_balance', '') }}">
                            @if($errors->has('max_balance'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_balance') }}
                                </div>
                            @endif
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