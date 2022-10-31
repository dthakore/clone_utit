
{{--<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/css/SIO/color.css" />
	<link rel="stylesheet" type="text/css" href="/css/SIO/main.css" />
	<link rel="stylesheet" type="text/css" href="/css/SIO/responsive.css" />
	<title>{{ config('app.name') }} | Login</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet"/>
		<style>
			.text-center {
				text-align: center!important;
			}
			.alert-info {
				color: #0c5460;
				background-color: #d1ecf1;
				border-color: #f5c6cb;
			}
			.alert {
				position: relative;
				padding: 0.75rem 1.25rem;
				margin-bottom: 1rem;
				border: 1px solid transparent;
				border-radius: 0.25rem;
			}
		</style>
	</head>
<body data-aos-easing="ease" data-aos-duration="1200" data-aos-delay="0">
	@if(isset($messages))
		<div role="alert" class="alert alert-info text-center" style="max-width: 70%; top: 5px;left: 210px;">
			{!! $messages !!}
		</div>
	@endif
	<main class="login">
		<div class="logo mb6 aos-init aos-animate" data-aos="fade-down">
			<a href="#"><img src="{{ asset('assets/img/brand/logo.png') }}" style="width: 35%"></a>
		</div>
		<div class="login-box mb6">
			<div class="login-form" style="min-height: 300px">
				<h4 class="mb5">Login To {{ config('app.name') }}</h4>
				<form class="mb3" style="margin-top: 70px">
					<a href="{{ env('SIO_URL') }}/login?application={{ config('app.name') }}" class="signInBtn">
						Sign in using Sign In Once
						<img src="{{ asset('img/sio/logo-sio-icon.png') }}" alt="" />
					</a>
				</form>
			</div>
			<div class="login-vector" data-aos="fade-left" data-aos-delay="300">
				<div class="vector-icon">
					<img src="{{ asset('img/sio/icon-vector.png') }}" alt="" />
				</div>
			</div>
		</div>
		<div class="sio-flex">
			<div class="sio-logo">
				<img src="{{ asset('img/sio/logo-sio-icon.png') }}" alt="" />
			</div>
			<div class="sio-text">
				<p class="sio-heading">
				{{ config('app.name') }} registration is powered by Sign In Once
				</p>
				<p class="sio-sub-heading">
					By continuing, you agree to the
					<a target="_blank" href="#">terms & conditions.</a>
				</p>
			</div>
		</div>
	</main>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init({
			once: true,
			duration: 1200,
			easing: 'ease',
			anchorPlacement: 'center-bottom',
		});
	</script>
</body>
</html>--}}
@extends('layouts.custom-app')
@php
@endphp
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/SIO/main.css') }}" />
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
					<div class="main-card-signin d-md-flex">
						<div class="wd-100p">
							<div class="d-flex mb-4">
								<a href="/"><img src="{{ asset(env('PUXEO_URL')) }}" alt="Logo"  class="sign-favicon" width="130px;" /></a>
							</div>
							@if(isset($messages))
								<p class="alert alert-info" style="color: unset;">
									{!! $messages !!}
								</p>
							@endif
							<div class="">
								<div class="main-signup-header">
									<h2>{{ trans('global.login') }}</h2>
									<div class="panel panel-primary">
										<form class="mb3 mt-5">
											<a href="{{ env('SIO_URL') }}/login?application={{ config('app.name') }}" class="signInBtn" style="background-color: #ebeef3">
												Sign in using Sign In Once
												<img src="{{ asset('img/sio/logo-sio-icon.png') }}" alt="" />
											</a>
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
	