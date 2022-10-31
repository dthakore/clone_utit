<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Nullable;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'phone' => ["nullable"],
            'country_id' => ["nullable"],
            'building_num' => ["nullable"],
            'street'   => ["nullable"],
            'region'   => ["nullable"],
            'postcode' => ["nullable"],
            'city'     => ["nullable"],
            'business_name'     => ["nullable"],
            'vat_number'     => ["nullable"],
            'date_of_birth'     => ["nullable"],
        ];
    }
}
