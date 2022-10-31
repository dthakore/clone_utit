<?php

namespace App\Http\Requests;

use App\Models\MtFourTrade;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMtFourTradeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('mt_four_trade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:mt_four_trades,id',
        ];
    }
}
