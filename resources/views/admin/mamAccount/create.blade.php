@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.mamAccount.title_singular') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.mam-account.store") }}" enctype="multipart/form-data" id="user-form">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="account_id">{{ trans('cruds.mamAccount.fields.account_id') }}</label>
                            <select class="form-control select2 {{ $errors->has('account_id') ? 'is-invalid' : '' }}" name="account_id" id="account_id" required>
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach($accounts as $id => $account)
                                    <option value="{{ $id }}" {{ old('login') == $id ? 'selected' : '' }}>{{ $id }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('account_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('account_id') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6">
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
                </div> --}}
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="agent">{{ trans('cruds.mamAccount.fields.agent') }}</label>
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
                            <label for="group">{{ trans('cruds.mamAccount.fields.group') }}</label>
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
                            <label for="broker">{{ trans('cruds.mamAccount.fields.broker') }}</label>
                            <input class="form-control {{ $errors->has('broker') ? 'is-invalid' : '' }}" type="text" name="broker" id="broker" value="{{ old('broker', '') }}" >
                            @if($errors->has('broker'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('broker') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="asset_manager">{{ trans('cruds.mamAccount.fields.asset_manager') }}</label>
                            <input class="form-control {{ $errors->has('asset_manager') ? 'is-invalid' : '' }}" type="text" name="asset_manager" id="asset_manager" value="{{ old('asset_manager', '') }}" >
                            @if($errors->has('asset_manager'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('asset_manager') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="agent_name">{{ trans('cruds.mamAccount.fields.agent_name') }}</label>
                            <input class="form-control {{ $errors->has('agent_name') ? 'is-invalid' : '' }}" type="text" name="agent_name" id="agent_name" value="{{ old('agent_name', '') }}" >
                            @if($errors->has('agent_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agent_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="minimum_deposit">{{ trans('cruds.mamAccount.fields.minimum_deposit') }}</label>
                            <input class="form-control {{ $errors->has('minimum_deposit') ? 'is-invalid' : '' }}" type="text" name="minimum_deposit" id="minimum_deposit" value="{{ old('minimum_deposit', '') }}" >
                            @if($errors->has('minimum_deposit'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('minimum_deposit') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="parent_agent">{{ trans('cruds.mamAccount.fields.parent_agent') }}</label>
                            <input class="form-control {{ $errors->has('parent_agent') ? 'is-invalid' : '' }}" type="text" name="parent_agent" id="parent_agent" value="{{ old('parent_agent', '') }}" >
                            @if($errors->has('parent_agent'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('parent_agent') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="brand_name">{{ trans('cruds.mamAccount.fields.brand_name') }}</label>
                            <input class="form-control {{ $errors->has('brand_name') ? 'is-invalid' : '' }}" type="text" name="brand_name" id="brand_name" value="{{ old('brand_name', '') }}" >
                            @if($errors->has('brand_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('brand_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" align="right">
                <button class="btn btn-danger" type="submit" style="margin-right: 10px;">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection