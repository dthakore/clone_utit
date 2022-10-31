@extends('layouts.frontend-new', [
    "title" => "AFFILIATE DASHBOARD",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Affiliate dashboard"
        ]
    ]
])
@section('content')
    <div class="row row-sm">
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card sales-card circle-image1">
                <div class="row">
                    <div class="col-8">
                        <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                            <div class="">
                                <h6 class="mb-2 tx-12 ">Affiliate Commission</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <h4 class="tx-26 font-weight-semibold mb-2">€ {{$wallet}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="circle-icon widget bg-primary-gradient text-center align-self-center shadow-primary overflow-hidden box-shadow-primary">
                            <i class="fe fe-dollar-sign tx-20 lh-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card sales-card circle-image2">
                <div class="row">
                    <div class="col-8">
                        <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                            <div class="">
                                <h6 class="mb-2 tx-12">Rank</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    @if(empty($rank_name))
                                        <h4 class="tx-26 font-weight-semibold mb-2">Not Set</h4>
                                    @else
                                        <h4 class="tx-26 font-weight-semibold mb-2">{{$rank_name}}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="circle-icon widget bg-info-gradient text-center align-self-center shadow-secondary overflow-hidden box-shadow-info">
                            <i class="fe fe-external-link tx-20 lh-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card sales-card circle-image3">
                <div class="row">
                    <div class="col-8">
                        <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                            <div class="">
                                <h6 class="mb-2 tx-12">Personally referred Clients</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <h4 class="tx-26 font-weight-semibold mb-2">{{$no_of_child}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="circle-icon widget bg-success-gradient text-center align-self-center shadow-success overflow-hidden box-shadow-success">
                            <i class="fe fe-users tx-20 lh-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-2">
                <div class="card-header">
                    My Referral link
                </div>
                <div class="card-body">
                    <div class="form-group col-lg-4">
                        <p class="form-control cpn referral-link" id="referral_link" data-clipboard-text="{{ url('/').'/'.auth()->user()->id }}" onclick="copyReferral()">{{ url('/').'/'.auth()->user()->id }}</p>
                        <p id="copied_code" style="color: green"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
