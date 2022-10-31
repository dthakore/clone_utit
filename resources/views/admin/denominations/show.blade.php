@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.denomination.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.denominations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.denomination.fields.id') }}
                        </th>
                        <td>
                            {{ $denomination->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.denomination.fields.denomination_type') }}
                        </th>
                        <td>
                            {{ $denomination->denomination_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.denomination.fields.sub_type') }}
                        </th>
                        <td>
                            {{ $denomination->sub_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.denomination.fields.label') }}
                        </th>
                        <td>
                            {{ $denomination->label }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.denomination.fields.currency') }}
                        </th>
                        <td>
                            {{ $denomination->currency }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.denominations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection