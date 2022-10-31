<!DOCTYPE html>
@php
    $tenant = App\Helpers\ServiceHelper::getThemeOptions();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tenant['app_name'] }} | Puxeo</title>
    @include('layouts.components.styles')

</head>

<body class=" main-body app sidebar-mini utit_rtl">
<!-- <body class="ltr main-body app horizontal"> -->

<!-- Loader -->
<div id="global-loader">
    <div class="text-center">
        <div class="lds-spinner loader-img" style="position: absolute"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
</div>
<!-- /Loader -->

<!-- Page -->
<div class="page">

    <div >

        @include('layouts.components.app-header')

        @include('partials.navbar-new')
        {{--        @include('layouts.components.app-sidebar')--}}
    </div>
    <!-- main-content -->
    <!-- <div class="main-content horizontal-content"> -->
    <div class="main-content ">
        <!-- container -->
        <div class="main-container container-fluid">
        <div class="col-lg-12">
        <!-- <div class="breadcrumb-header justify-content-between">
            <div class="justify-content-center mt-2">
                -->
            <div class="breadcrumb-header justify-content-between">

                @if(isset($title) || isset($breadcrumbs))
                    @if(isset($title))
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1 d-inline-block">{{ $title }}</span>

                        </div>
                    @endif

                    @if(isset($breadcrumbs))
                        <div class="justify-content-center mt-2">
                            <ol class="breadcrumb">
                                @foreach($breadcrumbs as $breadcrumb)
                                    @if(isset($breadcrumb['url']))
                                        <li class="breadcrumb-item  tx-15"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    @endif
                @endif
            </div>
            <div class="">
                @yield('content')

            </div>
        </div>
        </div>
        <!-- Container closed -->
    </div>
    <div class="sidebar sidebar-right sidebar-animate">
    </div>
    <!-- main-content closed -->
    @include('layouts.components.footer')

</div>
<!-- End Page -->

@include('layouts.components.scripts')
<script defer>
    window.API_TOKEN = '{!! Auth::user()->createToken('auth-token')->plainTextToken !!}';
    window.IS_ADMIN = 0;
</script>

<script>
    Pusher.logToConsole = true;
    var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
    });
    var channel = pusher.subscribe('logoutChannel');
    channel.bind("{{ auth()->user()->api_token }}", function(data) {
        window.location.href = "{{ route('logout') }}";
    });
</script>
</body>
</html>
