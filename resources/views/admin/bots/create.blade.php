@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bot.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bots.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">{{ trans('cruds.bot.fields.title') }}</label>
                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.title_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.bot.fields.user') }}</label>
                            <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <span class="text-danger">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.user_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="user_exchange_id">{{ trans('cruds.bot.fields.user_exchange') }}</label>
                            <select class="form-control select2 {{ $errors->has('user_exchange') ? 'is-invalid' : '' }}" name="user_exchange_id" id="user_exchange_id" required>
                                @foreach($user_exchanges as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_exchange_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user_exchange'))
                                <span class="text-danger">{{ $errors->first('user_exchange') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.user_exchange_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="symbol_id">{{ trans('cruds.bot.fields.symbol') }}</label>
                            <select class="form-control select2 {{ $errors->has('symbol') ? 'is-invalid' : '' }}" name="symbol_id" id="symbol_id" required>
                                @foreach($symbols as $id => $entry)
                                    <option value="{{ $id }}" {{ old('symbol_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('symbol'))
                                <span class="text-danger">{{ $errors->first('symbol') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.symbol_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="balance">{{ trans('cruds.bot.fields.balance') }}</label>
                            <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="number" name="balance" id="balance" value="{{ old('balance', '1000') }}" step="0.01" required>
                            @if($errors->has('balance'))
                                <span class="text-danger">{{ $errors->first('balance') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.balance_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="init_amount">{{ trans('cruds.bot.fields.init_amount') }}</label>
                            <input class="form-control {{ $errors->has('init_amount') ? 'is-invalid' : '' }}" type="number" name="init_amount" id="init_amount" value="{{ old('init_amount', '20') }}" step="0.01" required min="5">
                            @if($errors->has('init_amount'))
                                <span class="text-danger">{{ $errors->first('init_amount') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.init_amount_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('is_cycle') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="is_cycle" value="0">
                                <input class="form-check-input" type="checkbox" name="is_cycle" id="is_cycle" value="1" {{ old('is_cycle', 0) == 1 || old('is_cycle') === null ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_cycle">{{ trans('cruds.bot.fields.is_cycle') }}</label>
                            </div>
                            @if($errors->has('is_cycle'))
                                <span class="text-danger">{{ $errors->first('is_cycle') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.is_cycle_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('init_immediate') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="init_immediate" value="0">
                                <input class="form-check-input" type="checkbox" name="init_immediate" id="init_immediate" value="1" {{ old('init_immediate', 0) == 1 || old('init_immediate') === null ? 'checked' : '' }}>
                                <label class="form-check-label" for="init_immediate">{{ trans('cruds.bot.fields.init_immediate') }}</label>
                            </div>
                            @if($errors->has('init_immediate'))
                                <span class="text-danger">{{ $errors->first('init_immediate') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.init_immediate_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="init_buy_at">{{ trans('cruds.bot.fields.init_buy_at') }}</label>
                            <input class="form-control {{ $errors->has('init_buy_at') ? 'is-invalid' : '' }}" type="number" name="init_buy_at" id="init_buy_at" value="{{ old('init_buy_at', '-1.5') }}" step="0.01">
                            @if($errors->has('init_buy_at'))
                                <span class="text-danger">{{ $errors->first('init_buy_at') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.init_buy_at_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="init_pullback">{{ trans('cruds.bot.fields.init_pullback') }}</label>
                            <input class="form-control {{ $errors->has('init_pullback') ? 'is-invalid' : '' }}" type="number" name="init_pullback" id="init_pullback" value="{{ old('init_pullback', '0.5') }}" step="0.01">
                            @if($errors->has('init_pullback'))
                                <span class="text-danger">{{ $errors->first('init_pullback') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.init_pullback_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="take_profit_average_percentage">{{ trans('cruds.bot.fields.take_profit_average_percentage') }}</label>
                            <input class="form-control {{ $errors->has('take_profit_average_percentage') ? 'is-invalid' : '' }}" type="number" name="take_profit_average_percentage" id="take_profit_average_percentage" value="{{ old('take_profit_average_percentage', '1.5') }}" step="0.01" required max="100">
                            @if($errors->has('take_profit_average_percentage'))
                                <span class="text-danger">{{ $errors->first('take_profit_average_percentage') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.take_profit_average_percentage_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="take_profit_average_retracement">{{ trans('cruds.bot.fields.take_profit_average_retracement') }}</label>
                            <input class="form-control {{ $errors->has('take_profit_average_retracement') ? 'is-invalid' : '' }}" type="number" name="take_profit_average_retracement" id="take_profit_average_retracement" value="{{ old('take_profit_average_retracement', '-0.5') }}" step="0.01" required min="-100">
                            @if($errors->has('take_profit_average_retracement'))
                                <span class="text-danger">{{ $errors->first('take_profit_average_retracement') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.take_profit_average_retracement_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="take_profit_independent_cover">{{ trans('cruds.bot.fields.take_profit_independent_cover') }}</label>
                            <input class="form-control {{ $errors->has('take_profit_independent_cover') ? 'is-invalid' : '' }}" type="number" name="take_profit_independent_cover" id="take_profit_independent_cover" value="{{ old('take_profit_independent_cover', '0') }}" step="1" required>
                            @if($errors->has('take_profit_independent_cover'))
                                <span class="text-danger">{{ $errors->first('take_profit_independent_cover') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.take_profit_independent_cover_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="take_profit_independent_percentage">{{ trans('cruds.bot.fields.take_profit_independent_percentage') }}</label>
                            <input class="form-control {{ $errors->has('take_profit_independent_percentage') ? 'is-invalid' : '' }}" type="number" name="take_profit_independent_percentage" id="take_profit_independent_percentage" value="{{ old('take_profit_independent_percentage', '1.5') }}" step="0.01" max="100">
                            @if($errors->has('take_profit_independent_percentage'))
                                <span class="text-danger">{{ $errors->first('take_profit_independent_percentage') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.take_profit_independent_percentage_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="take_profit_independent_retracement">{{ trans('cruds.bot.fields.take_profit_independent_retracement') }}</label>
                            <input class="form-control {{ $errors->has('take_profit_independent_retracement') ? 'is-invalid' : '' }}" type="number" name="take_profit_independent_retracement" id="take_profit_independent_retracement" value="{{ old('take_profit_independent_retracement', '-0.5') }}" step="0.01" min="-100">
                            @if($errors->has('take_profit_independent_retracement'))
                                <span class="text-danger">{{ $errors->first('take_profit_independent_retracement') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.take_profit_independent_retracement_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="active_sessions">{{ trans('cruds.bot.fields.active_session') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2 {{ $errors->has('active_sessions') ? 'is-invalid' : '' }}" name="active_sessions[]" id="active_sessions" multiple>
                                @foreach($active_sessions as $id => $active_session)
                                    <option value="{{ $id }}" {{ in_array($id, old('active_sessions', [])) ? 'selected' : '' }}>{{ $active_session }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('active_sessions'))
                                <span class="text-danger">{{ $errors->first('active_sessions') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.active_session_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 0) == 1 || old('status') === null ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">{{ trans('cruds.bot.fields.status') }}</label>
                            </div>
                            @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.bot.fields.status_helper') }}</span>
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
