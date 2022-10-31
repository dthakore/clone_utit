@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.walletMetaType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wallet-meta-types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="reference_key">{{ trans('cruds.walletMetaType.fields.reference_key') }}</label>
                            <input class="form-control {{ $errors->has('reference_key') ? 'is-invalid' : '' }}" type="text" name="reference_key" id="reference_key" value="{{ old('reference_key', '') }}" required>
                            @if($errors->has('reference_key'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_key') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.walletMetaType.fields.reference_key_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="reference_desc">{{ trans('cruds.walletMetaType.fields.reference_desc') }}</label>
                            <input class="form-control {{ $errors->has('reference_desc') ? 'is-invalid' : '' }}" type="text" name="reference_desc" id="reference_desc" value="{{ old('reference_desc', '') }}" required>
                            @if($errors->has('reference_desc'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_desc') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.walletMetaType.fields.reference_desc_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="reference_data">{{ trans('cruds.walletMetaType.fields.reference_data') }}</label>
                            <input class="form-control {{ $errors->has('reference_data') ? 'is-invalid' : '' }}" type="text" name="reference_data" id="reference_data" value="{{ old('reference_data', '') }}" required>
                            @if($errors->has('reference_data'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_data') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.walletMetaType.fields.reference_data_helper') }}</span>
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