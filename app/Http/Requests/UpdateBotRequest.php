<?php

namespace App\Http\Requests;

use App\Models\Bot;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBotRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bot_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'user_exchange_id' => [
                'required',
                'integer',
            ],
            'symbol_id' => [
                'required',
                'integer',
            ],
            'balance' => [
                'required',
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
                'min:-2147483648',
                'max:2147483647',
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
            ],
            'active_sessions.*' => [
                'integer',
            ],
            'active_sessions' => [
                'array',
            ],
        ];
    }
}
