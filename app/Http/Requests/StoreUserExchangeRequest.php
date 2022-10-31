<?php

namespace App\Http\Requests;

use App\Models\UserExchange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserExchangeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_exchange_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'key' => [
                'required',
            ],
            'secret' => [
                'required',
            ],
            'exchange_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
