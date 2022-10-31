@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.commissionRule.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.commission-rules.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="commission_plan_id">{{ trans('cruds.commissionRule.fields.commission_plan') }}</label>
                            <select class="form-control select2" name="commission_plan_id" id="commission_plan_id" required>
                                @foreach($commission_plans as $id => $entry)
                                    <option value="{{ $id }}" {{ old('commission_plan_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('commission_plan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('commission_plan') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.commission_plan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.commissionRule.fields.user_level') }}</label>
                            <select class="form-control" name="user_level" id="user_level" required>
                                <option value disabled {{ old('user_level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\CommissionRule::USER_LEVEL_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('user_level', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user_level'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user_level') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.user_level_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="rank_id">{{ trans('cruds.commissionRule.fields.rank') }}</label>
                            <select class="form-control select2" name="rank_id" id="rank_id" required>
                                @foreach($ranks as $id => $entry)
                                    <option value="{{ $id }}" {{ old('rank_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('rank'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('rank') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.rank_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="product_id">{{ trans('cruds.commissionRule.fields.product') }}</label>
                            <select class="form-control select2" name="product_id" id="product_id">
                                @foreach($products as $id => $entry)
                                    <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('product'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.product_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="category_id">{{ trans('cruds.commissionRule.fields.category') }}</label>
                            <select class="form-control select2" name="category_id" id="category_id">
                                @foreach($categories as $id => $entry)
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.category_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.commissionRule.fields.amount_type') }}</label>
                            @foreach(App\Models\CommissionRule::AMOUNT_TYPE_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="amount_type_{{ $key }}" name="amount_type" value="{{ $key }}" {{ old('amount_type', '') === (string) $key ? 'checked' : '' }}>
                                    <label for="amount_type_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('amount_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.amount_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.commissionRule.fields.amount') }}</label>
                            <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.00001" required>
                            @if($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="wallet_type_id">{{ trans('cruds.commissionRule.fields.wallet_type') }}</label>
                            <select class="form-control select2" name="wallet_type_id" id="wallet_type_id" required>
                                @foreach($wallet_types as $id => $entry)
                                    <option value="{{ $id }}" {{ old('wallet_type_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('wallet_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.wallet_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="wallet_reference_id">{{ trans('cruds.commissionRule.fields.wallet_reference') }}</label>
                            <select class="form-control select2" name="wallet_reference_id" id="wallet_reference_id" required>
                                @foreach($wallet_references as $id => $entry)
                                    <option value="{{ $id }}" {{ old('wallet_reference_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('wallet_reference'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_reference') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.wallet_reference_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="denomination_id">{{ trans('cruds.commissionRule.fields.denomination') }}</label>
                            <select class="form-control select2" name="denomination_id" id="denomination_id" required>
                                @foreach($denominations as $id => $entry)
                                    <option value="{{ $id }}" {{ old('denomination_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('denomination'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('denomination') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.denomination_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.commissionRule.fields.wallet_status') }}</label>
                            @foreach(App\Models\CommissionRule::WALLET_STATUS_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="wallet_status_{{ $key }}" name="wallet_status" value="{{ $key }}" {{ old('wallet_status', '') === (string) $key ? 'checked' : '' }}>
                                    <label for="wallet_status_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('wallet_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.wallet_status_helper') }}</span>
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