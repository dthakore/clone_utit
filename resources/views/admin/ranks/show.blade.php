@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rank.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settings.ranks') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.id') }}
                        </th>
                        <td>
                            {{ $rank->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.name') }}
                        </th>
                        <td>
                            {{ $rank->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.icon') }}
                        </th>
                        <td>
                            @if($rank->icon)
                                <a href="{{ $rank->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $rank->icon->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.description') }}
                        </th>
                        <td>
                            {{ $rank->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.user_paid_out') }}
                        </th>
                        <td>
                            {{ $rank->user_paid_out }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.abbreviation') }}
                        </th>
                        <td>
                            {{ $rank->abbreviation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.level') }}
                        </th>
                        <td>
                            {{ $rank->level }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settings.ranks') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection