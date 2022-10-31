@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cover.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.covers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cover.fields.id') }}
                        </th>
                        <td>
                            {{ $cover->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cover.fields.bot') }}
                        </th>
                        <td>
                            {{ $cover->bot->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cover.fields.index') }}
                        </th>
                        <td>
                            {{ $cover->index }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cover.fields.cover_percentage') }}
                        </th>
                        <td>
                            {{ $cover->cover_percentage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cover.fields.buy_x_times') }}
                        </th>
                        <td>
                            {{ $cover->buy_x_times }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cover.fields.cover_pullback') }}
                        </th>
                        <td>
                            {{ $cover->cover_pullback }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.covers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection