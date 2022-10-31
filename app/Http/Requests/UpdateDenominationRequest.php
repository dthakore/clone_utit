<?php

namespace App\Http\Requests;

use App\Models\Denomination;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDenominationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('denomination_edit');
    }

    public function rules()
    {
        return [
            'denomination_type' => [
                'string',
                'required',
            ],
            'sub_type' => [
                'string',
                'required',
            ],
            'label' => [
                'string',
                'required',
            ],
        ];
    }
}
