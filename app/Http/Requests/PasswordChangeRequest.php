<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'newpassword_confirmation' => 'required|same:newpassword',
        ];
    }

	public function messages()
	{
		return [
			'oldpassword.required' => 'Password lama tidak boleh kosong',
			'newpassword.required' => 'Password baru tidak boleh kosong',
			'newpassword_confirmation.required' => 'Konfirmasi password baru tidak boleh kosong',
			'newpassword_confirmation.same' => 'Konfirmasi password baru salah',
		];
	}
}
