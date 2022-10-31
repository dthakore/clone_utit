@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.walletMetaType.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.wallet-meta-types.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.walletMetaType.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $walletMetaType->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.walletMetaType.fields.reference_key') }}
                                    </th>
                                    <td>
                                        {{ $walletMetaType->reference_key }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.walletMetaType.fields.reference_desc') }}
                                    </th>
                                    <td>
                                        {{ $walletMetaType->reference_desc }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.walletMetaType.fields.reference_data') }}
                                    </th>
                                    <td>
                                        {{ $walletMetaType->reference_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.walletMetaType.fields.created_at') }}
                                    </th>
                                    <td>
                                        {{ $walletMetaType->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.walletMetaType.fields.updated_at') }}
                                    </th>
                                    <td>
                                        {{ $walletMetaType->updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.wallet-meta-types.index') }}">
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