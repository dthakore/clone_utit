@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userExpertRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.id') }}
                        </th>
                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.user_id') }}
                        </th>
                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.expert_id') }}
                        </th>
                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.created_at') }}
                        </th>
                        <td>
                            
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userExpertRequest.fields.updated_at') }}
                        </th>
                        <td>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection