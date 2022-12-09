<?php

namespace App\Http\Requests;

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
        return [
            'dealer_id'             => ['required', 'unique:dealer_approve_rules'],
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
