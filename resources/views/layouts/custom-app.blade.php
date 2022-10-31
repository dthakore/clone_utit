<!DOCTYPE html>
<html lang="en">
@php
@endphp
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Title -->
        <title></title>

		@include('layouts.components.custom-styles')

    </head>
	<body class="ltr error-page1">

		@yield('class')

            <!-- Loader -->
            <div id="global-loader">
                <div class="text-center">
                    <div class="lds-spinner loader-img" style="position: absolute"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
{{--                <img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">--}}
            </div>
            <!-- /Loader -->


            <div class="square-box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="page" >

                @yield('content')

            </div>
        </div>

		@include('layouts.components.custom-scripts')

    </body>
</html>
