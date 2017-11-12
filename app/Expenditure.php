<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
	public $timestamps = false;

    protected $fillable = [
		'type', //enum['Listrik', 'Shampoo & Keperluan Salon', 'Lain-lain']
		'description', //string
		'price', //integer
		'user_id', //unsignedInteger
        'creation_date', //timestamp
    ];

	protected $dates = [
		'creation_date',
	];

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
