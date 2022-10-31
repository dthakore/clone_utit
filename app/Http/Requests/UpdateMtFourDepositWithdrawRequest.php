<?php

namespace App\Http\Requests;

use App\Models\MtFourDepositWithdraw;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMtFourDepositWithdrawRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mt_four_deposit_withdraw_edit');
    }

    public function rules()
    {
        return [];
    }
}
