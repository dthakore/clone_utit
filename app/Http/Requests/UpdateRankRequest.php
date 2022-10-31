<?php

namespace App\Http\Requests;

use App\Models\Rank;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRankRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rank_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'required',
            ],
            'abbreviation' => [
                'string',
                'required',
            ],
        ];
    }
}
