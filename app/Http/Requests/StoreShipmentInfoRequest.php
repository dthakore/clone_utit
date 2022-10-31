<?php

namespace App\Http\Requests;

use App\Models\ShipmentInfo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreShipmentInfoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shipment_info_create');
    }

    public function rules()
    {
        return [
            'order' => [
                'string',
                'nullable',
            ],
            'shipment_number' => [
                'string',
                'nullable',
            ],
            'products.*' => [
                'integer',
            ],
            'products' => [
                'array',
            ],
            'tracking_number' => [
                'string',
                'nullable',
            ],
        ];
    }
}
