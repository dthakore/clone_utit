@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data" id="user-form">
            @csrf
            <h4>Personal Information</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="first_name">{{ trans('cruds.user.fields.first_name') }}</label>
                            <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text" name="first_name" id="first_name" value="{{ old('first_name', '') }}" required>
                            @if($errors->has('first_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.first_name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="middle_name">{{ trans('cruds.user.fields.middle_name') }}</label>
                            <input class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', '') }}">
                            @if($errors->has('middle_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('middle_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.middle_name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="last_name">{{ trans('cruds.user.fields.last_name') }}</label>
                            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last_name" value="{{ old('last_name', '') }}" >
                            @if($errors->has('last_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.last_name_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}"  readonly>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="sponsor_id">{{ trans('cruds.user.fields.sponsor') }}</label>
                            <select class="form-control select2 {{ $errors->has('sponsor') ? 'is-invalid' : '' }}" name="sponsor_id" id="sponsor_id" required>
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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                            <!-- <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div> -->
                            <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles" id="roles" required>
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}" {{ $id == 2 ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('roles') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rank_id">{{ trans('cruds.user.fields.rank') }}</label>
                            <select class="form-control select2 {{ $errors->has('rank') ? 'is-invalid' : '' }}" name="rank_id" id="rank_id">
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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date_of_birth">{{ trans('cruds.user.fields.date_of_birth') }}</label>
                            <input class="form-control date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" >
                            @if($errors->has('date_of_birth'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('date_of_birth') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.date_of_birth_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.user.fields.language') }}</label>
                            <select class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" name="language" id="language">
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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select class="form-control select2 {{ $errors->has('product_id') ? 'is-invalid' : '' }}" name="product_id" id="product_id" >
                                @foreach($products as $id => $entry)
                                    <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('product_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product_id') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.user.fields.gender') }}</label>
                            @foreach(App\Models\User::GENDER_RADIO as $key => $label)
                                <div class="form-check {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="gender_{{ $key }}" name="gender" value="{{ $key }}" {{ old('gender', '1') === (string) $key ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gender_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('gender'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.gender_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Address</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="building_num">{{ trans('cruds.user.fields.building_num') }}</label>
                            <input class="form-control {{ $errors->has('building_num') ? 'is-invalid' : '' }}" type="text" name="building_num" id="building_num" value="{{ old('building_num', '') }}" >
                            @if($errors->has('building_num'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('building_num') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.building_num_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="street">{{ trans('cruds.user.fields.street') }}</label>
                            <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', '') }}" >
                            @if($errors->has('street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.street_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="region">{{ trans('cruds.user.fields.region') }}</label>
                            <input class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" type="text" name="region" id="region" value="{{ old('region', '') }}">
                            @if($errors->has('region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('region') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.region_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="postcode">{{ trans('cruds.user.fields.postcode') }}</label>
                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}" type="text" name="postcode" id="postcode" value="{{ old('postcode', '') }}" >
                            @if($errors->has('postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('postcode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.postcode_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="city">{{ trans('cruds.user.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', '') }}" >
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="country_id">{{ trans('cruds.user.fields.country') }}</label>
                            <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" >
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
                    </div>
                </div>
            </div>
            <h4>Billing Info</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="personal" name="billing_info" value="personal" checked>
                                <label class="form-check-label" for="personal" style="margin-right: 30px;">Personal</label>
                                <input class="form-check-input" type="radio" id="business" name="billing_info" value="business" {{ old('billing_info') === 'business' ? 'checked' : '' }}>
                                <label class="form-check-label" for="business">Business</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row hide business_checked">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="business_name">{{ trans('cruds.user.fields.business_name') }}</label>
                            <input class="form-control {{ $errors->has('business_name') ? 'is-invalid' : '' }}" type="text" name="business_name" id="business_name" value="{{ old('business_name', '') }}">
                            @if($errors->has('business_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('business_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.business_name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="vat_number">{{ trans('cruds.user.fields.vat_number') }}</label>
                            <input class="form-control {{ $errors->has('vat_number') ? 'is-invalid' : '' }}" type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', '') }}">
                            @if($errors->has('vat_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('vat_number') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.vat_number_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="checkbox" id="business_address" name="business_address">
                            <label for="business_address"> Use Different Address</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row hide diff_address">
                <div class="col-md-12">
                    <h4>Business Address</h4>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bus_address_building_num">{{ trans('cruds.user.fields.bus_address_building_num') }}</label>
                            <input class="form-control {{ $errors->has('bus_address_building_num') ? 'is-invalid' : '' }}" type="text" name="bus_address_building_num" id="bus_address_building_num" value="{{ old('bus_address_building_num', '') }}">
                            @if($errors->has('bus_address_building_num'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_building_num') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_building_num_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bus_address_street">{{ trans('cruds.user.fields.bus_address_street') }}</label>
                            <input class="form-control {{ $errors->has('bus_address_street') ? 'is-invalid' : '' }}" type="text" name="bus_address_street" id="bus_address_street" value="{{ old('bus_address_street', '') }}">
                            @if($errors->has('bus_address_street'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_street') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_street_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bus_address_region">{{ trans('cruds.user.fields.bus_address_region') }}</label>
                            <input class="form-control {{ $errors->has('bus_address_region') ? 'is-invalid' : '' }}" type="text" name="bus_address_region" id="bus_address_region" value="{{ old('bus_address_region', '') }}">
                            @if($errors->has('bus_address_region'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_region') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_region_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bus_address_postcode">{{ trans('cruds.user.fields.bus_address_postcode') }}</label>
                            <input class="form-control {{ $errors->has('bus_address_postcode') ? 'is-invalid' : '' }}" type="text" name="bus_address_postcode" id="bus_address_postcode" value="{{ old('bus_address_postcode', '') }}">
                            @if($errors->has('bus_address_postcode'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_postcode') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_postcode_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bus_address_city">{{ trans('cruds.user.fields.bus_address_city') }}</label>
                            <input class="form-control {{ $errors->has('bus_address_city') ? 'is-invalid' : '' }}" type="text" name="bus_address_city" id="bus_address_city" value="{{ old('bus_address_city', '') }}">
                            @if($errors->has('bus_address_city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('bus_address_city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.bus_address_city_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bus_address_country_id">{{ trans('cruds.user.fields.bus_address_country') }}</label>
                            <select class="form-control select2 {{ $errors->has('bus_address_country') ? 'is-invalid' : '' }}" name="bus_address_country_id" id="bus_address_country_id">
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
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="business_phone">{{ trans('cruds.user.fields.business_phone') }}</label>
                            <input class="form-control {{ $errors->has('business_phone') ? 'is-invalid' : '' }}" type="text" name="business_phone" id="business_phone" value="{{ old('business_phone', '') }}">
                            @if($errors->has('business_phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('business_phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.business_phone_helper') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" align="right">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#first_name, #middle_name, #last_name').change(function () {
        var first = $("#first_name").val().replace(/\s+/g, '');
        $("#first_name").val(first);
        var middle = $("#middle_name").val().replace(/\s+/g, '');
        $("#middle_name").val(middle);
        var last = $("#last_name").val().replace(/\s+/g, '');
        $("#last_name").val(last);
        $("#name").val(first + " " + middle+ " " + last);
    });
</script>
@endsection
