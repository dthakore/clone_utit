<?php

namespace App\Http\Requests;

use App\Models\MtFourTrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMtFourTradeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mt_four_trade_edit');
    }

    public function rules()
    {
        return [
            'close_price' => [
                'numeric',
            ],
            'commission' => [
                'numeric',
            ],
        ];
    }
}
