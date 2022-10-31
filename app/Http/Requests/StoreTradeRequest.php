<?php

namespace App\Http\Requests;

use App\Models\Trade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTradeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('trade_create');
    }

    public function rules()
    {
        return [
            'bot_id' => [
                'required',
                'integer',
            ],
            'requested_amount' => [
                'numeric',
                'required',
            ],
            'side' => [
                'required',
            ],
            'comment' => [
                'string',
                'nullable',
            ],
            'failure_reason' => [
                'string',
                'nullable',
            ],
            'exchange_order_status' => [
                'string',
                'nullable',
            ],
            'original_orders' => [
                'string',
                'nullable',
            ],
            'exchange_order_ref' => [
                'string',
                'nullable',
            ],
            'exchange_trade_ref' => [
                'string',
                'nullable',
            ],
            'requested_price' => [
                'numeric',
                'required',
            ],
            'requested_quantity' => [
                'numeric',
                'required',
            ],
            'executed_price' => [
                'numeric',
                'required',
            ],
            'executed_amount' => [
                'numeric',
                'required',
            ],
            'executed_quantity' => [
                'numeric',
                'required',
            ],
            'status' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
