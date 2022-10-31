<?php

namespace App\Http\Requests;

use App\Models\UserPositionAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserPositionAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_position_account_edit');
    }

    public function rules()
    {
        return [];
    }
}
