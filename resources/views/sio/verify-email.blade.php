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
                                    <h2 class="text-dark">Verify Email</h2>
                                    <form method="POST">
                                        <div>
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>{{ trans('global.sio.email') }}</label>
                                                <input type="email" name="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}" required autocomplete="off">
                                                @if($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value="{{ request()->id }}">
                                        <div class="col-13 text-right">
                                            <button type="button" id="verify" class="btn btn-primary btn-block btn-flat">
                                                {{ trans('global.sio.verify') }}
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
    $('#verify').click(function(){
        var email = $("#email").val();
        if(email == ''){
            toastr.error("Please enter your email");
        } else {
            $.ajax({
                url: "{{ route('sio.verify.email') }}",
                type: "POST",
                data: {
                    email: email
                },
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                beforeSend: function(){
                    $('#verify').html('Verifying...');
                    $('#verify').prop('disabled', true);
                },
                success: function (response) {
                    $('#verify').html('Verify');
                    $('#verify').prop('disabled', false);
                    /*
                    * 0 - Error
                    * 1 - Registration can begin
                    * 2 - User is already registered at SIO. Please proceed registration with some necessary data.
                    * 3 - Email exists in EazyBot itself. Kindly login
                    * */
                    if(response.status == 1){
                        toastr.success(response.message);
                        window.location = "{{ route('sio.register') }}"
                    } else if(response.status == 2){
                        console.log(response.verification_url);
                        toastr.success(response.message);
                    }  else if(response.status == 3){
                        toastr.success(response.message);
                    } else {
                        console.log(response.message);
                        toastr.error(response.message);
                    }
                },
                error: function(error){
                    console.log("Error: "+error.responseJSON.message+" at Line: "+error.responseJSON.line);
                }
            })
        }
    });
});
</script>
@endsection