<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatsRequest extends FormRequest
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
            'year' => 'required|integer',
            'month' => 'integer',
            'master_id' => 'integer',
            'manufacturer_id' => 'required|integer',
            'model_id'        => 'required|integer',
            'condition_id'    => 'required|integer',
            'malfunction_id' => 'required|integer',
            'point_a_id' => 'required|integer',
            'point_b_id' => 'required|integer',
            'serial'   => 'required|string',
            'password' => 'string',
            'dev_id'          => 'string',
            'dev_id_password' => 'string',
            'completeness' => 'string',
            'surname'    => 'string',
            'name'       => 'string',
            'patronymic' => 'string',
            'phone' => 'string',
            'email' => 'string',
            'notification_type' => 'required|integer',
            'verify_token' => 'string',
        ];
    }
}
