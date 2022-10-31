<?php

namespace App\Http\Requests;

use App\Models\UserExchange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserExchangeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_exchange_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'exchange_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
