<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $rule_dealer_unique = Rule::unique('dealer_approve_organizations','dealer_id');
        if($this->method() != 'POST'){
            $rule_dealer_unique->ignore(Request::segment(2),'dealer_id');
        }
        
        return [
            'dealer_id'         => ['required',$rule_dealer_unique],
            'level_1_approval'  => ['required'],
            'level_1_user_id'   => ['required'],
            'level_2_approval'  => ['required'],
            'level_2_user_id'   => ['required'],
            'level_3_approval'  => ['required'],
            'level_3_user_id'   => ['required'],    
        ];
    }
}
