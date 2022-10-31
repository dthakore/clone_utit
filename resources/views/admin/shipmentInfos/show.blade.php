@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.shipmentInfo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shipment-infos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.id') }}
                        </th>
                        <td>
                            {{ $shipmentInfo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.order') }}
                        </th>
                        <td>
                            {{ $shipmentInfo->order }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.shipment_number') }}
                        </th>
                        <td>
                            {{ $shipmentInfo->shipment_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.product') }}
                        </th>
                        <td>
                            @foreach($shipmentInfo->products as $key => $product)
                                <span class="label label-info">{{ $product->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.tracking_number') }}
                        </th>
                        <td>
                            {{ $shipmentInfo->tracking_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\ShipmentInfo::STATUS_SELECT[$shipmentInfo->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.created_at') }}
                        </th>
                        <td>
                            {{ $shipmentInfo->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.shipmentInfo.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $shipmentInfo->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.shipment-infos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection