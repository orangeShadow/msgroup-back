<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealUpdateRequest extends FormRequest
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
            'video_acceptance'  => 'nullable|string',
            'video_diagnostics' => 'nullable|string',
            'video_repair'      => 'nullable|string',
            'client_mark'      => 'nullable|integer|min:1|max:5',
            'client_comment'   => 'nullable|string',
            'master_mark'      => 'nullable|integer|min:1|max:5',
            'master_comment'   => 'nullable|string',
            'delay_reason'     => 'nullable|string',
            'status'           => 'nullable|integer|min:0|max:12',
        ];
    }
}
