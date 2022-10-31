
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Expert Request
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-expert-request.update", [$user_expert->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">User</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', isset($user_name->name) ? $user_name->name : '') }}" readonly>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="expert_name">Expert</label>
                            <input class="form-control {{ $errors->has('expert_name') ? 'is-invalid' : '' }}" type="text" name="expert_name" id="expert_name" value="{{ old('expert_name', isset($expert_name->name) ? $expert_name->name : '') }}" readonly>
                            @if($errors->has('expert_name'))
                                <span class="text-danger">{{ $errors->first('expert_name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.userExchange.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status">{{ trans('cruds.userExpertRequest.fields.status') }}</label>
                            <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\UserExpertRequest::STATUS as $key => $label)
                                    <option value="{{ $key }}" {{ (old('status') ? old('status') : $user_expert->status ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            
        </form>
    </div>
</div>



@endsection