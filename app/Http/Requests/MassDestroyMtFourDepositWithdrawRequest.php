<?php

namespace App\Http\Requests;

use App\Models\MtFourDepositWithdraw;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMtFourDepositWithdrawRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('mt_four_deposit_withdraw_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:mt_four_deposit_withdraws,id',
        ];
    }
}
