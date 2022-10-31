<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
                //'required',
            ],
            'first_name' => [
                'string',
                'required',
            ],
            'middle_name' => [
                'string',
                'nullable',
            ],
            'last_name' => [
                'string',
                'nullable',
//                'required',
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'sponsor_id' => [
                'required',
                'integer',
            ],
            'date_of_birth' => [
//                'required',
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'language' => [
                'nullable',
//                'required',
            ],
            'building_num' => [
                'nullable',
                'string',
//                'required',
            ],
            'street' => [
                'nullable',
                'string',
//                'required',
            ],
            'region' => [
                'string',
                'nullable',
            ],
            'postcode' => [
                'string',
                'nullable',
//                'required',
            ],
            'city' => [
                'string',
                'nullable',
//                'required',
            ],
            'country_id' => [
//                'required',
                'nullable',
                'integer',
            ],
            'phone' => [
                'string',
                'nullable',
//                'required',
            ],
            'vat_number' => [
                'string',
                'nullable',
            ],
            /*'business_name' => [
                'string',
                'required',
            ],
            'bus_address_building_num' => [
                'string',
                'required',
            ],
            'bus_address_street' => [
                'string',
                'required',
            ],*/
            'bus_address_region' => [
                'string',
                'nullable',
            ],
            /*'bus_address_city' => [
                'string',
                'required',
            ],
            'bus_address_postcode' => [
                'string',
                'required',
            ],
            'bus_address_country_id' => [
                'required',
                'integer',
            ],*/
            'business_phone' => [
                'string',
                'nullable',
            ],
            'roles.*' => [
                'integer',
                'nullable',
            ],
            'roles' => [
                'nullable',
//                'required',
                //'array',
            ],
        ];
    }
}
