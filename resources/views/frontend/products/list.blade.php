@extends('layouts.frontend-new', [
    "title" => "SHOP",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Products"
        ]
    ]
])
@section('styles')
    <!-- Internal Nice-select css  -->
    <link href="{{asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet"/>
@endsection
@section('content')
    <!-- Main content -->
    <div class="row row-sm">
        <div class="col-xl-12 col-lg-12 col-md-12" id="products">
            <div class="row row-sm">
                @foreach($products as $key => $product)
                    <?php
                    $image_file = "";
                    $media = 0;
                    if(isset($product->media[0])){
                        $imageArr = $product->media[0]->getAttributes();
                        $image_file = $imageArr['file_name'];
                        $media = $imageArr['id'];
                    }
                    $request=$product->name.'#'.$image_file.'#'.$product->price.'#'.$product->id;
                    $id=base64_encode($request);
                    ?>
                <div class="col-md-6 col-lg-6 col-xl-3  col-sm-6">
                    <div class="card">
                        <div class="card-body h-100  product-grid6">
                            <div class="pro-img-box product_image product-image text-center">
                                @if($media != 0)
                                    <a href="{{ url('/product/'.$product->id) }}">
                                        <img src="<?= Illuminate\Support\Facades\Storage::url("$media/$image_file");?>" class="product_image pic-1" alt="Product Image">
                                    </a>
                                @endif
                            </div>
                            <div class="text-center pt-2">
                                <a href="{{ url('/product/'.$product->id) }}">
                                    <h3 class="group inner h6 mb-2 mt-4 font-weight-bold text-uppercase">{{$product->name}}</h3>
                                </a>
                                    <span class="category-list"><?= $product->short_description; ?></span>
                                    {{-- <h4 class="h5 mb-0 mt-1 text-center font-weight-bold  tx-22"><strong class="price"><?= 'EUR'.round(($product->price + $product->price * 0.21),2); ?></strong></h4><br/>  --}}
                                    <h4 class="h5 mb-0 mt-1 text-center font-weight-bold  tx-22"><strong class="price"><?= 'EUR'. number_format($product->price + $product->price * 0.21, 2, ',')  ?></strong></h4><br/>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
