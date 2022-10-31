@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.rank.title') }}
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="card">
                <ul class="nav nav-tabs mb-2" role="tablist" id="relationship-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#rank-tab" role="tab" data-toggle="tab">
                            {{ trans('cruds.rank.title_singular') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#rank-rules-tab" role="tab" data-toggle="tab">
                            {{ trans('cruds.rankRule.title_singular') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="rank-tab">
                        @include('admin.ranks.index')
                    </div>
                    <div class="tab-pane" role="tabpanel" id="rank-rules-tab">
                        @include('admin.rankRule.index')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection