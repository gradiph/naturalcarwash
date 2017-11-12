<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToolCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'qty' => 'required|integer|min:0',
            'status' => 'required|in:Bagus,Bekas,Rusak',
        ];
    }

	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong',
			'qty.required' => 'Nama tidak boleh kosong',
			'qty.integer' => 'Jumlah harus angka',
			'qty.min' => 'Jumlah tidak boleh kurang dari 0',
			'status.required' => 'Kondisi tidak boleh kosong',
			'status.in' => 'Kondisi salah',
		];
	}
}
