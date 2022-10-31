@extends('layouts.frontend-new')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="POST" action="{{ route("frontend.profile.update") }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            {{ trans('global.my_profile') }}
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="country_id">{{ trans('cruds.user.fields.country') }}</label>
                                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                                    @foreach($countries as $id => $entry)
                                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $user->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('country'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('country') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title">{{ trans('cruds.user.fields.phone') }}</label>
                                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
                                @if($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                            {{--@if ()--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="sponsor_id">{{ trans('cruds.user.fields.sponsor') }} <br/><b>{{ $user->sponsor->name }} | {{ $user->sponsor->id }}</b></label>--}}
                            {{--</div>--}}
                            {{--@else--}}
                            {{--No sponsor--}}
                            {{--@endif--}}
                            <div class="form-group" align="right">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ trans('global.primary_address') }}
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="building_num">{{ trans('cruds.user.fields.building_num') }}</label>
                                <input class="form-control {{ $errors->has('building_num') ? 'is-invalid' : '' }}" type="text" name="building_num" id="building_num" value="{{ old('building_num', $user->building_num) }}">
                                @if($errors->has('building_num'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('building_num') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="street">{{ trans('cruds.user.fields.street') }}</label>
                                <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $user->street) }}">
                                @if($errors->has('street'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('street') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="region">{{ trans('cruds.user.fields.region') }}</label>
                                <input class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" type="text" name="region" id="region" value="{{ old('region', $user->region) }}">
                                @if($errors->has('region'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('region') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="postcode">{{ trans('cruds.user.fields.postcode') }}</label>
                                <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', $user->postcode) }}">
                                @if($errors->has('postcode'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('postcode') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="city">{{ trans('cruds.user.fields.city') }}</label>
                                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $user->city) }}">
                                @if($errors->has('city'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('city') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group" align="right">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                @can('profile_delete_account')
                    <div class="card">
                        <div class="card-header">
                            {{ trans('global.delete_account') }}
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route("frontend.profile.destroy") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                                @csrf
                                <div class="form-group" align="right">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.delete') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endcan
                @can('profile_two_factor')
                    @if(Route::has('frontend.profile.toggle-two-factor'))
                        <div class="card">
                            <div class="card-header">
                                {{ trans('global.two_factor.title') }}
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route("frontend.profile.toggle-two-factor") }}">
                                    @csrf
                                    <div class="form-group" align="right">
                                        <button class="btn btn-danger" type="submit">
                                            {{ auth()->user()->two_factor ? trans('global.two_factor.disable') : trans('global.two_factor.enable') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endcan
                @if(!empty($platform))
                    <div class="card mb-2">
                        <div class="card-header">
                            My Referral link
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <p class="form-control">{{ url('/').'/'.auth()->user()->id }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header">
                            Current active subscription
                        </div>
                        <div class="card-body">
                            <div>
                                <p>Trading platform license for <b>{{ $bot . ' bots'}}</b></p>
                                <p>License key  -  {{ $platform->licence_key }} </p>
                                <p>Expires on -  {{ $platform->cycle_end_at }} </p>
                                @if($platform->cycle_end_at < date('Y-m-d H:i:s') || ($bot != 35))
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#upgradeModal">
                                        Upgrade
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="upgradeModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route("frontend.profile.upgrade-platform") }}">
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
