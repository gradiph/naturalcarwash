<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MechanicCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
		];
	}
}
