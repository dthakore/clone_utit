<?php

namespace App\Http\Requests;

use App\Models\WalletType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWalletTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_type_edit');
    }

    public function rules()
    {
        return [
            'wallet_type' => [
                'string',
                'required',
            ],
        ];
    }
}
