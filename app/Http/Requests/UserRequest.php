<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->id) {
            return [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'nullable|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/',
                'confirmed_password' => 'nullable|required_with:password|same:password',
                'role' => 'required',
            ];
        }

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/',
            'confirmed_password' => 'required|same:password',
            'role' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Username harus di isi',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email harus sesuai format',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role harus di isi',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password harus minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka',
            'confirmed_password.required' => 'Confirmasi Password harus di isi',
            'confirmed_password.same' => 'Confirmasi Password harus sama dengan password',
        ];
    }
}
