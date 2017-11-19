<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::check() || Auth::user()->level->name != 'Admin')
        {
            return false;
        }
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
            'level_id' => 'required|integer',
            'password' => 'required_if:changepassword,1',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
			'username.required' => 'Username tidak boleh kosong',
			'username.unique' => 'Username telah digunakan',
			'level_id.required' => 'Jabatan tidak boleh kosong',
			'level_id.integer' => 'Jabatan salah',
			'password.required_if' => 'Password tidak boleh kosong',
		];
	}
}
