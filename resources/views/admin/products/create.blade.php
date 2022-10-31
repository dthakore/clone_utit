@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.product.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.products.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="category_id">{{ trans('cruds.product.fields.category') }}</label>
                            <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                                @foreach($categories as $id => $entry)
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.category_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.product.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.name_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="sku">{{ trans('cruds.product.fields.sku') }}</label>
                            <input class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" type="text" name="sku" id="sku" value="{{ old('sku', '') }}" required>
                            @if($errors->has('sku'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sku') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.sku_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="price">{{ trans('cruds.product.fields.price') }}</label>
                            <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01" required>
                            @if($errors->has('price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.price_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="required" for="short_description">{{ trans('cruds.product.fields.short_description') }}</label>
                            <input class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" type="text" name="short_description" id="short_description" value="{{ old('short_description', '') }}" required>
                            @if($errors->has('short_description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('short_description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.short_description_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sale_price">{{ trans('cruds.product.fields.sale_price') }}</label>
                            <input class="form-control {{ $errors->has('sale_price') ? 'is-invalid' : '' }}" type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', '') }}" step="0.01">
                            @if($errors->has('sale_price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sale_price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.sale_price_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tag">{{ trans('cruds.product.fields.tag') }}</label>
                            <input class="form-control {{ $errors->has('tag') ? 'is-invalid' : '' }}" type="text" name="tag" id="tag" value="{{ old('tag', '') }}" step="0.01">
                            @if($errors->has('tag'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tag') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.tag_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.product.fields.is_active') }}</label>
                            <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active">
                                <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Product::IS_ACTIVE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('is_active', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('is_active'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_active') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.is_active_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.product.fields.is_featured') }}</label>
                            <select class="form-control {{ $errors->has('is_featured') ? 'is-invalid' : '' }}" name="is_featured" id="is_featured">
                                <option value disabled {{ old('is_featured', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Product::IS_FEATURE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('is_featured', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('is_featured'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_featured') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.is_featured_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('cruds.product.fields.is_subscription_enabled') }}</label>
                            <select class="form-control {{ $errors->has('is_subscription_enabled') ? 'is-invalid' : '' }}" name="is_subscription_enabled" id="is_subscription_enabled">
                                <option value disabled {{ old('is_subscription_enabled', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Product::IS_SUBSCRIPTION_ENABLED_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('is_subscription_enabled', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('is_subscription_enabled'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('is_subscription_enabled') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.is_subscription_enabled_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="short_description">{{ trans('cruds.product.fields.level_one_affiliate') }}</label>
                            <input class="form-control {{ $errors->has('level_one_affiliate') ? 'is-invalid' : '' }}" type="text" name="level_one_affiliate" id="level_one_affiliate" value="{{ old('level_one_affiliate', '') }}" step="0.01">
                            @if($errors->has('level_one_affiliate'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('level_one_affiliate') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.level_one_affiliate_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="short_description">{{ trans('cruds.product.fields.level_two_affiliate') }}</label>
                            <input class="form-control {{ $errors->has('level_two_affiliate') ? 'is-invalid' : '' }}" type="text" name="level_two_affiliate" id="level_two_affiliate" value="{{ old('level_two_affiliate', '') }}" step="0.01">
                            @if($errors->has('level_two_affiliate'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('level_two_affiliate') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.level_two_affiliate_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sale_start_date">{{ trans('cruds.product.fields.sale_start_date') }}</label>
                            <input class="form-control datetime {{ $errors->has('sale_start_date') ? 'is-invalid' : '' }}" type="text" name="sale_start_date" id="sale_start_date" value="{{ old('sale_start_date') }}">
                            @if($errors->has('sale_start_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sale_start_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.sale_start_date_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="sale_end_date">{{ trans('cruds.product.fields.sale_end_date') }}</label>
                            <input class="form-control datetime {{ $errors->has('sale_end_date') ? 'is-invalid' : '' }}" type="text" name="sale_end_date" id="sale_end_date" value="{{ old('sale_end_date') }}">
                            @if($errors->has('sale_end_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sale_end_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.sale_end_date_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.product.fields.description') }}</label>
                            <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.description_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="photo">{{ trans('cruds.product.fields.photo') }}</label>
                            <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                            </div>
                            @if($errors->has('photo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('photo') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.product.fields.photo_helper') }}</span>
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
    <script src="{{ asset('js/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.editorConfig = function (config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.height = 300;
            config.toolbarCanCollapse = true;

        };
        CKEDITOR.replace('description');
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
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
        console.log(response);
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
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
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
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
