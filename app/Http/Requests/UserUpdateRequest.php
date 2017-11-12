<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'username' => [
				'required',
				Rule::unique('users')->ignore($this->input('id')),
			],
            'level' => 'required|in:Kasir,Admin',
            'password' => 'required_if:changepassword,1',
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
			'password.required_if' => 'Password tidak boleh kosong',
		];
	}
}
