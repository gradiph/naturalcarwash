<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProductUpdateRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::check() || (Auth::user()->level->name != 'Admin' && Auth::user()->level->name != 'Kasir'))
        {
            return false;
        }
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
			'type_id' => 'required|exists:product_types,id',
			'price' => 'required|integer|min:0',
			'qty' => 'required|integer|min:0',
			'type' => 'required_if:type_id,1',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
			'type_id.required' => 'Jenis tidak boleh kosong',
			'type_id.exists' => 'Jenis tidak ditemukan',
			'price.required' => 'Harga tidak boleh kosong',
			'price.integer' => 'Harga harus angka',
			'price.min' => 'Harga tidak boleh kurang dari 0',
			'qty.required' => 'Jumlah tidak boleh kosong',
			'qty.integer' => 'Jumlah harus angka',
			'qty.min' => 'Jumlah tidak boleh kurang dari 0',
			'type.required_if' => 'Jenis tidak boleh kosong',
		];
	}
}
