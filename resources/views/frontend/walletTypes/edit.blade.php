@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.walletType.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.wallet-types.update", [$walletType->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="wallet_type">{{ trans('cruds.walletType.fields.wallet_type') }}</label>
                            <input class="form-control" type="text" name="wallet_type" id="wallet_type" value="{{ old('wallet_type', $walletType->wallet_type) }}" required>
                            @if($errors->has('wallet_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('wallet_type') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.walletType.fields.wallet_type_helper') }}</span>
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