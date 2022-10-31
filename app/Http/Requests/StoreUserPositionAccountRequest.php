<?php

namespace App\Http\Requests;

use App\Models\UserPositionAccount;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserPositionAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_position_account_create');
    }

    public function rules()
    {
        return [];
    }
}
