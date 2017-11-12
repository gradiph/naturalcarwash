<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WashingRateCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
			'price' => 'required|integer',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
			'price.required' => 'Harga tidak boleh kosong',
			'price.integer' => 'Format harga salah',
		];
	}
}
