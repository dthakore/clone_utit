@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rankRule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.rankRules.store") }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="rank_id">{{ trans('cruds.rankRule.fields.rank') }}</label>
                            <select class="form-control select2 {{ $errors->has('rank_id') ? 'is-invalid' : '' }}" name="rank_id" id="rank_id" required>
                                @foreach($ranks as $id => $entry)
                                    <option value="{{ $id }}" {{ old('rank_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('rank_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('rank_id') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.rankRule.fields.rank_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="key">{{ trans('cruds.rankRule.fields.key') }}</label>
                            <input class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" type="text" name="key" id="key" value="{{ old('key', '') }}" required autocomplete="off">
                            @if($errors->has('key'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('key') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.rankRule.fields.key_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="value">{{ trans('cruds.rankRule.fields.value') }}</label>
                            <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', '') }}" required autocomplete="off">
                            @if($errors->has('value'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('value') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.rankRule.fields.value_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comment">{{ trans('cruds.rankRule.fields.comment') }}</label>
                            <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment">{{ old('comment') }}</textarea>
                            @if($errors->has('comment'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('comment') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.rankRule.fields.comment_helper') }}</span>
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