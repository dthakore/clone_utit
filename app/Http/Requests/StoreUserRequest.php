<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable'
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
                'nullable'
//                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'password' => [
                'required',
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
//                'required',
                'nullable',
            ],
            'building_num' => [
                'string',
                'nullable',
//                'required',
            ],
            'street' => [
                'string',
                'nullable',
//                'required',
            ],
            'region' => [
                'string',
                'nullable',
            ],
            'postcode' => [
                'string',
//                'required',
                'nullable',
            ],
            'city' => [
                'string',
//                'required',
                'nullable'
            ],
            'country_id' => [
//                'required',
                'integer',
                'nullable'
            ],
            'phone' => [
                'string',
//                'required',
                'nullable'
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
            ], */
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
            ], */
            'business_phone' => [
                'string',
                'nullable',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                //'array',
            ],
        ];
    }
}
