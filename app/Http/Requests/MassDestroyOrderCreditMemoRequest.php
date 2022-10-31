<?php

namespace App\Http\Requests;

use App\Models\OrderCreditMemo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOrderCreditMemoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('order_credit_memo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:order_credit_memos,id',
        ];
    }
}
