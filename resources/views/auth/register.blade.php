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
                                    <div class="wd-100p"><div class="d-flex mb-4">
                                            <a href="/"><img src="{{ asset(env('PUXEO_URL').$tenant['logo']) }}" alt="Logo" width="130px;" /></a>
                                        </div>
                                        <div class="">
                                            <div class="main-signup-header">
                                                <h2 class="text-dark">{{ trans('global.register') }}</h2>
                                                <form method="POST" id="register-form" action="/register/{{ request()->id }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="sponsor_id" value="{{ request()->id }}">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" autofocus placeholder="{{ trans('global.first_name') }}" value="{{ old('first_name', null) }}">
                                                        @if($errors->has('first_name'))
                                                            <div class="invalid-feedback error tx-13">
                                                                {{ $errors->first('first_name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" name="last_name" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"  autofocus placeholder="{{ trans('global.last_name') }}" value="{{ old('last_name', null) }}">
                                                        @if($errors->has('last_name'))
                                                            <div class="invalid-feedback error tx-13">
                                                                {{ $errors->first('last_name') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                                                        @if($errors->has('email'))
                                                            <div class="invalid-feedback error tx-13">
                                                                {{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  placeholder="{{ trans('global.login_password') }}">
                                                        <label style="font-size: 14px; font-weight: 400;" class="font-15">(Min - 8 Characters, 1 Capital, 1 Special Character)</label>
                                                        @if($errors->has('password'))
                                                            <div class="invalid-feedback error tx-13">
                                                                {{ ($errors->first('password') == 'The password format is invalid.') ? 'Must contain minimum 8 Characters, 1 Capital and 1 Special Character' : $errors->first('password')  }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Re-Enter Password</label>
                                                        <input type="password" name="password_confirmation" class="form-control"  placeholder="{{ trans('global.login_password_confirmation') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="checkbox" name="terms" checked /> Agree with the  <a class="success required" target="_blank" href="https://support.utradeitrade.com/legal/terms-and-conditions/">  Terms and Conditions</a>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                                                        {{ trans('global.register') }}
                                                    </button>
                                                </form>
                                                <div class="main-signup-footer mt-3 text-center">
                                                    <p>Already have an account? <a href="{{url('login')}}">Sign In</a></p>
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
                $("#register-form").validate({
                    rules: {
                        'first_name': {
                            required: true,
                        },
                        'last_name': {
                            required: true,
                        },
                        'email': {
                            required: true,
                            customemail: true
                        },
                        'password': {
                            required: true,
                            minlength: 8
                        },
                        'password_confirmation': {
                            required: true,
                            equalTo: '#password'
                        },
                        'terms':{
                            required: true,
                        }
                    },
                    messages: {
                        'first_name': {
                            required: "Please enter first name",
                        },
                        'last_name': {
                            required: "Please enter last name",
                        },
                        'password': {
                            required: "Please enter password",
                            minlength: "Your password must be at least 8 characters long"
                        },
                        'password_confirmation': {
                            required: "Please re-enter new password",
                            equalTo: "The passwords entered do not match"
                        },
                        'email': {
                            required: "Please enter email address",
                            customemail : "Please enter correct email"
                        },
                        'terms':{
                            required: "Please agree to Terms and Conditions",
                        }

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
