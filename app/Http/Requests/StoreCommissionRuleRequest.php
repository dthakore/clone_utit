<?php

namespace App\Http\Requests;

use App\Models\CommissionRule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCommissionRuleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('commission_rule_create');
    }

    public function rules()
    {
        return [
            'commission_plan_id' => [
                'required',
                'integer',
            ],
            'user_level' => [
                'required',
            ],
            'rank_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'numeric',
                'required',
            ],
            'wallet_type_id' => [
                'required',
                'integer',
            ],
            'wallet_reference_id' => [
                'required',
                'integer',
            ],
            'denomination_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
