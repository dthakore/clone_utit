<?php

namespace App\Http\Requests;

use App\Models\ShipmentInfo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyShipmentInfoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('shipment_info_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:shipment_infos,id',
        ];
    }
}
