@extends('layouts.admin')
@section('styles')
<style>
    a{
        color: #28a118;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        Show Product
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#basic_info" role="tab" data-toggle="tab">
                Basic Info
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#plan_feature" role="tab" data-toggle="tab">
                Plan Feature
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="basic_info">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.id') }}
                                </th>
                                <td>
                                    {{ $product->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.name') }}
                                </th>
                                <td>
                                    {{ $product->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.sku') }}
                                </th>
                                <td>
                                    {{ $product->sku }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.price') }}
                                </th>
                                <td>
                                    {{ $product->price }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.short_description') }}
                                </th>
                                <td>
                                    {{ $product->short_description }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.description') }}
                                </th>
                                <td>
                                    {!! $product->description !!}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.agent') }}
                                </th>
                                <td>
                                    {{ $product->agent }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.licenses') }}
                                </th>
                                <td>
                                    {{ $product->licenses }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.tag') }}
                                </th>
                                <td>
                                    {{ $product->tag }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.is_active') }}
                                </th>
                                <td>
                                    {{ App\Models\Product::IS_ACTIVE_SELECT[$product->is_active] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.is_featured') }}
                                </th>
                                <td>
                                    {{ App\Models\Product::IS_FEATURE_SELECT[$product->is_featured] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.level_one_affiliate') }}
                                </th>
                                <td>
                                    {{ $product->level_one_affiliate }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.level_two_affiliate') }}
                                </th>
                                <td>
                                    {{ $product->level_two_affiliate }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.is_delete') }}
                                </th>
                                <td>
                                    {{ $product->is_delete }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.is_subscription_enabled') }}
                                </th>
                                <td>
                                    {{ App\Models\Product::IS_SUBSCRIPTION_ENABLED_SELECT[$product->is_subscription_enabled] ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.sale_price') }}
                                </th>
                                <td>
                                    {{ $product->sale_price }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.sale_start_date') }}
                                </th>
                                <td>
                                    {{ $product->sale_start_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.sale_end_date') }}
                                </th>
                                <td>
                                    {{ $product->sale_end_date }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.photo') }}
                                </th>
                                <td>
                                    @if($product->photo)
                                        <a href="{{ $product->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $product->photo->getUrl('thumb') }}">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.category') }}
                                </th>
                                <td>
                                    {{ $product->category->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.created_at') }}
                                </th>
                                <td>
                                    {{ $product->created_at }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.product.fields.updated_at') }}
                                </th>
                                <td>
                                    {{ $product->updated_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="plan_feature">
            @includeIf('admin.products.subscriptionMeta', ['subscriptionMeta' => $product->subscriptionMeta])
        </div>
    </div>
</div>

@endsection
