<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DealerApproveRuleRequest extends FormRequest
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
        $rule_dealer_unique = Rule::unique('dealer_approve_rules','dealer_id');
        if($this->method() != 'POST'){
            $rule_dealer_unique->ignore(Request::segment(2),'dealer_id');
        }

        return [
            'dealer_id'             => ['required', $rule_dealer_unique],
            'level_1_min_nominal'   => ['required','numeric'],
            'level_1_position_id'   => ['required'],
            'level_2_min_nominal'   => ['required','numeric'],
            'level_2_position_id'   => ['required'],
            'level_3_min_nominal'   => ['required','numeric'],
            'level_3_position_id'   => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Kolom :attribute harus diisi',
            'unique'    => 'Dealer sudah memiliki rule',
            'numeric'   => 'Kolom :attribute hanya boleh diisi dengan angka',
        ];
    }
}
