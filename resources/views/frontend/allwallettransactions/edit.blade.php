@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.allwallettransaction.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.allwallettransactions.update", [$allwallettransaction->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.allwallettransaction.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $allwallettransaction->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="wallet_type_id">{{ trans('cruds.allwallettransaction.fields.wallet_type') }}</label>
                            <select class="form-control select2" name="wallet_type_id" id="wallet_type_id" required>
                                @foreach($wallet_types as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('wallet_type_id') ? old('wallet_type_id') : $allwallettransaction->wallet_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('wallet_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.wallet_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.allwallettransaction.fields.transaction_type') }}</label>
                            <select class="form-control" name="transaction_type" id="transaction_type">
                                <option value disabled {{ old('transaction_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Allwallettransaction::TRANSACTION_TYPE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('transaction_type', $allwallettransaction->transaction_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('transaction_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('transaction_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.transaction_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="reference_id">{{ trans('cruds.allwallettransaction.fields.reference') }}</label>
                            <select class="form-control select2" name="reference_id" id="reference_id" required>
                                @foreach($references as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('reference_id') ? old('reference_id') : $allwallettransaction->reference->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('reference'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.reference_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="reference_num">{{ trans('cruds.allwallettransaction.fields.reference_num') }}</label>
                            <input class="form-control" type="text" name="reference_num" id="reference_num" value="{{ old('reference_num', $allwallettransaction->reference_num) }}" required>
                            @if($errors->has('reference_num'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_num') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.reference_num_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="transaction_comment">{{ trans('cruds.allwallettransaction.fields.transaction_comment') }}</label>
                            <textarea class="form-control" name="transaction_comment" id="transaction_comment">{{ old('transaction_comment', $allwallettransaction->transaction_comment) }}</textarea>
                            @if($errors->has('transaction_comment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('transaction_comment') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.transaction_comment_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="denomination_id">{{ trans('cruds.allwallettransaction.fields.denomination') }}</label>
                            <select class="form-control select2" name="denomination_id" id="denomination_id" required>
                                @foreach($denominations as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('denomination_id') ? old('denomination_id') : $allwallettransaction->denomination->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('denomination'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('denomination') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.denomination_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.allwallettransaction.fields.transaction_status') }}</label>
                            <select class="form-control" name="transaction_status" id="transaction_status">
                                <option value disabled {{ old('transaction_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Allwallettransaction::TRANSACTION_STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('transaction_status', $allwallettransaction->transaction_status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('transaction_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('transaction_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.transaction_status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.allwallettransaction.fields.amount') }}</label>
                            <input class="form-control" type="number" name="amount" id="amount" value="{{ old('amount', $allwallettransaction->amount) }}" step="0.01" required>
                            @if($errors->has('amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.allwallettransaction.fields.amount_helper') }}</span>
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