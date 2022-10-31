<?php

namespace App\Http\Requests;

use App\Models\Symbol;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSymbolRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('symbol_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
