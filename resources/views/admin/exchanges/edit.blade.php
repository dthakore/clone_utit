@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.exchange.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.exchanges.update", [$exchange->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.exchange.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $exchange->name) }}" required>
                            @if($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.exchange.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="slug">{{ trans('cruds.exchange.fields.slug') }}</label>
                            <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $exchange->slug) }}" required>
                            @if($errors->has('slug'))
                                <span class="text-danger">{{ $errors->first('slug') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.exchange.fields.slug_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $exchange->status || old('status', 0) === 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">{{ trans('cruds.exchange.fields.status') }}</label>
                            </div>
                            @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.exchange.fields.status_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('is_visible') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="is_visible" value="0">
                                <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible" value="1" {{ $exchange->is_visible || old('is_visible', 0) === 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_visible">{{ trans('cruds.exchange.fields.is_visible') }}</label>
                            </div>
                            @if($errors->has('is_visible'))
                                <span class="text-danger">{{ $errors->first('is_visible') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.exchange.fields.is_visible_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tags">{{ trans('cruds.exchange.fields.tags') }}</label>
                            <input class="form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}" type="text" name="tags" id="tags" value="{{ old('tags', $exchange->tags) }}">
                            @if($errors->has('tags'))
                                <span class="text-danger">{{ $errors->first('tags') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.exchange.fields.tags_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="logo">{{ trans('cruds.exchange.fields.logo') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                            </div>
                            @if($errors->has('logo'))
                                <span class="text-danger">{{ $errors->first('logo') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.exchange.fields.logo_helper') }}</span>
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
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.exchanges.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($exchange) && $exchange->logo)
      var file = {!! json_encode($exchange->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
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
}
</script>
@endsection