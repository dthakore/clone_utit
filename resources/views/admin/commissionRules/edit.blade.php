@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.commissionRule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.commission-rules.update", [$commissionRule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="commission_plan_id">{{ trans('cruds.commissionRule.fields.commission_plan') }}</label>
                            <select class="form-control select2 {{ $errors->has('commission_plan') ? 'is-invalid' : '' }}" name="commission_plan_id" id="commission_plan_id" required>
                                @foreach($commission_plans as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('commission_plan_id') ? old('commission_plan_id') : $commissionRule->commission_plan->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('commission_plan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('commission_plan') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.commission_plan_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.commissionRule.fields.user_level') }}</label>
                            <select class="form-control {{ $errors->has('user_level') ? 'is-invalid' : '' }}" name="user_level" id="user_level" required>
                                <option value disabled {{ old('user_level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\CommissionRule::USER_LEVEL_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('user_level', $commissionRule->user_level) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user_level'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user_level') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.user_level_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="rank_id">{{ trans('cruds.commissionRule.fields.rank') }}</label>
                            <select class="form-control select2 {{ $errors->has('rank') ? 'is-invalid' : '' }}" name="rank_id" id="rank_id" required>
                                @foreach($ranks as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('rank_id') ? old('rank_id') : $commissionRule->rank->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('rank'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('rank') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.rank_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product_id">{{ trans('cruds.commissionRule.fields.product') }}</label>
                            <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id">
                                @foreach($products as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('product_id') ? old('product_id') : $commissionRule->product->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('product'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.product_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_id">{{ trans('cruds.commissionRule.fields.category') }}</label>
                            <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                                @foreach($categories as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $commissionRule->category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.category_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.commissionRule.fields.amount_type') }}</label>
                            @foreach(App\Models\CommissionRule::AMOUNT_TYPE_RADIO as $key => $label)
                                <div class="form-check {{ $errors->has('amount_type') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="amount_type_{{ $key }}" name="amount_type" value="{{ $key }}" {{ old('amount_type', $commissionRule->amount_type) === (string) $key ? 'checked' : '' }}>
                                    <label class="form-check-label" for="amount_type_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('amount_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.amount_type_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.commissionRule.fields.amount') }}</label>
                            <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $commissionRule->amount) }}" step="0.00001" required>
                            @if($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.amount_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="wallet_type_id">{{ trans('cruds.commissionRule.fields.wallet_type') }}</label>
                            <select class="form-control select2 {{ $errors->has('wallet_type') ? 'is-invalid' : '' }}" name="wallet_type_id" id="wallet_type_id" required>
                                @foreach($wallet_types as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('wallet_type_id') ? old('wallet_type_id') : $commissionRule->wallet_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('wallet_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.wallet_type_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="wallet_reference_id">{{ trans('cruds.commissionRule.fields.wallet_reference') }}</label>
                            <select class="form-control select2 {{ $errors->has('wallet_reference') ? 'is-invalid' : '' }}" name="wallet_reference_id" id="wallet_reference_id" required>
                                @foreach($wallet_references as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('wallet_reference_id') ? old('wallet_reference_id') : $commissionRule->wallet_reference->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('wallet_reference'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_reference') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.wallet_reference_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="denomination_id">{{ trans('cruds.commissionRule.fields.denomination') }}</label>
                            <select class="form-control select2 {{ $errors->has('denomination') ? 'is-invalid' : '' }}" name="denomination_id" id="denomination_id" required>
                                @foreach($denominations as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('denomination_id') ? old('denomination_id') : $commissionRule->denomination->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('denomination'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('denomination') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.denomination_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.commissionRule.fields.wallet_status') }}</label>
                            @foreach(App\Models\CommissionRule::WALLET_STATUS_RADIO as $key => $label)
                                <div class="form-check {{ $errors->has('wallet_status') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="wallet_status_{{ $key }}" name="wallet_status" value="{{ $key }}" {{ old('wallet_status', $commissionRule->wallet_status) === (string) $key ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wallet_status_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('wallet_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.commissionRule.fields.wallet_status_helper') }}</span>
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