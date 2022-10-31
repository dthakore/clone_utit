<?php

namespace App\Http\Requests;

use App\Models\OrderCreditMemo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOrderCreditMemoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_credit_memo_create');
    }

    public function rules()
    {
        return [];
    }
}
