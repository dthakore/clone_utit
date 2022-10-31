<?php

namespace App\Http\Requests;

use App\Models\Allwallettransaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAllwallettransactionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('allwallettransaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:all_wallet_transactions,id',
        ];
    }
}
