<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTriggerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => ['required'],
            'description' => ['required'],
            'wire' => ['required', 'gte:1', 'lte:10', 'integer'],
            'trigger_voltage' => ['required', "boolean"],
            'email_notify' => ['required', "boolean"],
            'device_id' => ['required'],
        ];
    }
}
