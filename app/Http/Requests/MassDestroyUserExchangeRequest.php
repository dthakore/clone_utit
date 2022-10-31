<?php

namespace App\Http\Requests;

use App\Models\UserExchange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserExchangeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_exchange_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:user_exchanges,id',
        ];
    }
}
