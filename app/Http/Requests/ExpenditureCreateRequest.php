<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ExpenditureCreateRequest extends FormRequest
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
            'date' => 'required|date',
			'description' => 'required',
			'type_id' => 'required|exists:expenditure_types,id',
			'price' => 'required|integer|min:0',
			'type' => 'required_if:type_id,1',
        ];
    }

	public function messages()
	{
		return [
			'date.required' => 'Tanggal tidak boleh kosong',
			'date.date' => 'Format tanggal salah',
			'description.required' => 'Keterangan tidak boleh kosong',
			'type_id.required' => 'Jenis tidak boleh kosong',
			'type_id.exists' => 'Jenis tidak ditemukan',
			'price.required' => 'Harga tidak boleh kosong',
			'price.integer' => 'Harga harus angka',
			'price.min' => 'Harga tidak boleh kurang dari 0',
			'type.required_if' => 'Jenis tidak boleh kosong',
		];
	}
}
