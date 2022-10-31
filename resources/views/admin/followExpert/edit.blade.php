@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Expert
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.experts.update", [$expert->id]) }}" enctype="multipart/form-data" id="user-form">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.followExpert.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $expert->name) }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="account">{{ trans('cruds.followExpert.fields.account') }}</label>
                            <input class="form-control {{ $errors->has('account') ? 'is-invalid' : '' }}" type="text" name="account" id="account" value="{{ old('account', $expert->account) }}">
                            @if($errors->has('account'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('account') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.type') }}</label>
                            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                                <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::EXPERT_TYPE as $key => $label)
                                    <option value="{{ $key }}" {{ (old('type') ? old('type') : $expert->type ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="agent">{{ trans('cruds.followExpert.fields.agent') }}</label>
                            <input class="form-control {{ $errors->has('agent') ? 'is-invalid' : '' }}" type="text" name="agent" id="agent" value="{{ old('agent', $expert->agent) }}">
                            @if($errors->has('agent'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agent') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="agent_name">{{ trans('cruds.followExpert.fields.agent_name') }}</label>
                            <input class="form-control {{ $errors->has('agent_name') ? 'is-invalid' : '' }}" type="text" name="agent_name" id="agent_name" value="{{ old('agent_name', $expert->agent_name) }}">
                            @if($errors->has('agent_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('agent_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="group">{{ trans('cruds.followExpert.fields.group') }}</label>
                            <input class="form-control {{ $errors->has('group') ? 'is-invalid' : '' }}" type="text" name="group" id="group" value="{{ old('group', $expert->group) }}">
                            @if($errors->has('group'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('group') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.asset_manager') }}</label>
                            <select class="form-control {{ $errors->has('asset_manager') ? 'is-invalid' : '' }}" name="asset_manager" id="asset_manager">
                                <option value disabled {{ old('asset_manager', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::ASSET_MANAGER as $key => $label)
                                    <option value="{{ $key }}" {{ (old('asset_manager') ? old('asset_manager') : $expert->asset_manager ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('asset_manager'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('asset_manager') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.broker') }}</label>
                            <select class="form-control {{ $errors->has('broker') ? 'is-invalid' : '' }}" name="broker" id="broker">
                                <option value disabled {{ old('broker', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::BROKER_TYPE as $key => $label)
                                    <option value="{{ $key }}" {{ (old('broker') ? old('broker') : $expert->broker ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('broker'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('broker') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="minimum_deposit">{{ trans('cruds.followExpert.fields.minimum_deposit') }}</label>
                            <input class="form-control {{ $errors->has('minimum_deposit') ? 'is-invalid' : '' }}" type="text" name="minimum_deposit" id="minimum_deposit" value="{{ old('minimum_deposit', $expert->minimum_deposit) }}">
                            @if($errors->has('minimum_deposit'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('minimum_deposit') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="asset_type">{{ trans('cruds.followExpert.fields.asset_type') }}</label>
                            <input class="form-control {{ $errors->has('asset_type') ? 'is-invalid' : '' }}" type="text" name="asset_type" id="asset_type" value="{{ old('asset_type', $expert->asset_type) }}">
                            @if($errors->has('asset_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('asset_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting">{{ trans('cruds.followExpert.fields.setting') }}</label>
                            <input class="form-control {{ $errors->has('setting') ? 'is-invalid' : '' }}" type="text" name="setting" id="setting" value="{{ old('setting', $expert->setting) }}">
                            @if($errors->has('setting'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('setting') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="total_investors">{{ trans('cruds.followExpert.fields.total_investors') }}</label>
                            <input class="form-control {{ $errors->has('total_investors') ? 'is-invalid' : '' }}" type="text" name="total_investors" id="total_investors" value="{{ old('total_investors', $expert->total_investors) }}">
                            @if($errors->has('total_investors'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_investors') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aum">{{ trans('cruds.followExpert.fields.aum') }}</label>
                            <input class="form-control {{ $errors->has('aum') ? 'is-invalid' : '' }}" type="text" name="aum" id="aum" value="{{ old('aum', $expert->aum) }}">
                            @if($errors->has('aum'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('aum') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.is_forex') }}</label>
                            <select class="form-control {{ $errors->has('is_forex') ? 'is-invalid' : '' }}" name="is_forex" id="is_forex">
                                <option value disabled {{ old('is_forex', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::IS_FOREX as $key => $label)
                                    <option value="{{ $key }}" {{ (old('is_forex') ? old('is_forex') : $expert->is_forex ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('is_forex'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_forex') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.is_verified') }}</label>
                            <select class="form-control {{ $errors->has('is_verified') ? 'is-invalid' : '' }}" name="is_verified" id="is_verified">
                                <option value disabled {{ old('is_verified', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::IS_VERIFIED as $key => $label)
                                    <option value="{{ $key }}" {{ (old('is_verified') ? old('is_verified') : $expert->is_verified ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('is_verified'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_verified') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.is_manual_trader') }}</label>
                            <select class="form-control {{ $errors->has('is_manual_trader') ? 'is-invalid' : '' }}" name="is_manual_trader" id="is_manual_trader">
                                <option value disabled {{ old('is_manual_trader', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::IS_MANUAL_TRADER as $key => $label)
                                    <option value="{{ $key }}" {{ (old('is_manual_trader') ? old('is_manual_trader') : $expert->is_manual_trader ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('is_manual_trader'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_manual_trader') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.followExpert.fields.currency') }}</label>
                            <select class="form-control {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency" id="currency">
                                <option value disabled {{ old('currency', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expert::CURRENCY as $key => $label)
                                    <option value="{{ $key }}" {{ (old('currency') ? old('currency') : $expert->currency ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('currency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('currency') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="performance_fee">{{ trans('cruds.followExpert.fields.performance_fee') }}</label>
                            <input class="form-control {{ $errors->has('performance_fee') ? 'is-invalid' : '' }}" type="text" name="performance_fee" id="performance_fee" value="{{ old('performance_fee', $expert->performance_fee) }}">
                            @if($errors->has('performance_fee'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('performance_fee') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="abs_gain">{{ trans('cruds.followExpert.fields.abs_gain') }}</label>
                            <input class="form-control {{ $errors->has('abs_gain') ? 'is-invalid' : '' }}" type="text" name="abs_gain" id="abs_gain" value="{{ old('abs_gain', $expert->abs_gain) }}">
                            @if($errors->has('abs_gain'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('abs_gain') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="max_dd">{{ trans('cruds.followExpert.fields.max_dd') }}</label>
                            <input class="form-control {{ $errors->has('max_dd') ? 'is-invalid' : '' }}" type="text" name="max_dd" id="max_dd" value="{{ old('max_dd', $expert->max_dd) }}">
                            @if($errors->has('max_dd'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_dd') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <expert-icons expert-icon="{{ $expert_icon }}"></expert-icons>
            
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
<script type="text/javascript">

   Dropzone.autoDiscover = false;

   $(document).ready(function () {
        $(".expertIconsImg").dropzone({
            maxFiles: 2000,
            url: "{{ route('admin.products.storeMedia') }}",
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                console.log(response);
                $('form').find('input[name="photo"]').remove()
                $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
            },
            removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($product) && $product->photo)
      var file = {!! json_encode($product->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo[]" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
        });
        
        $("#user-form").validate({
            rules: {
                'name': {
                    required: true,
                },
                'account': {
                    required: true,
                    number: true,
                },
                'type': {
                    required: true,
                },
            },
            messages: {
                'name': {
                    required: "Name is required",
                },
                'account': {
                    required: "Account Number is required",
                    number: "Please enter Valid Account Number",
                },
                'type': {
                    required: "Please Select Type",
                },
            },
        });
   })
   
</script>
@endsection
