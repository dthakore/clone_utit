@extends('layouts.frontend-new', [
    "title" => "PROFILE",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "/"
        ],
        [
            "title" => "Profile"
        ]
    ]
])
@section('styles')

    <!--Bootstrap-datepicker css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body d-md-flex">
                    <div class="">
									<span class="profile-image pos-relative">
										<img class="br-5" alt="" src="{{asset('assets/img/faces/profile.jpg')}}">
										<span class="bg-success text-white wd-1 ht-1 rounded-pill profile-online"></span>
									</span>
                    </div>
                    <div class="my-md-auto mt-4 prof-details">
                        <h4 class="font-weight-semibold ms-md-4 ms-0 mb-1 pb-0">{{  auth()->user()->name }}</h4>
                        <p class="tx-13 text-muted ms-md-4 ms-0 mb-2 pb-2 ">
                            @if(!empty($user->region))<span class="me-3"><i class="fa fa-taxi me-2"></i>{{$user->region }}@if(!empty($user->region)) , @endif{{ $user->city}}</span>@endif
                            @if(!empty($user->country_id))<span><i class="far fa-flag me-2"></i>{{$country_name}}</span>@endif
                        </p>
                        <p class="text-muted ms-md-4 ms-0 mb-2"><span><i
                                    class="fa fa-phone me-2"></i></span><span
                                class="font-weight-semibold me-2">Phone:</span><span>{{ $user->phone }}</span>
                        </p>
                        <p class="text-muted ms-md-4 ms-0 mb-2"><span><i
                                    class="fa fa-envelope me-2"></i></span><span
                                class="font-weight-semibold me-2">Email:</span><span>{{ auth()->user()->email }}</span>
                        </p>
                        <p class="text-muted ms-md-4 ms-0 mb-2"><span><i
                                    class="fa fa-globe me-2"></i></span><span
                                class="font-weight-semibold me-2">Sponsor:</span><span>
                                @if(isset($user->sponsor_id))
                                {{ $sponsors[$user->sponsor_id] }} @else No sponsor @endif</span>
                        </p>
                    </div>
                </div>
                <div class="card-footer py-0">
                    <div class="profile-tab tab-menu-heading border-bottom-0">
                        <nav class="nav main-nav-line p-0 tabs-menu profile-nav-line border-0 br-5 mb-0	">
                            <a class="nav-link  mb-2 mt-2 active" data-bs-toggle="tab" href="#referral">Referral link</a>
                            <a class="nav-link mb-2 mt-2" data-bs-toggle="tab" href="#edit">Edit Profile</a>
                            <a class="nav-link  mb-2 mt-2" data-bs-toggle="tab" href="#subscription">Current Subscription</a>
                            <a class="nav-link  mb-2 mt-2" data-bs-toggle="tab" href="#changepassword">Change password</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="custom-card main-content-body-profile">
                <div class="tab-content">
                    <div class="main-content-body tab-pane  active" id="referral">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">
                                    My Referral link
                                </div>
                                <div class="form-group col-lg-4">
                                    <p class="form-control cpn referral-link" id="referral_link" data-clipboard-text="{{ url('/').'/'.auth()->user()->id }}" onclick="copyReferral()">{{ url('/').'/'.auth()->user()->id }}</p>
                                    <p id="copied_code" style="color: green"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-content-body border tab-pane border-top-0" id="edit">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">
                                    {{ trans('global.my_profile') }}
                                </div>
                                <form method="POST" name="profile_update" id="profile_update" action="{{ route("frontend.profile.update") }}">
                                    @csrf
                                    <input type="hidden" name="email" id="email" value="{{ old('email', auth()->user()->email) }}">
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}">
                                            </div>
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <div class="row row-sm">--}}
{{--                                            <div class="col-md-3">--}}
{{--                                                <label class="form-label required" for="title">{{ trans('cruds.user.fields.email') }}</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-9">--}}
{{--                                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>--}}
{{--                                                @if($errors->has('email'))--}}
{{--                                                    <div class="invalid-feedback">--}}
{{--                                                        {{ $errors->first('email') }}--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="country_id">{{ trans('cruds.user.fields.country') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                                                    @foreach($countries as $id => $entry)
                                                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $user->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if($errors->has('country'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('country') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="title">{{ trans('cruds.user.fields.phone') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
                                                @if($errors->has('phone'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('phone') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="date_of_birth">{{ trans('cruds.user.fields.date_of_birth') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="datepicker-date" value="@if(!is_null($user->date_of_birth)){{ date('d-m-Y', strtotime($user->date_of_birth)) }}@endif">
                                                @if($errors->has('date_of_birth'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('date_of_birth') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="business_name">{{ trans('cruds.user.fields.business_name') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('business_name') ? 'is-invalid' : '' }}" type="text" name="business_name" id="business_name" value="{{ old('business_name', $user->business_name) }}">
                                                @if($errors->has('business_name'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('business_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="vat_number">{{ trans('cruds.user.fields.vat_number') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('vat_number') ? 'is-invalid' : '' }}" type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', $user->vat_number) }}">
                                                @if($errors->has('vat_number'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('vat_number') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 main-content-label">
                                        {{ trans('global.primary_address') }}
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="building_num">{{ trans('cruds.user.fields.building_num') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('building_num') ? 'is-invalid' : '' }}" type="text" name="building_num" id="building_num" value="{{ old('building_num', $user->building_num) }}">
                                            </div>
                                        </div>
                                        @if($errors->has('building_num'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('building_num') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="street">{{ trans('cruds.user.fields.street') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $user->street) }}">
                                            </div>
                                        </div>
                                        @if($errors->has('street'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('street') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="region">{{ trans('cruds.user.fields.region') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" type="text" name="region" id="region" value="{{ old('region', $user->region) }}">
                                            </div>
                                        </div>
                                        @if($errors->has('region'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('region') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="postcode">{{ trans('cruds.user.fields.postcode') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', $user->postcode) }}">
                                            </div>
                                        </div>
                                        @if($errors->has('postcode'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('postcode') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-md-3">
                                                <label class="form-label" for="city">{{ trans('cruds.user.fields.city') }}</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $user->city) }}">
                                            </div>
                                        </div>
                                        @if($errors->has('city'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('city') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group" align="right">
                                        <button class="btn btn-primary" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="main-content-body  tab-pane border-top-0" id="subscription">
                        <div class="card mb-2">
                            @if(!empty($platform))
                                <div class="card-body">
                                    <div class="alert alert-success mb-2" role="alert">
                                        <h4 class="alert-heading"><i class="fe fe-check-circle me-2 tx-20"></i>Current Trading platform license -  <b>{{ $bot . ' bots'}}</b></h4>
                                        <p>Expires on -  {{ date('dS F , Y',strtotime($platform->cycle_end_at)) }} </p>
                                        <hr>
                                        <p class="mb-0">License key  -  {{ $platform->licence_key }}
                                            @if($platform->cycle_end_at < date('Y-m-d H:i:s') || ($bot != 35))
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upgradeModal" style="margin-left: 20px">
                                                    Upgrade
                                                </button>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                        @else
                                <div class="card-body">
                                    <div class="alert alert-warning mb-2" role="alert">
                                        <h4 class="alert-heading"><i class="fe fe-alert-octagon me-2 tx-20"></i>You didn't purchase a subscription</h4>
                                    </div>
                                    <div class="text-center">
                                        <a class="btn btn-primary" href="{{ route('frontend.shop') }}">Buy Now</a>
                                    </div>
                                </div>
                        @endif
                        </div>

                    </div>
                    <div class="main-content-body  border tab-pane border-top-0" id="changepassword">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="mb-4 main-content-label">
                                    {{ trans('global.change_password') }}
                                </div>
                                <form method="POST" name="change_password" id="change_password" action="{{ route("frontend.profile.password") }}">
                                    @csrf
                                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                        <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                                        <input class="form-control" type="password" name="password" id="password">
                                        @if($errors->has('password'))
                                            <span class="help-block" role="alert">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                                    </div>
                                    <div class="form-group" align="right">
                                        <button class="btn btn-primary" type="submit">
                                            {{ trans('global.save') }}
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
    <!-- row closed -->
<div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="upgradeModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" name="upgrade_platform" id="upgrade_platform" action="{{ route("frontend.profile.upgrade-platform") }}">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="upgradeModalTitle">Upgrade Platform</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select required class="form-control required" name="bot_price" style="width: 100%;" id="botPrice" tabindex="-1" aria-hidden="true">
                    @if(!empty($final_price))
                        @foreach($final_price as $key=>$value)
                            <option value="{{$key . "#" .$value}}">up to {{$key}} bots / €{{$value}} for  platform</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!--Internal  Datepicker js -->
    <script src="{{asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>

    <!--Bootstrap-datepicker js-->
    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>


    <script type="text/javascript">
        $(document).ready(function () {
        $('#datepicker-date').bootstrapdatepicker({
            format: "dd-mm-yyyy",
            viewMode: "date",
        });
        });

        $("#profile_update").validate({
            rules: {
                name: {
                    required: true,
                },
                postcode: {
                    number: true,
                    maxlength: 6
                },
                phone: {
                    customphone: true
                }
            },
            messages: {
                name: {
                    required: 'Please enter your name.',
                },
                postcode: {
                    number: "Please enter correct postcode number.",
                    maxlength: "Please enter maximum 6 digit."
                },
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },

            submitHandler: function (form) {
                var form_data = new FormData(document.getElementById("profile_update"));
                $.ajax({
                    url: '{{ route("frontend.profile.update") }}',
                    type: 'POST',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result.token == 1) {
                            toastr.success(result.message);
                            location.reload();
                        } else {
                            toastr.error(result.message);
                        }

                    }
                });

                return false; // required to block normal submit since you used ajax
            }
        });

        $("#change_password").validate({
            rules: {
                'password': {
                    required: true,
                    custompassword : true,
                    minlength: 8
                },
                'password_confirmation': {
                    required: true,
                    equalTo: '#password'
                },
            },
            messages: {
                'password': {
                    required: "Please enter new password",
                    custompassword : "Must contain minimum 8 Characters, 1 Capital and 1 Special Character",
                    minlength: "Your password must be at least 8 characters long"
                },
                'password_confirmation': {
                    required: "Please re-enter new password",
                    equalTo: "The passwords entered do not match"
                },

            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: '{{ route("frontend.profile.password") }}',
                    data: $('form').serialize(),
                    success: function (res) {
                        if (res.token == 1) {
                            toastr.success(res.message);
                        } else {
                            toastr.error(res.message);
                        }

                    }
                });
            }
        });

        jQuery.validator.addMethod('customphone', function(value) {
            return (value.match(/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}(\s*(ext|x)\s*\.?:?\s*([0-9]+))?$/));
            }, 'Please enter a valid phone number');

        jQuery.validator.addMethod('custompassword', function(value) {
            return (value.match(/^(?=.{8,})(?=.*[A-Z])(?=.*[@#!$%^&+=]).*$/));
            }, 'Must contain minimum 8 Characters, 1 Capital and 1 Special Character');


    </script>
@endsection
