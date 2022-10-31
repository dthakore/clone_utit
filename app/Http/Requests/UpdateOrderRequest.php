<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\OrderPayment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                //'required',
                'integer',
            ],
            'order_status' => [
                'required',
            ],
            'vat' => [
                'string',
                'nullable',
            ],
            'vat_number' => [
                'string',
                'nullable',
            ],
            'building' => [
                'string',
                'nullable',
            ],
            'street' => [
                'string',
                'nullable',
            ],
            'region' => [
                'string',
                'nullable',
            ],
            'postcode' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'country_id' => [
                'nullable',
                'integer',
            ],
            'products.*' => [
                'integer',
            ],
            'products' => [
                //'required',
                //'array',
            ],
            'order_total' => [
                'nullable',
            ],
            'discount' => [
                'string',
                'nullable',
            ],
            'net_total' => [
                'string',
                'nullable',
            ],
            'payment_mode' => [
                'required',
            ],
            'payment_status' => [
                'required',
            ],
            'payment_ref_id' => [
                'required',
            ],
            'payment_date' => [
                'required',
            ],
        ];
    }
}
