<?php

namespace App\Http\Requests;

use App\Models\MtFourBroker;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMtFourBrokerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('mt_four_broker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:mt_four_brokers,id',
        ];
    }
}
