<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class HomeCancelTransactionRequest extends FormRequest
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
            'reason' => 'required',
        ];
    }

	public function messages()
	{
		return [
			'reason.required' => 'Alasan pembatalan tidak boleh kosong',
		];
	}
}
