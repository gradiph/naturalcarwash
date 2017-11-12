<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
			'id' => 'required_without:name,price|exists:products,id',
            'name' => 'required_without:id',
			'price' => 'required_without:id|integer|min:0',
			'qty' => 'required|integer|min:0',
        ];
    }

	public function messages()
	{
		return [
			'id.required_without' => 'ID tidak boleh kosong',
			'name.required_without' => 'Nama tidak boleh kosong',
			'price.required_without' => 'Harga tidak boleh kosong',
			'price.integer' => 'Harga harus angka',
			'price.min' => 'Harga tidak boleh kurang dari 0',
			'qty.required' => 'Jumlah tidak boleh kosong',
			'qty.integer' => 'Jumlah harus angka',
			'qty.min' => 'Jumlah tidak boleh kurang dari 0',
		];
	}
}
