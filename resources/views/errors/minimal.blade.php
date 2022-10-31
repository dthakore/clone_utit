<!DOCTYPE html>
<html lang="en">
@php
    $tenant = App\Helpers\ServiceHelper::getThemeOptions();
@endphp
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ $tenant['app_name'] }} | Puxeo</title>

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

<div class="bg-primary">

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
    <div class="flex-center position-ref full-height">
        <div class="code">
            @yield('code')
        </div>

        <div class="message" style="padding: 10px;">
            @yield('message')
            <a href="javascript:history.back()" class="btn btn-primary text-center">Go Back</a>
        </div>
    </div>
    </div>
</div>
</div>

@include('layouts.components.custom-scripts')

</body>
</html>
