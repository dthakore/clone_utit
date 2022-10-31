@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.denomination.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.denominations.update", [$denomination->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="denomination_type">{{ trans('cruds.denomination.fields.denomination_type') }}</label>
                            <input class="form-control {{ $errors->has('denomination_type') ? 'is-invalid' : '' }}" type="text" name="denomination_type" id="denomination_type" value="{{ old('denomination_type', $denomination->denomination_type) }}" required>
                            @if($errors->has('denomination_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('denomination_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.denomination.fields.denomination_type_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="sub_type">{{ trans('cruds.denomination.fields.sub_type') }}</label>
                            <input class="form-control {{ $errors->has('sub_type') ? 'is-invalid' : '' }}" type="text" name="sub_type" id="sub_type" value="{{ old('sub_type', $denomination->sub_type) }}" required>
                            @if($errors->has('sub_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sub_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.denomination.fields.sub_type_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="label">{{ trans('cruds.denomination.fields.label') }}</label>
                            <input class="form-control {{ $errors->has('label') ? 'is-invalid' : '' }}" type="text" name="label" id="label" value="{{ old('label', $denomination->label) }}" required>
                            @if($errors->has('label'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('label') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.denomination.fields.label_helper') }}</span>
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