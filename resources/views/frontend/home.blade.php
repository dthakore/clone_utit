@extends('layouts.frontend-new', [
    "title" => "Dashboard",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "#"
        ],
        [
            "title" => "Dashboard"
        ]
    ]
])
@section('content')
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card"><div class="card-body bg-info">
                    <p class="card-text">
                        We have migrated all bots to Perpetual markets.
                        Please visit <a href="https://bottrader.perpetualmarkets.com/bots" target="_blank" style="text-decoration: underline !important;color:white !important;"><strong>Bot Trader platform </strong></a> for managing your bots.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Welcome to UTIT</h4>
                    <p class="card-text">
                        UtradeItrade is an all in one trading platform for all products. Visit Marketplace to see current products
                    </p>
                    <a class="btn btn-primary btn-lg btn-flat" href="{{ route('frontend.shop') }}">
                        Marketplace
                    </a>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-8">
                                <div class="ps-4 pt-4 pe-3 pb-4">
                                    <div class="">
                                        <h6 class="mb-2 tx-12 ">Broker</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold mb-2">
                                                € {{isset($balance->balance) ? $balance->balance : 0}}
                                            </h4>
                                        </div>
                                        <p class="mb-0 tx-12 text-muted">Euro Trader</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="circle-icon text-center align-self-center overflow-hidden">
                                    <img src="{{ asset('/img/exchanges.png') }}" class="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-8">
                                <div class="ps-4 pt-4 pe-3 pb-4">
                                    <div class="">
                                        <h6 class="mb-2 tx-12 ">Exchanges</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold mb-2">
                                                USDT {{isset($response->total_balance) ? $response->total_balance : 0}}
                                            </h4>
                                        </div>
                                        <p class="mb-0 tx-12 text-muted">Binance</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="circle-icon text-center align-self-center overflow-hidden">
                                    <img src="{{ asset('/img/broker.png') }}" class="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-8">
                                <div class="ps-4 pt-4 pe-3 pb-2">
                                    <div class="">
                                        <h6 class="mb-2 tx-12 ">Cashback</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class=" right_align">
                                            <div class="badge badge-info">
                                                <span >Total  </span>
                                                <span>{{(int)$total_cashback}}</span>
                                            </div>
                                            <div class="badge badge-info">
                                                <span class="" >Available </span>
                                                <span>N/A</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('frontend.account',['id' => base64_encode(auth()->user()->id)]) }}" class="btn btn-warning btn-sm utit_header_link">Visit CB UTIT</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="circle-icon bg-primary-transparent  text-center align-self-center overflow-hidden">
                                    <i class="fe fe-shopping-bag tx-16 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-xs-12">
                    <div class="card sales-card">
                        <div class="row">
                            <div class="col-8">
                                <div class="ps-4 pt-4 pe-3 pb-4">
                                    <div class="">
                                        <h6 class="mb-2 tx-12 ">Community</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <h4 class="tx-20 font-weight-semibold mb-2">
                                                &nbsp;
                                            </h4>
                                        </div>
                                        <p class="mb-0 tx-12 text-muted">Comming Soon</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="circle-icon text-center align-self-center overflow-hidden">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="row">

                <div class="col-xl-8 col-lg-12 col-md-12 col-xs-12">
                    <div class="card">
                        <div class="card-header bg-transparent pb-0">
                            <div>
                                <h3 class="card-title mb-2">Most Popular Products</h3>
                            </div>
                        </div>
                        
                        <div class="card-body pt-0">
                            <div class="row">
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
                                    <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
                                        <div class="card">
                                            <div class="card-body h-100  product-grid6">
                                                @if(isset($product->tag))
                                                <div class="card product_tag">
                                                    <span class="img_tag">{{$product->tag}}</span>
                                                </div>
                                                @endif
                                                <div class="pro-img-box product_image product-image text-center">
                                                    @if($media != 0)
                                                        <a href="{{ url('/product/'.$product->id) }}">
                                                            <img src="<?= Illuminate\Support\Facades\Storage::url("$media/$image_file");?>" class="product_image pic-1" alt="Product Image" /> 
                                                        </a>
                                                    @endif
                                                </div>
                                                {{-- <div class="card mt-3">
                                                    <span align="center" class="img_tag">{{$product->tag}}</span>
                                                </div> --}}
                                                
                                                <div class="text-center pt-2">
                                                    <a href="{{ url('/product/'.$product->id) }}">
                                                        <h3 class="group inner h6 mb-2 mt-4 font-weight-bold text-uppercase">{{$product->name}}</h3>
                                                    </a>
                                                        <span class="category-list"><?= $product->short_description; ?></span>
                                                        {{-- <h4 class="h5 mb-0 mt-1 text-center font-weight-bold  tx-22"><strong class="price"><?= 'EUR'.round(($product->price + $product->price * 0.21),2); ?></strong></h4><br/>  --}}
                                                        @if (config('app.env') == 'local')
                                                            <h4 class="h5 mb-0 mt-1 text-center font-weight-bold  tx-22"><strong class="price"><?= 'EUR'. number_format($product->price + $product->price * 0.21, 2)  ?></strong></h4><br/>
                                                        @else
                                                            <h4 class="h5 mb-0 mt-1 text-center font-weight-bold  tx-22"><strong class="price"><?= 'EUR'. number_format($product->price + $product->price * 0.21, 2, ',')  ?></strong></h4><br/>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-12 col-xl-4">
                    <div class="card">
                        <div class="card-header bg-transparent pb-0">
                            <div>
                                <h3 class="card-title mb-2">News and Updates</h3>
                            </div>
                        </div>
                        <div class="card-body mt-0">
                            <div class="latest-timeline mt-4">
                                <ul class="timeline mb-0">
                                    @if(!$alerts->isEmpty())
                                        @foreach($alerts as $alert)
                                            <li>
                                                <div class="featured_icon1 primary">
                                                </div>
                                            </li>
                                            <li class="mt-0 activity">
                                                <div><span class="tx-11 text-muted float-end">{{ date("M d, Y", strtotime($alert->created_at)) }}</span></div>
                                                <a href="{{ $alert->alert_link }}" target="_blank" class="tx-12 text-dark">
                                                <p class="mb-1 font-weight-semibold text-dark">{{$alert->alert_text}}</p>
                                                </a>
{{--                                                <p class="text-muted mt-0 mb-0 tx-12">Lorem ipsum dolor tempor incididunt . </p>--}}
                                            </li>     
                                        @endforeach
                                    @else
                                    <span>No News Found.</span>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    {{-- <a type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
    <!--Menu-->
    <div class="dropdown-menu dropdown-primary">
        <a class="dropdown-item" href="#"><i class="fab fa-apple-pay"></i>&nbsp;&nbsp;Pay</a>
    </div> --}}
@endsection