<?php

namespace App\Http\Requests;

use App\Models\MtFourBroker;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMtFourBrokerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('mt_four_broker_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'server_login' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'server_password' => [
                'string',
                'required',
            ],
            'server_address' => [
                'string',
                'required',
            ],
            'server_port' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'agent' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'location' => [
                'string',
                'nullable',
            ],
        ];
    }
}
