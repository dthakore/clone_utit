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
                                        @if(isset($messages))
                                            <p class="alert alert-info">
                                                {{ $messages }}
                                            </p>
                                        @endif
                                        <div class="main-card-signin d-md-flex bg-white">
                                            <div class="wd-100p">
                                                <div class="main-signin-header">
                                                    <h2>{{ trans('global.reset_password') }}</h2>
                                                    @if(session('status'))
                                                        <div class="alert alert-success" role="alert">
                                                            {{ session('status') }}
                                                        </div>
                                                    @endif

                                                    <form method="POST" action="{{ route('password.request') }}">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email') }}">

                                                            @if($errors->has('email'))
                                                                <span class="text-danger">
                                                                    {{ $errors->first('email') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-flat btn-block">
                                                            {{ trans('global.send_password') }}
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('password.request') }}">
                                                        @csrf

                                                        <input name="token" value="{{ $token }}" type="hidden">

                                                        <div>
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}"  autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}">

                                                                @if($errors->has('email'))
                                                                    <span class="text-danger">
                                {{ $errors->first('email') }}
                            </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ trans('global.login_password') }}</label>
                                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ trans('global.login_password') }}">

                                                                @if($errors->has('password'))
                                                                    <span class="text-danger">
                                {{ $errors->first('password') }}
                            </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ trans('global.login_password_confirmation') }}</label>
                                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('global.login_password_confirmation') }}">
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-flat btn-block">
                                                            {{ trans('global.reset_password') }}
                                                        </button>>
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
