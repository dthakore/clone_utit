<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BotFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required'
            ],
            'user_exchange_id' => [
                'required'
            ],
            'symbol_id' => [
                'required'
            ],
            'balance' => [
                'required',
                'numeric',
                'min:500'
            ],
            'init_amount' => [
                'numeric',
                'required',
                'min:5',
            ],
            'init_buy_at' => [
                'numeric',
                'max:0',
            ],
            'init_pullback' => [
                'numeric',
                'min:0',
            ],
            'take_profit_average_percentage' => [
                'numeric',
                'required',
                'min:0',
                'max:100',
            ],
            'take_profit_average_retracement' => [
                'numeric',
                'required',
                'min:-100',
                'max:0',
            ],
            'take_profit_independent_cover' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'take_profit_independent_percentage' => [
                'numeric',
                'min:0',
                'max:100',
            ],
            'take_profit_independent_retracement' => [
                'numeric',
                'min:-100',
                'max:0',
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
