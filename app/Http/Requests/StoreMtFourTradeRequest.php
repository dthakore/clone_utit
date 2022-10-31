<?php

namespace App\Http\Requests;

use App\Models\MtFourTrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMtFourTradeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mt_four_trade_create');
    }

    public function rules()
    {
        return [
            'commission' => [
                'numeric',
            ],
        ];
    }
}
