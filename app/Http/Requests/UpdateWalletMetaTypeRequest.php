<?php

namespace App\Http\Requests;

use App\Models\WalletMetaType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWalletMetaTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('wallet_meta_type_edit');
    }

    public function rules()
    {
        return [
            'reference_key' => [
                'string',
                'required',
            ],
            'reference_desc' => [
                'string',
                'required',
            ],
            'reference_data' => [
                'string',
                'required',
            ],
        ];
    }
}
