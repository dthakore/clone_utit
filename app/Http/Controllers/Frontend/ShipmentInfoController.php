<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShipmentInfoRequest;
use App\Http\Requests\StoreShipmentInfoRequest;
use App\Http\Requests\UpdateShipmentInfoRequest;
use App\Models\Product;
use App\Models\ShipmentInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShipmentInfoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shipment_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shipmentInfos = ShipmentInfo::with(['products'])->get();

        $products = Product::get();

        return view('frontend.shipmentInfos.index', compact('shipmentInfos', 'products'));
    }

    public function create()
    {
        abort_if(Gate::denies('shipment_info_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id');

        return view('frontend.shipmentInfos.create', compact('products'));
    }

    public function store(StoreShipmentInfoRequest $request)
    {
        $shipmentInfo = ShipmentInfo::create($request->all());
        $shipmentInfo->products()->sync($request->input('products', []));

        return redirect()->route('frontend.shipment-infos.index');
    }

    public function edit(ShipmentInfo $shipmentInfo)
    {
        abort_if(Gate::denies('shipment_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id');

        $shipmentInfo->load('products');

        return view('frontend.shipmentInfos.edit', compact('products', 'shipmentInfo'));
    }

    public function update(UpdateShipmentInfoRequest $request, ShipmentInfo $shipmentInfo)
    {
        $shipmentInfo->update($request->all());
        $shipmentInfo->products()->sync($request->input('products', []));

        return redirect()->route('frontend.shipment-infos.index');
    }

    public function show(ShipmentInfo $shipmentInfo)
    {
        abort_if(Gate::denies('shipment_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shipmentInfo->load('products');

        return view('frontend.shipmentInfos.show', compact('shipmentInfo'));
    }

    public function destroy(ShipmentInfo $shipmentInfo)
    {
        abort_if(Gate::denies('shipment_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shipmentInfo->delete();

        return back();
    }

    public function massDestroy(MassDestroyShipmentInfoRequest $request)
    {
        ShipmentInfo::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
