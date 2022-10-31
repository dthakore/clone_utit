@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rankRule.title') }}
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
                            {{ trans('cruds.rankRule.fields.id') }}
                        </th>
                        <td>
                            {{ $rankRule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rankRule.fields.rank') }}
                        </th>
                        <td>
                            {{ $rankRule->rank->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rankRule.fields.key') }}
                        </th>
                        <td>
                            {{ $rankRule->key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rankRule.fields.value') }}
                        </th>
                        <td>
                            {{ $rankRule->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rank.fields.comment') }}
                        </th>
                        <td>
                            {{ $rankRule->comment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rankRule.fields.created_at') }}
                        </th>
                        <td>
                            {{ $rankRule->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rankRule.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $rankRule->updated_at }}
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