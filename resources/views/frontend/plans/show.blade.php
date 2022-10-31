@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.plan.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.plans.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $plan->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $plan->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.is_active') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Plan::IS_ACTIVE_SELECT[$plan->is_active] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.table_name') }}
                                    </th>
                                    <td>
                                        {{ $plan->table_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.action_name') }}
                                    </th>
                                    <td>
                                        {{ $plan->action_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.icon') }}
                                    </th>
                                    <td>
                                        @if($plan->icon)
                                            <a href="{{ $plan->icon->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $plan->icon->getUrl('thumb') }}">
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $plan->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.plan.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $plan->updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.plans.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection