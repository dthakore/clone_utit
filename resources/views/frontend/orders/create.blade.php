@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.orders.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id" required>
                                @foreach($users as $id => $entry)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="vat">{{ trans('cruds.order.fields.vat') }}</label>
                            <input class="form-control" type="text" name="vat" id="vat" value="{{ old('vat', '') }}">
                            @if($errors->has('vat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vat') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.vat_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.order.fields.order_status') }}</label>
                            <select class="form-control" name="order_status" id="order_status">
                                <option value disabled {{ old('order_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Order::ORDER_STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('order_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('order_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('order_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.order_status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="building">{{ trans('cruds.order.fields.building') }}</label>
                            <input class="form-control" type="text" name="building" id="building" value="{{ old('building', '') }}">
                            @if($errors->has('building'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('building') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.building_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="street">{{ trans('cruds.order.fields.street') }}</label>
                            <input class="form-control" type="text" name="street" id="street" value="{{ old('street', '') }}">
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.street_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="region">{{ trans('cruds.order.fields.region') }}</label>
                            <input class="form-control" type="text" name="region" id="region" value="{{ old('region', '') }}">
                            @if($errors->has('region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('region') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.region_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="postcode">{{ trans('cruds.order.fields.postcode') }}</label>
                            <input class="form-control" type="text" name="postcode" id="postcode" value="{{ old('postcode', '') }}" required>
                            @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.postcode_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.order.fields.city') }}</label>
                            <input class="form-control" type="text" name="city" id="city" value="{{ old('city', '') }}" required>
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="country_id">{{ trans('cruds.order.fields.country') }}</label>
                            <select class="form-control select2" name="country_id" id="country_id" required>
                                @foreach($countries as $id => $entry)
                                    <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.country_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="products">{{ trans('cruds.order.fields.product') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="products[]" id="products" multiple required>
                                @foreach($products as $id => $product)
                                    <option value="{{ $id }}" {{ in_array($id, old('products', [])) ? 'selected' : '' }}>{{ $product }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('products'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('products') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.product_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="order_total">{{ trans('cruds.order.fields.order_total') }}</label>
                            <input class="form-control" type="number" name="order_total" id="order_total" value="{{ old('order_total', '') }}" step="0.01" required>
                            @if($errors->has('order_total'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('order_total') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.order_total_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="discount">{{ trans('cruds.order.fields.discount') }}</label>
                            <input class="form-control" type="text" name="discount" id="discount" value="{{ old('discount', '') }}">
                            @if($errors->has('discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('discount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.discount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="net_total">{{ trans('cruds.order.fields.net_total') }}</label>
                            <input class="form-control" type="text" name="net_total" id="net_total" value="{{ old('net_total', '') }}" required>
                            @if($errors->has('net_total'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('net_total') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.order.fields.net_total_helper') }}</span>
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