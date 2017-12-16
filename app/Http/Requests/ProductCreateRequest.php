<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ProductCreateRequest extends FormRequest
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
            'name' => 'required_without:id',
			'type_id' => 'required_without:id|exists:product_types,id',
			'price' => 'required_without:id|integer|min:0',
			'qty' => 'required|integer|min:0',
			'type' => 'required_without_all:id,type_id|required_if:type_id,1',
			'id' => 'required_without_all:name,type_id,price|nullable|exists:products,id',
        ];
    }

	public function messages()
	{
		return [
			'name.required_without' => 'Nama tidak boleh kosong',
			'type_id.required_without' => 'Jenis tidak boleh kosong',
			'type_id.exists' => 'Jenis tidak ditemukan',
			'price.required_without' => 'Harga tidak boleh kosong',
			'price.integer' => 'Harga harus angka',
			'price.min' => 'Harga tidak boleh kurang dari 0',
			'qty.required' => 'Jumlah tidak boleh kosong',
			'qty.integer' => 'Jumlah harus angka',
			'qty.min' => 'Jumlah tidak boleh kurang dari 0',
			'type.required_without' => 'Jenis tidak boleh kosong',
			'type.required_if' => 'Jenis tidak boleh kosong',
			'id.required_without_all' => 'Data tidak boleh kosong',
			'id.exists' => 'Data tidak ditemukan',
		];
	}
}
