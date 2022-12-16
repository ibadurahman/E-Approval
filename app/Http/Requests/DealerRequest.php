<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DealerRequest extends FormRequest
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
        $rule_dealer_unique = Rule::unique('dealers','code');
        if($this->method() != 'POST'){
            $rule_dealer_unique->ignore(Request::segment(2));
        }
        
        return [
            'code'      => ['required',$rule_dealer_unique,'numeric'],
            'name'      => ['required','min:3'],
            'address'   => ['required','min:10'],
            'phone'     => ['required','numeric'],
            'email'     => ['required','email'],
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Kolom :attribute harus diisi',
            'unique'    => 'Kode telah digunakan',
            'email'     => 'Format e-mail tidak sesuai',
            'numeric'   => 'Kolom :attribute hanya boleh diisi dengan angka',
            'min:3'     => 'Kolom :attribute harus diisi minimal 3 karakter',
            'min:10'    => 'Kolom :attribute harus diisi minimal 10 karakter',
        ];
    }
}
