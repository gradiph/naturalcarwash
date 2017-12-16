<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class HomeAddBeverageRequest extends FormRequest
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
            'qty' => 'required|integer|min:0',
			'product_id' => 'required|exists:products,id',
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
