@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.cover.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.covers.update", [$cover->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="bot_id">{{ trans('cruds.cover.fields.bot') }}</label>
                            <select class="form-control select2" name="bot_id" id="bot_id">
                                @foreach($bots as $id => $entry)
                                    <option value="{{ $id }}" {{ (old('bot_id') ? old('bot_id') : $cover->bot->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bot'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bot') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.bot_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="index">{{ trans('cruds.cover.fields.index') }}</label>
                            <input class="form-control" type="number" name="index" id="index" value="{{ old('index', $cover->index) }}" step="1">
                            @if($errors->has('index'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('index') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.index_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cover_percentage">{{ trans('cruds.cover.fields.cover_percentage') }}</label>
                            <input class="form-control" type="number" name="cover_percentage" id="cover_percentage" value="{{ old('cover_percentage', $cover->cover_percentage) }}" step="0.01" min="-100">
                            @if($errors->has('cover_percentage'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cover_percentage') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.cover_percentage_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="buy_x_times">{{ trans('cruds.cover.fields.buy_x_times') }}</label>
                            <input class="form-control" type="number" name="buy_x_times" id="buy_x_times" value="{{ old('buy_x_times', $cover->buy_x_times) }}" step="1">
                            @if($errors->has('buy_x_times'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('buy_x_times') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.buy_x_times_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="cover_pullback">{{ trans('cruds.cover.fields.cover_pullback') }}</label>
                            <input class="form-control" type="number" name="cover_pullback" id="cover_pullback" value="{{ old('cover_pullback', $cover->cover_pullback) }}" step="0.01" max="100">
                            @if($errors->has('cover_pullback'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cover_pullback') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.cover.fields.cover_pullback_helper') }}</span>
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