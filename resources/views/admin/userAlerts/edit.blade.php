@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.userAlert.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-alerts.update", [$userAlert->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="alert_text">{{ trans('cruds.userAlert.fields.alert_text') }}</label>
                <input class="form-control {{ $errors->has('alert_text') ? 'is-invalid' : '' }}" type="text" name="alert_text" id="alert_text" value="{{ old('alert_text', $userAlert->alert_text) }}" required>
                @if($errors->has('alert_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alert_text') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="alert_link">{{ trans('cruds.userAlert.fields.alert_link') }}</label>
                <input class="form-control {{ $errors->has('alert_link') ? 'is-invalid' : '' }}" type="text" name="alert_link" id="alert_link" value="{{ old('alert_link', $userAlert->alert_link) }}" required>
                @if($errors->has('alert_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alert_link') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.userAlert.fields.show_hide') }}</label>
                <select class="form-control {{ $errors->has('show_hide') ? 'is-invalid' : '' }}" name="show_hide" id="show_hide">
                    <option value disabled {{ old('show_hide', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\UserAlert::SHOW_HIDE as $key => $label)
                        <option value="{{ $key }}" {{ (old('show_hide') ? old('show_hide') : $userAlert->show_hide ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('show_hide'))
                    <div class="invalid-feedback">
                        {{ $errors->first('show_hide') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="type">{{ trans('cruds.userAlert.fields.type') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type[]" id="type" multiple>
                    @foreach(App\Models\UserAlert::TYPE as $id => $lable)
                        <option value="{{ $id }}" {{ in_array($id, old('type', explode(", ", $userAlert->type))) ? 'selected' : '' }}>{{ $lable }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="users">{{ trans('cruds.userAlert.fields.user') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users" multiple>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ (in_array($id, old('users', [])) || $userAlert->users->contains($id)) ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @if($errors->has('users'))
                    <div class="invalid-feedback">
                        {{ $errors->first('users') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection