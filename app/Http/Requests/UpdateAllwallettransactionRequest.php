<?php

namespace App\Http\Requests;

use App\Models\Allwallettransaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAllwallettransactionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('allwallettransaction_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'wallet_type_id' => [
                'required',
                'integer',
            ],
            'reference_id' => [
                'required',
                'integer',
            ],
            'reference_num' => [
                'string',
                'required',
            ],
            'denomination_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'required',
            ],
        ];
    }
}
