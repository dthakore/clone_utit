<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductPricing;
use App\Models\OrderLineItem;
use App\Models\ProductCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $id = $request->id;
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product = Product::with(['category', 'media'])->where(['id' => $id])->get()->first();
        $media = 0;
        //$media = Media::where('model_id' , $id)->get();
        $child_product = [];
        $mainProduct = $product->getAttributes();
        if($mainProduct['sku'] == 'NTTP1'){
            $child_product = Product::where('sku','NTBOT')->get()->first();
//            $child_product = $child_product->getAttributes();
            $child_product = ['price'=>$child_product['price'],'sku'=>'NTBOT'];
        }
        $orders = Order::where('user_id',auth()->user()->id)->pluck('id')->toArray();
        if(count($orders)>0){
            $orderlineitems = OrderLineItem::where(['product_sku' => 'NTTP1'])->whereIn('order_id',$orders)->get();
            $has_platform = $orderlineitems->count();
        } else {
            $has_platform = 0;
        }
        $productPricing = ProductPricing::where('is_cluster',1)->get();

        $productPricingDetails = array();
        foreach ($productPricing as $item){
            $temp = array();
            $temp['id'] = $item['id'];
            $temp['licenses'] = $item['licenses'];
            $temp['price_per_license'] = $item['price_per_license'];
            $temp['is_cluster'] = $item['is_cluster'];
            $productPricingDetails[$item['id']] = $temp;
        }
        return view('frontend.products.index',[
            'product'=> $product,
            'media'=> $media,
            'child_product'=> $child_product,
            'product_pricing' => $productPricingDetails,
            'has_platform'=> $has_platform
        ]);
    }

    //Action to license price based upon licenseNumber
    public function GetLicensePrice(Request $request){
        $license = $request->licenseNum;
        if(!empty($license) && $license != 0){
            $previous_product_pricing = ProductPricing::where('licenses','<=',$license)->orderBy('licenses', 'desc')->first();

            echo json_encode([
                'id' => (int)$previous_product_pricing->id,
                'product_price' => $previous_product_pricing->price_per_license
            ]);
        } else {
            echo json_encode([
                'id' => 0,
                'product_price' => 0
            ]);
        }
    }

    // Action to get next license Id from product_pricing_table
    public function GetLicenseId(Request $request){
        $license = $request->licenseNum;
        if(!empty($license)){
            $product_pricing =  ProductPricing::where('licenses',$license)->first();
            if(isset($product_pricing->id)){
                echo json_encode([
                    'present' => true,
                    'id' => $product_pricing->id,
                    'product_price' => $product_pricing->price_per_license
                ]);
            } else {
                $next_product_id = ProductPricing::where('licenses','>=',$license)->orderBy('licenses', 'ASC')->first();
                $previous_product_pricing = ProductPricing::where('licenses','<=',$license)->orderBy('licenses', 'desc')->first();
                echo json_encode([
                    'present' => false,
                    'id' => (int)$next_product_id->id,
                    'product_price' => $previous_product_pricing->price_per_license
                ]);
            }
        } else {
            echo "0";
        }
    }

    public function list()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::with(['category', 'media'])->where(['is_active' => 1])->get();
//        dd($products);

//        $product_categories = ProductCategory::get();

        return view('frontend.products.list', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        if ($request->input('photo', false)) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $product->id]);
        }

        return redirect()->route('frontend.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $product->load('category');

        return view('frontend.products.edit', compact('categories', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());

        if ($request->input('photo', false)) {
            if (!$product->photo || $request->input('photo') !== $product->photo->file_name) {
                if ($product->photo) {
                    $product->photo->delete();
                }
                $product->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($product->photo) {
            $product->photo->delete();
        }

        return redirect()->route('frontend.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('category');

        return view('frontend.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_create') && Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Product();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
