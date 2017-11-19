<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class WashingRateUpdateRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::check() || Auth::user()->level->name != 'Admin')
        {
            return false;
        }
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
