@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userDocument.title') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-documents.store") }}" enctype="multipart/form-data" id="user-form">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="user_id">{{ trans('cruds.userDocument.fields.name') }}</label>
                            <select class="form-control select_id select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                                <option value="">{{ trans('global.pleaseSelect') }}</option>
                                @foreach($users as $id => $user)
                                    <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">{{ trans('cruds.userDocument.fields.type') }}</label>
                            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                                <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\UserDocument::TYPE as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="account_number">{{ trans('cruds.userDocument.fields.account_number') }}</label>
                            <input class="form-control {{ $errors->has('account_number') ? 'is-invalid' : '' }}" type="text" name="account_number" id="account_number" value="{{ old('account_number', '') }}">
                            @if($errors->has('account_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('account_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.userDocument.fields.user_name') }}</label>
                            <input class="form-control uname {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-info" type="submit">
                            Generate Document
                        </button>
                    </div>
                </div>
            </div>
            
            
        </form>
    </div>
</div>



@endsection
<!-- //select_id -->
@section('scripts')
<script>

$(document).ready(function(e)  {
    $(document).on('change', '.select_id', function(e) {
        var text = $(".select_id option[value='"+e.target.value+"']").text()
        $(".uname").val(text)
        console.log(text)
    });
    
    $("#user-form").validate({
        rules: {
            'account_number': {
                required: true,
                number: true,
            },
        },
        messages: {
            'account_number': {
                required: "Account Number is required",
                number: "Please enter Valid Account Number",
            },
        },
    });
});     
</script>
@endsection