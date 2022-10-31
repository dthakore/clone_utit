@extends('layouts.custom-app')
@php
    $tenant = App\Helpers\ServiceHelper::getThemeOptions();
@endphp
@section('class')
    <div class="bg-primary">
        @endsection

        @section('content')
            <div class="page-single">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main py-45 justify-content-center mx-auto">
                            <div class="card-sigin mt-5 mt-md-0">
                                <!-- Demo content-->
                                <div class="main-card-signin d-md-flex">
                                    <div class="wd-100p">
                                        <div class="mb-3 d-flex">
                                            <a href="/"><img src="{{ asset(env('PUXEO_URL').$tenant['logo']) }}" alt="Logo"  class="sign-favicon ht-40" width="130px;" /></a>
                                        </div>
                                        <div class="main-card-signin d-md-flex bg-white">
                                            <div class="wd-100p">
                                                <div class="main-signin-header">
                                                    <h2>Resend Verification Link</h2>
                                                    <form class="form-horizontal" method="POST" action="{{ route('resendVerificationSubmit')}}">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="input100 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" name="email" value="{{ old('email', null) }}" type="email">
                                                            @if($errors->has('email'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('email') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">
                                                            Resend
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
