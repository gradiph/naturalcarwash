<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserCreateRequest extends FormRequest
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
            'username' => 'required|unique:users,username',
            'level_id' => 'required|integer',
            'password' => 'required',
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
			'password.required' => 'Password tidak boleh kosong',
		];
	}
}
