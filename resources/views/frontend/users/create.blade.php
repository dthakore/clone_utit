@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.users.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="first_name">{{ trans('cruds.user.fields.first_name') }}</label>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', '') }}" required>
                            @if($errors->has('first_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.first_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">{{ trans('cruds.user.fields.middle_name') }}</label>
                            <input class="form-control" type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', '') }}">
                            @if($errors->has('middle_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('middle_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.middle_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="last_name">{{ trans('cruds.user.fields.last_name') }}</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{ old('last_name', '') }}" required>
                            @if($errors->has('last_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.last_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control" type="password" name="password" id="password" required>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="sponsor_id">{{ trans('cruds.user.fields.sponsor') }}</label>
                            <select class="form-control select2" name="sponsor_id" id="sponsor_id" required>
                                @foreach($sponsors as $id => $entry)
                                    <option value="{{ $id }}" {{ old('sponsor_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('sponsor'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sponsor') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.sponsor_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="date_of_birth">{{ trans('cruds.user.fields.date_of_birth') }}</label>
                            <input class="form-control date" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required>
                            @if($errors->has('date_of_birth'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date_of_birth') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.date_of_birth_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.user.fields.gender') }}</label>
                            @foreach(App\Models\User::GENDER_RADIO as $key => $label)
                                <div>
                                    <input type="radio" id="gender_{{ $key }}" name="gender" value="{{ $key }}" {{ old('gender', '1') === (string) $key ? 'checked' : '' }}>
                                    <label for="gender_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('gender'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.gender_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.user.fields.language') }}</label>
                            <select class="form-control" name="language" id="language" required>
                                <option value disabled {{ old('language', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\User::LANGUAGE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('language', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('language'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('language') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.language_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="building_num">{{ trans('cruds.user.fields.building_num') }}</label>
                            <input class="form-control" type="text" name="building_num" id="building_num" value="{{ old('building_num', '') }}" required>
                            @if($errors->has('building_num'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('building_num') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.building_num_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="street">{{ trans('cruds.user.fields.street') }}</label>
                            <input class="form-control" type="text" name="street" id="street" value="{{ old('street', '') }}" required>
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.street_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="region">{{ trans('cruds.user.fields.region') }}</label>
                            <input class="form-control" type="text" name="region" id="region" value="{{ old('region', '') }}">
                            @if($errors->has('region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('region') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.region_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="postcode">{{ trans('cruds.user.fields.postcode') }}</label>
                            <input class="form-control" type="text" name="postcode" id="postcode" value="{{ old('postcode', '') }}" required>
                            @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.postcode_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.user.fields.city') }}</label>
                            <input class="form-control" type="text" name="city" id="city" value="{{ old('city', '') }}" required>
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="country_id">{{ trans('cruds.user.fields.country') }}</label>
                            <select class="form-control select2" name="country_id" id="country_id" required>
                                @foreach($countries as $id => $entry)
                                    <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.country_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="business_name">{{ trans('cruds.user.fields.business_name') }}</label>
                            <input class="form-control" type="text" name="business_name" id="business_name" value="{{ old('business_name', '') }}" required>
                            @if($errors->has('business_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('business_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.business_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="vat_number">{{ trans('cruds.user.fields.vat_number') }}</label>
                            <input class="form-control" type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', '') }}">
                            @if($errors->has('vat_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vat_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.vat_number_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="bus_address_building_num">{{ trans('cruds.user.fields.bus_address_building_num') }}</label>
                            <input class="form-control" type="text" name="bus_address_building_num" id="bus_address_building_num" value="{{ old('bus_address_building_num', '') }}" required>
                            @if($errors->has('bus_address_building_num'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_building_num') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_building_num_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="bus_address_street">{{ trans('cruds.user.fields.bus_address_street') }}</label>
                            <input class="form-control" type="text" name="bus_address_street" id="bus_address_street" value="{{ old('bus_address_street', '') }}" required>
                            @if($errors->has('bus_address_street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_street_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="bus_address_region">{{ trans('cruds.user.fields.bus_address_region') }}</label>
                            <input class="form-control" type="text" name="bus_address_region" id="bus_address_region" value="{{ old('bus_address_region', '') }}">
                            @if($errors->has('bus_address_region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_region') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_region_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="bus_address_city">{{ trans('cruds.user.fields.bus_address_city') }}</label>
                            <input class="form-control" type="text" name="bus_address_city" id="bus_address_city" value="{{ old('bus_address_city', '') }}" required>
                            @if($errors->has('bus_address_city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="bus_address_postcode">{{ trans('cruds.user.fields.bus_address_postcode') }}</label>
                            <input class="form-control" type="text" name="bus_address_postcode" id="bus_address_postcode" value="{{ old('bus_address_postcode', '') }}" required>
                            @if($errors->has('bus_address_postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_postcode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_postcode_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="bus_address_country_id">{{ trans('cruds.user.fields.bus_address_country') }}</label>
                            <select class="form-control select2" name="bus_address_country_id" id="bus_address_country_id" required>
                                @foreach($bus_address_countries as $id => $entry)
                                    <option value="{{ $id }}" {{ old('bus_address_country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('bus_address_country'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_country') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_country_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="business_phone">{{ trans('cruds.user.fields.business_phone') }}</label>
                            <input class="form-control" type="text" name="business_phone" id="business_phone" value="{{ old('business_phone', '') }}">
                            @if($errors->has('business_phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('business_phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.business_phone_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="roles[]" id="roles" multiple required>
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('roles') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="rank_id">{{ trans('cruds.user.fields.rank') }}</label>
                            <select class="form-control select2" name="rank_id" id="rank_id">
                                @foreach($ranks as $id => $entry)
                                    <option value="{{ $id }}" {{ old('rank_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('rank'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('rank') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.rank_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection