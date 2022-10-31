@extends('layouts.frontend-new')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body text-center" style="min-height: 550px;">
                    <h5 class="text-center mb-4">Your order Confirmed!</h5>
                    <svg class="wd-100 ht-100 mx-auto justify-content-center mb-3 text-center" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                        <circle class="path circle" fill="none" stroke="#22c03c" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                        <polyline class="path check" fill="none" stroke="#22c03c" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                    </svg>
                    <p class="success pl-5 pr-5">Order placed successfully.</p>

                    <p><strong>Confirmation e-mail sent to:</strong> {{$orderInfo->email}}</p>
                    <p><strong>Order Number:</strong> {{$orderId}}</p>
                    <p style="margin-top: 60px"><strong>Please proceed to Bottrader platform for trading services</strong></p>
                    <a href="{{ env('BOTTRADER_URL') }}" target="_blank" class="btn btn-primary mt-2" style="margin: auto">Go to Bottrader</a>
                    {{--<a href="" class="btn btn-primary">Review or Edit Your Order</a>--}}
                </div>
            </div>
        </div>
    </section>
@endsection
