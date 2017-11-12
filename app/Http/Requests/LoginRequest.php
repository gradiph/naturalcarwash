<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|exists:users,username',
			'password' => 'required',
        ];
    }

	public function messages()
	{
		return [
			'username.required' => 'Username tidak boleh kosong',
			'username.exists' => 'Username tidak ditemukan',
			'password.required' => 'Password tidak boleh kosong',
		];
	}
}
