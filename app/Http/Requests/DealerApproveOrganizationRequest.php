<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerApproveOrganizationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'dealer_id'         => ['required'],
            'level_1_approval'  => ['required'],
            'level_1_user_id'   => ['required'],
            'level_2_approval'  => ['required'],
            'level_2_user_id'   => ['required'],
            'level_3_approval'  => ['required'],
            'level_3_user_id'   => ['required'],    
        ];
    }
}
