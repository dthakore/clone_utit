<?php

namespace App\Http\Requests;

use App\Models\Cover;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCoverRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cover_edit');
    }

    public function rules()
    {
        return [
            'index' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'cover_percentage' => [
                'numeric',
                'min:-100',
                'max:0',
            ],
            'buy_x_times' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'cover_pullback' => [
                'numeric',
                'min:0',
                'max:100',
            ],
        ];
    }
}
