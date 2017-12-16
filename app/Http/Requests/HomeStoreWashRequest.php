<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class HomeStoreWashRequest extends FormRequest
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
