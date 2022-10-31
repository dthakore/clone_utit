@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.shipmentInfo.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.shipment-infos.update", [$shipmentInfo->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="order">{{ trans('cruds.shipmentInfo.fields.order') }}</label>
                            <input class="form-control" type="text" name="order" id="order" value="{{ old('order', $shipmentInfo->order) }}">
                            @if($errors->has('order'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('order') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shipmentInfo.fields.order_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="shipment_number">{{ trans('cruds.shipmentInfo.fields.shipment_number') }}</label>
                            <input class="form-control" type="text" name="shipment_number" id="shipment_number" value="{{ old('shipment_number', $shipmentInfo->shipment_number) }}">
                            @if($errors->has('shipment_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('shipment_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shipmentInfo.fields.shipment_number_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="products">{{ trans('cruds.shipmentInfo.fields.product') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="products[]" id="products" multiple>
                                @foreach($products as $id => $product)
                                    <option value="{{ $id }}" {{ (in_array($id, old('products', [])) || $shipmentInfo->products->contains($id)) ? 'selected' : '' }}>{{ $product }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('products'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('products') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shipmentInfo.fields.product_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="tracking_number">{{ trans('cruds.shipmentInfo.fields.tracking_number') }}</label>
                            <input class="form-control" type="text" name="tracking_number" id="tracking_number" value="{{ old('tracking_number', $shipmentInfo->tracking_number) }}">
                            @if($errors->has('tracking_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tracking_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shipmentInfo.fields.tracking_number_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.shipmentInfo.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\ShipmentInfo::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $shipmentInfo->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.shipmentInfo.fields.status_helper') }}</span>
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