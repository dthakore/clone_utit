@extends('layouts.custom-app')
@php
@endphp
@section('styles')

@endsection

@section('class')

    <div class="bg-primary">

        @endsection

        @section('content')

            <div class="page-single">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-45 justify-content-center">
                            <div class="card-sigin mt-5 mt-md-0">
                                <!-- Demo content-->
                                <div class="main-card-signin d-md-flex">
                                    <div class="wd-100p">
                                        {{--<div class="d-flex mb-4">--}}
                                            {{--<a href="/"><img src="{{ asset(env('PUXEO_URL')) }}" alt="Logo"  class="sign-favicon" width="130px;" /></a>--}}
                                        {{--</div>--}}
                                        @if(isset($messages))
                                            <p class="alert alert-info">
                                                {!! $messages !!}
                                            </p>
                                        @endif

                                        <div class="">
                                            <div class="main-signup-header">
                                                <h2>{{ trans('global.login') }}</h2>
                                                <div class="panel panel-primary">
                                                    <form action="{{ route('login') }}" id="login-form" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" name="email" value="{{ old('email', null) }}">

                                                            @if($errors->has('email'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('email') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Password</label>
                                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ trans('global.login_password') }}">

                                                            @if($errors->has('password'))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('password') }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-8">
                                                                <div class="form-group">
                                                                    <input type="checkbox" name="remember" id="remember">
                                                                    <label for="remember">{{ trans('global.remember_me') }}</label>
                                                                </div>
                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-4">
                                                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                                                    {{ trans('global.login') }}
                                                                </button>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="main-signin-footer text-center mt-3">
                                                    @if(Route::has('password.request'))
                                                        <p class="mb-3">
                                                            <a href="{{ route('password.request') }}">
                                                                {{ trans('global.forgot_password') }}
                                                            </a>
                                                        </p>
                                                    @endif
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

@section('scripts')
            <script type="text/javascript">
                $("#login-form").validate({
                    rules: {
                        'email': {
                            required: true,
                            customemail: true
                        },
                        'password': {
                            required: true,
                        },
                    },
                    messages: {
                        'password': {
                            required: "Please enter password",
                        },
                        'email': {
                            required: "Please enter email address",
                            customemail : "Please enter correct email"
                        },

                    },
                    highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass);
                        $(element).parent().parent().addClass('has-error');
                        return false;
                    },
                    unhighlight: function (element) {
                        $(element).parent().parent().removeClass('has-error');
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });

                //custom validation rule
                $.validator.addMethod("customemail",
                    function (value, element) {
                        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
                    },
                    "Invalid Email Address, Please Enter Valid Email."
                );
            </script>
@endsection
