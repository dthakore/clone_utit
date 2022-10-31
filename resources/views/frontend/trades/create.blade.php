@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.trade.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.trades.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="bot_id">{{ trans('cruds.trade.fields.bot') }}</label>
                            <select class="form-control select2" name="bot_id" id="bot_id" required>
                                @foreach($bots as $id => $entry)
                                    <option value="{{ $id }}" {{ old('bot_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bot'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bot') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.bot_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="session_id">{{ trans('cruds.trade.fields.session') }}</label>
                            <select class="form-control select2" name="session_id" id="session_id">
                                @foreach($sessions as $id => $entry)
                                    <option value="{{ $id }}" {{ old('session_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('session'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('session') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.session_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="symbol_id">{{ trans('cruds.trade.fields.symbol') }}</label>
                            <select class="form-control select2" name="symbol_id" id="symbol_id">
                                @foreach($symbols as $id => $entry)
                                    <option value="{{ $id }}" {{ old('symbol_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('symbol'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('symbol') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.symbol_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="user_id">{{ trans('cruds.trade.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id">
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="requested_amount">{{ trans('cruds.trade.fields.requested_amount') }}</label>
                            <input class="form-control" type="number" name="requested_amount" id="requested_amount" value="{{ old('requested_amount', '0') }}" step="0.000001" required>
                            @if($errors->has('requested_amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('requested_amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.requested_amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.trade.fields.side') }}</label>
                            <select class="form-control" name="side" id="side" required>
                                <option value disabled {{ old('side', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Trade::SIDE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('side', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('side'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('side') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.side_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="comment">{{ trans('cruds.trade.fields.comment') }}</label>
                            <input class="form-control" type="text" name="comment" id="comment" value="{{ old('comment', '') }}">
                            @if($errors->has('comment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('comment') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.comment_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="failure_reason">{{ trans('cruds.trade.fields.failure_reason') }}</label>
                            <input class="form-control" type="text" name="failure_reason" id="failure_reason" value="{{ old('failure_reason', '') }}">
                            @if($errors->has('failure_reason'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('failure_reason') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.failure_reason_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="exchange_order_status">{{ trans('cruds.trade.fields.exchange_order_status') }}</label>
                            <input class="form-control" type="text" name="exchange_order_status" id="exchange_order_status" value="{{ old('exchange_order_status', 'NA') }}">
                            @if($errors->has('exchange_order_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exchange_order_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.exchange_order_status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="original_orders">{{ trans('cruds.trade.fields.original_orders') }}</label>
                            <input class="form-control" type="text" name="original_orders" id="original_orders" value="{{ old('original_orders', '') }}">
                            @if($errors->has('original_orders'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('original_orders') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.original_orders_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="exchange_order_ref">{{ trans('cruds.trade.fields.exchange_order_ref') }}</label>
                            <input class="form-control" type="text" name="exchange_order_ref" id="exchange_order_ref" value="{{ old('exchange_order_ref', '') }}">
                            @if($errors->has('exchange_order_ref'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exchange_order_ref') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.exchange_order_ref_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="exchange_trade_ref">{{ trans('cruds.trade.fields.exchange_trade_ref') }}</label>
                            <input class="form-control" type="text" name="exchange_trade_ref" id="exchange_trade_ref" value="{{ old('exchange_trade_ref', '') }}">
                            @if($errors->has('exchange_trade_ref'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('exchange_trade_ref') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.exchange_trade_ref_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="requested_price">{{ trans('cruds.trade.fields.requested_price') }}</label>
                            <input class="form-control" type="number" name="requested_price" id="requested_price" value="{{ old('requested_price', '') }}" step="0.000001" required>
                            @if($errors->has('requested_price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('requested_price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.requested_price_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="requested_quantity">{{ trans('cruds.trade.fields.requested_quantity') }}</label>
                            <input class="form-control" type="number" name="requested_quantity" id="requested_quantity" value="{{ old('requested_quantity', '') }}" step="0.000001" required>
                            @if($errors->has('requested_quantity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('requested_quantity') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.requested_quantity_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="executed_price">{{ trans('cruds.trade.fields.executed_price') }}</label>
                            <input class="form-control" type="number" name="executed_price" id="executed_price" value="{{ old('executed_price', '') }}" step="0.000001" required>
                            @if($errors->has('executed_price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('executed_price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.executed_price_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="executed_amount">{{ trans('cruds.trade.fields.executed_amount') }}</label>
                            <input class="form-control" type="number" name="executed_amount" id="executed_amount" value="{{ old('executed_amount', '') }}" step="0.000001" required>
                            @if($errors->has('executed_amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('executed_amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.executed_amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="executed_quantity">{{ trans('cruds.trade.fields.executed_quantity') }}</label>
                            <input class="form-control" type="number" name="executed_quantity" id="executed_quantity" value="{{ old('executed_quantity', '') }}" step="0.000001" required>
                            @if($errors->has('executed_quantity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('executed_quantity') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.executed_quantity_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">{{ trans('cruds.trade.fields.cover') }}</label>
                            <select class="form-control select2" name="cover_id" id="cover_id">
                                @foreach($covers as $id => $entry)
                                    <option value="{{ $id }}" {{ old('cover_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('cover'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cover') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.cover_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="status">{{ trans('cruds.trade.fields.status') }}</label>
                            <input class="form-control" type="number" name="status" id="status" value="{{ old('status', '0') }}" step="1" required>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.trade.fields.status_helper') }}</span>
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