@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.mtFourTrade.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.mt-four-trades.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="commission">{{ trans('cruds.mtFourTrade.fields.commission') }}</label>
                            <input class="form-control" type="number" name="commission" id="commission" value="{{ old('commission', '') }}" step="0.00001">
                            @if($errors->has('commission'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('commission') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourTrade.fields.commission_helper') }}</span>
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