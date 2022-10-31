@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.session.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.sessions.update", [$session->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="bot_id">{{ trans('cruds.session.fields.bot') }}</label>
                            <select class="form-control select2" name="bot_id" id="bot_id" required>
                                @foreach($bots as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('bot_id') ? old('bot_id') : $session->bot->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bot'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bot') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.bot_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.session.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $session->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.session.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Session::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $session->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="lowest">{{ trans('cruds.session.fields.lowest') }}</label>
                            <input class="form-control" type="number" name="lowest" id="lowest" value="{{ old('lowest', $session->lowest) }}" step="0.01">
                            @if($errors->has('lowest'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('lowest') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.lowest_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="highest">{{ trans('cruds.session.fields.highest') }}</label>
                            <input class="form-control" type="number" name="highest" id="highest" value="{{ old('highest', $session->highest) }}" step="0.01">
                            @if($errors->has('highest'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('highest') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.highest_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="last_buy">{{ trans('cruds.session.fields.last_buy') }}</label>
                            <input class="form-control" type="number" name="last_buy" id="last_buy" value="{{ old('last_buy', $session->last_buy) }}" step="0.01">
                            @if($errors->has('last_buy'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('last_buy') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.last_buy_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="average_buy">{{ trans('cruds.session.fields.average_buy') }}</label>
                            <input class="form-control" type="number" name="average_buy" id="average_buy" value="{{ old('average_buy', $session->average_buy) }}" step="0.01">
                            @if($errors->has('average_buy'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('average_buy') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.average_buy_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="total_buy">{{ trans('cruds.session.fields.total_buy') }}</label>
                            <input class="form-control" type="number" name="total_buy" id="total_buy" value="{{ old('total_buy', $session->total_buy) }}" step="1">
                            @if($errors->has('total_buy'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_buy') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.total_buy_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cover">{{ trans('cruds.session.fields.cover') }}</label>
                            <input class="form-control" type="number" name="cover" id="cover" value="{{ old('cover', $session->cover) }}" step="1">
                            @if($errors->has('cover'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cover') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.cover_helper') }}</span>
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