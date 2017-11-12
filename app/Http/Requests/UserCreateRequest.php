<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'level' => 'required|in:Kasir,Admin',
            'password' => 'required',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
			'username.required' => 'Username tidak boleh kosong',
			'username.unique' => 'Username telah digunakan',
			'level.required' => 'Jabatan tidak boleh kosong',
			'level.in' => 'Jabatan salah',
			'password.required' => 'Password tidak boleh kosong',
		];
	}
}
