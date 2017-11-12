<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeStoreWashRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required',
            'description' => '',
            'washdescription' => 'required',
            'washing_rate_id' => 'required',
            'mechanic_id' => '',
        ];
    }

	public function messages()
	{
		return [
			'qty.required' => 'Jumlah tidak boleh kosong',
			'qty.integer' => 'Jumlah harus angka',
			'qty.min' => 'Jumlah tidak boleh kurang dari 0',
			'product_id.required' => 'Produk tidak boleh kosong',
			'product_id.exists' => 'Produk tidak ditemukan',
		];
	}
}
