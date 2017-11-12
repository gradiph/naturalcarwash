<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProductUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
			'price' => 'required|integer|min:0',
			'qty' => 'required|integer|min:0',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
			'price.required' => 'Harga tidak boleh kosong',
			'price.integer' => 'Harga harus angka',
			'price.min' => 'Harga tidak boleh kurang dari 0',
			'qty.required' => 'Jumlah tidak boleh kosong',
			'qty.integer' => 'Jumlah harus angka',
			'qty.min' => 'Jumlah tidak boleh kurang dari 0',
		];
	}
}
