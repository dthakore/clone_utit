@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.denomination.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.denominations.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="denomination_type">{{ trans('cruds.denomination.fields.denomination_type') }}</label>
                            <input class="form-control" type="text" name="denomination_type" id="denomination_type" value="{{ old('denomination_type', '') }}" required>
                            @if($errors->has('denomination_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('denomination_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.denomination.fields.denomination_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="sub_type">{{ trans('cruds.denomination.fields.sub_type') }}</label>
                            <input class="form-control" type="text" name="sub_type" id="sub_type" value="{{ old('sub_type', '') }}" required>
                            @if($errors->has('sub_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sub_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.denomination.fields.sub_type_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="label">{{ trans('cruds.denomination.fields.label') }}</label>
                            <input class="form-control" type="text" name="label" id="label" value="{{ old('label', '') }}" required>
                            @if($errors->has('label'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('label') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.denomination.fields.label_helper') }}</span>
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