@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.session.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sessions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="bot_id">{{ trans('cruds.session.fields.bot') }}</label>
                            <select class="form-control select2 {{ $errors->has('bot') ? 'is-invalid' : '' }}" name="bot_id" id="bot_id" required>
                                @foreach($bots as $id => $entry)
                                    <option value="{{ $id }}" {{ old('bot_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bot'))
                                <span class="text-danger">{{ $errors->first('bot') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.bot_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.session.fields.user') }}</label>
                            <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <span class="text-danger">{{ $errors->first('user') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.user_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.session.fields.status') }}</label>
                            <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Session::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.status_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lowest">{{ trans('cruds.session.fields.lowest') }}</label>
                            <input class="form-control {{ $errors->has('lowest') ? 'is-invalid' : '' }}" type="number" name="lowest" id="lowest" value="{{ old('lowest', '') }}" step="0.01">
                            @if($errors->has('lowest'))
                                <span class="text-danger">{{ $errors->first('lowest') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.lowest_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="highest">{{ trans('cruds.session.fields.highest') }}</label>
                            <input class="form-control {{ $errors->has('highest') ? 'is-invalid' : '' }}" type="number" name="highest" id="highest" value="{{ old('highest', '0') }}" step="0.01">
                            @if($errors->has('highest'))
                                <span class="text-danger">{{ $errors->first('highest') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.highest_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="last_buy">{{ trans('cruds.session.fields.last_buy') }}</label>
                            <input class="form-control {{ $errors->has('last_buy') ? 'is-invalid' : '' }}" type="number" name="last_buy" id="last_buy" value="{{ old('last_buy', '0') }}" step="0.01">
                            @if($errors->has('last_buy'))
                                <span class="text-danger">{{ $errors->first('last_buy') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.last_buy_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="average_buy">{{ trans('cruds.session.fields.average_buy') }}</label>
                            <input class="form-control {{ $errors->has('average_buy') ? 'is-invalid' : '' }}" type="number" name="average_buy" id="average_buy" value="{{ old('average_buy', '') }}" step="0.01">
                            @if($errors->has('average_buy'))
                                <span class="text-danger">{{ $errors->first('average_buy') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.average_buy_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="total_buy">{{ trans('cruds.session.fields.total_buy') }}</label>
                            <input class="form-control {{ $errors->has('total_buy') ? 'is-invalid' : '' }}" type="number" name="total_buy" id="total_buy" value="{{ old('total_buy', '0') }}" step="1">
                            @if($errors->has('total_buy'))
                                <span class="text-danger">{{ $errors->first('total_buy') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.total_buy_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cover">{{ trans('cruds.session.fields.cover') }}</label>
                            <input class="form-control {{ $errors->has('cover') ? 'is-invalid' : '' }}" type="number" name="cover" id="cover" value="{{ old('cover', '0') }}" step="1">
                            @if($errors->has('cover'))
                                <span class="text-danger">{{ $errors->first('cover') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.session.fields.cover_helper') }}</span>
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