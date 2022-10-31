@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))
@extends('layouts.custom-app')

@section('styles')

@endsection

@section('class')

    <div class="bg-primary">

    @endsection

    @section('content')

        <!-- Main-error-wrapper -->
            <div class="main-error-wrapper page page-h">
                <h1 class="text-white">401<span class="tx-20">error</span></h1>
                <h2 class="text-white">Oops! The page you were looking for doesn't exist.</h2>
                <h6 class="tx-white-6">You may have mistyped the address or the page may have moved.</h6>
                <a class="btn btn-light" href="{{url('/')}}">Back to Home</a>
            </div>
            <!-- /Main-error-wrapper -->

@endsection

@section('scripts')

@endsection
