<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'      => ['required','min:3'],
            'email'     => ['required','email','unique:users'],
            'phone'     => ['required','numeric'],
            'dealer'    => ['required'],
            'is_active' => ['required'],
            'sign'      => ['image','mimes:png','max:5120']
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Kolom :attribute harus diisi',
            'unique'    => 'E-mail sudah digunakan',
            'email'     => 'Format e-mail tidak sesuai',
            'numeric'   => 'Kolom :attribute hanya boleh diisi dengan angka',
            'min'       => 'Kolom :attribute harus diisi minimal 3 karakter',
            'image'     => 'Sign harus dalam format gambar (.png)',
            'mimes'     => 'Sign harus dalam format .png',
            'size'      => 'Ukuran gambar tidak boleh melebihi 5120 KB'
        ];
    }
}
