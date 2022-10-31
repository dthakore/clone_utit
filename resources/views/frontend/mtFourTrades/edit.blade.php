@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.mtFourTrade.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.mt-four-trades.update", [$mtFourTrade->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="close_price">{{ trans('cruds.mtFourTrade.fields.close_price') }}</label>
                            <input class="form-control" type="number" name="close_price" id="close_price" value="{{ old('close_price', $mtFourTrade->close_price) }}" step="0.00001">
                            @if($errors->has('close_price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('close_price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.mtFourTrade.fields.close_price_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="commission">{{ trans('cruds.mtFourTrade.fields.commission') }}</label>
                            <input class="form-control" type="number" name="commission" id="commission" value="{{ old('commission', $mtFourTrade->commission) }}" step="0.00001">
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