<?php

namespace App\Http\Requests;

use App\Models\CbmMtFourAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCbmMtFourAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cbm_mt_four_account_create');
    }

    public function rules()
    {
        return [];
    }
}
