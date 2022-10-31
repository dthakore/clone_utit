@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cover.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.covers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bot_id">{{ trans('cruds.cover.fields.bot') }}</label>
                            <select class="form-control select2 {{ $errors->has('bot') ? 'is-invalid' : '' }}" name="bot_id" id="bot_id">
                                @foreach($bots as $id => $entry)
                                    <option value="{{ $id }}" {{ old('bot_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bot'))
                                <span class="text-danger">{{ $errors->first('bot') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.bot_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="index">{{ trans('cruds.cover.fields.index') }}</label>
                            <input class="form-control {{ $errors->has('index') ? 'is-invalid' : '' }}" type="number" name="index" id="index" value="{{ old('index', '') }}" step="1">
                            @if($errors->has('index'))
                                <span class="text-danger">{{ $errors->first('index') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.index_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cover_percentage">{{ trans('cruds.cover.fields.cover_percentage') }}</label>
                            <input class="form-control {{ $errors->has('cover_percentage') ? 'is-invalid' : '' }}" type="number" name="cover_percentage" id="cover_percentage" value="{{ old('cover_percentage', '0') }}" step="0.01" min="-100">
                            @if($errors->has('cover_percentage'))
                                <span class="text-danger">{{ $errors->first('cover_percentage') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.cover_percentage_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="buy_x_times">{{ trans('cruds.cover.fields.buy_x_times') }}</label>
                            <input class="form-control {{ $errors->has('buy_x_times') ? 'is-invalid' : '' }}" type="number" name="buy_x_times" id="buy_x_times" value="{{ old('buy_x_times', '1') }}" step="1">
                            @if($errors->has('buy_x_times'))
                                <span class="text-danger">{{ $errors->first('buy_x_times') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.buy_x_times_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cover_pullback">{{ trans('cruds.cover.fields.cover_pullback') }}</label>
                            <input class="form-control {{ $errors->has('cover_pullback') ? 'is-invalid' : '' }}" type="number" name="cover_pullback" id="cover_pullback" value="{{ old('cover_pullback', '0') }}" step="0.01" max="100">
                            @if($errors->has('cover_pullback'))
                                <span class="text-danger">{{ $errors->first('cover_pullback') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.cover_pullback_helper') }}</span>
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