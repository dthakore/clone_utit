<!DOCTYPE html>
@php
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset("plugins/fontawesome-free/css/all.min.css") }}"/>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/custom.css') }}?ver=1.0.2" rel="stylesheet" />
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/trip.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/plugins/wizard/steps.css') }}" rel="stylesheet"/>

    <style>
        .badge:after{
            content:attr(value);
            font-size:13px;
            background: #007bff;
            border-radius:50%;
            padding:3px;
            position:relative;
            left:-8px;
            top:-10px;
            opacity:0.9;
        }
        .badge{
            margin-right: -6px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script defer>
        window.API_TOKEN = '{!! Auth::user()->createToken('auth-token')->plainTextToken !!}';
        window.IS_ADMIN = 0;
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('styles')
</head>

<body class="{{ 'layout-top-nav sidebar-collapse' }}">
<div class="wrapper" id="app">
    @include('partials.navbar')

{{--    @include('partials.sidebar')--}}

    <div class="content-wrapper" style="margin-left: 0px!important;">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    @if(isset($title))
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title }}</h1>
                    </div>
                    @endif
                    @if(isset($breadcrumbs))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @foreach($breadcrumbs as $breadcrumb)
                                    @if(isset($breadcrumb['url']))
                                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                                    @else
                                        <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="content pb-3">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>
    {{--<aside class="control-sidebar control-sidebar-dark"></aside>--}}
    @include('partials.footer')
</div>
</body>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>--}}
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.nav-treeview').css('margin-left', '10px');

    //Copy OTP
    function copyReferral() {
        var r = document.createRange();
        r.selectNode(document.getElementById("referral_link"));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(r);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        $('#copied_code').html('Referral Link Copy to Clipboard');
    }

</script>
@yield('scripts')
</html>
