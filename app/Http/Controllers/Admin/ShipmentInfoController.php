<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyShipmentInfoRequest;
use App\Http\Requests\StoreShipmentInfoRequest;
use App\Http\Requests\UpdateShipmentInfoRequest;
use App\Models\Product;
use App\Models\ShipmentInfo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ShipmentInfoController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('shipment_info_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ShipmentInfo::with(['products'])->select(sprintf('%s.*', (new ShipmentInfo())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'shipment_info_show';
                $editGate = 'shipment_info_edit';
                $deleteGate = 'shipment_info_delete';
                $crudRoutePart = 'shipment-infos';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('order', function ($row) {
                return $row->order ? $row->order : '';
            });
            $table->editColumn('shipment_number', function ($row) {
                return $row->shipment_number ? $row->shipment_number : '';
            });
            $table->editColumn('product', function ($row) {
                $labels = [];
                foreach ($row->products as $product) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $product->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('tracking_number', function ($row) {
                return $row->tracking_number ? $row->tracking_number : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? ShipmentInfo::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'product']);

            return $table->make(true);
        }

        $products = Product::get();

        return view('admin.shipmentInfos.index', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('shipment_info_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id');

        return view('admin.shipmentInfos.create', compact('products'));
    }

    public function store(StoreShipmentInfoRequest $request)
    {
        $shipmentInfo = ShipmentInfo::create($request->all());
        $shipmentInfo->products()->sync($request->input('products', []));

        return redirect()->route('admin.shipment-infos.index');
    }

    public function edit(ShipmentInfo $shipmentInfo)
    {
        abort_if(Gate::denies('shipment_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id');

        $shipmentInfo->load('products');

        return view('admin.shipmentInfos.edit', compact('products', 'shipmentInfo'));
    }

    public function update(UpdateShipmentInfoRequest $request, ShipmentInfo $shipmentInfo)
    {
        $shipmentInfo->update($request->all());
        $shipmentInfo->products()->sync($request->input('products', []));

        return redirect()->route('admin.shipment-infos.index');
    }

    public function show(ShipmentInfo $shipmentInfo)
    {
        abort_if(Gate::denies('shipment_info_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shipmentInfo->load('products');

        return view('admin.shipmentInfos.show', compact('shipmentInfo'));
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
