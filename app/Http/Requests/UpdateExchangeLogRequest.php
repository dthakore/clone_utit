<?php

namespace App\Http\Requests;

use App\Models\ExchangeLog;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExchangeLogRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('exchange_log_edit');
    }

    public function rules()
    {
        return [];
    }
}
