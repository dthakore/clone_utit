<?php

namespace App\Http\Requests;

use App\Models\Exchange;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreExchangeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('exchange_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'required',
            ],
            'tags' => [
                'string',
                'nullable',
            ],
        ];
    }
}
