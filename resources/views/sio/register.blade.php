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
                    <div class="main-card-signin d-md-flex">
                        <div class="wd-100p"><div class="d-flex mb-4">
                                <a href="/"><img src="{{ asset(env('PUXEO_URL').$tenant['logo']) }}" alt="Logo" width="130px;" /></a>
                            </div>
                            <div class="">
                                <div class="main-signup-header">
                                    <h2 class="text-dark">{{ trans('global.register') }}</h2>
                                    <form method="POST" id="signup_form">
                                        <div>
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input style="margin-bottom: 0;" type="text" name="name" class="form-control {{ session()->has('name') ? ' is-invalid' : '' }}" autofocus placeholder="{{ trans('global.user_name') }}" value="{{ old('name', $user->name) }}" autocomplete="off">
                                                <label class="font-15">(No Special Characters)</label>
                                                @if(session()->has('name'))
                                                    <div class="invalid-feedback">
                                                        {{ (session()->get('name') == 'The name format is invalid.') ? 'Letters and numbers only. No special characters.' : session()->get('name') }}
                                                        {{ session()->forget('name') }}
                                                    </div>
                                                @endif
                                            </div>
                                            @if(session()->has('old_email'))
                                                @php $email = session()->get('old_email'); @endphp
                                                {{ session()->forget('old_email') }}
                                            @endif
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control{{ session()->has('email_address') ? ' is-invalid' : '' }}" placeholder="{{ trans('global.login_email') }}" value="{{ (isset($email) ? $email : $user->email ?? '') }}" {{ isset($user->email) ? 'readonly' : ''}} autocomplete="off">
                                                @if(session()->has('email_address'))
                                                    <div class="invalid-feedback">
                                                        {{ session()->get('email_address') }}
                                                        {{ session()->forget('email_address') }}
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($sioData != 1)
                                                <div class="form-group">
                                                    <input style="margin-bottom: 0;" type="password" name="password" class="form-control{{ session()->has('password') ? ' is-invalid' : '' }}" placeholder="{{ trans('global.login_password') }}">
                                                    <label class="font-15">(Min - 8 Characters, 1 Capital, 1 Special Character)</label>
                                                    @if(session()->has('password'))
                                                        <div class="invalid-feedback">
                                                            {{ session()->get('password') }}
                                                            {{ session()->forget('password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <input style="margin-bottom: 0;" type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('global.login_password_confirmation') }}">
                                                    <label class="font-15">(Re-Enter Password)</label>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <select class="form-control select2 {{ session()->has('country_id') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                                                    @foreach($countries as $id => $entry)
                                                        <option value="{{ $id }}" {{ old('country_id', $user->country_id) == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    @endforeach
                                                </select>
                                                @if(session()->has('country_id'))
                                                    <div class="invalid-feedback">
                                                        {{ session()->get('country_id') }}
                                                        {{ session()->forget('country_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-13 text-right">
                                            <button type="button" id="register" class="btn btn-primary btn-block btn-flat">
                                                {{ trans('global.register') }}
                                            </button>
                                        </div>
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
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    

    $('#register').click(function(){
        $.ajax({
            url: "{{ route('sio.register.user') }}",
            type: "POST",
            data: $("#signup_form").serializeArray(),
            beforeSend: function(){
                $('#register').html('Please wait...');
                $('#register').prop('disabled', true);
            },
            success: function (response) {
                $('#register').html('Register');
                $('#register').prop('disabled', false);
                if(response.status == true){
                    toastr.success(response.message);
                }else{
                    toastr.error(response.message);
                    location.reload();
                }
            },
            error: function(error){
                console.log("Error: "+error.responseJSON.message+" at Line: "+error.responseJSON.line);
            }
        });
    });
});
</script>
@endsection