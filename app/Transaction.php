<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	public $timestamps = false;

    protected $fillable = [
		'user_id', //unsignedInteger
		'type', //enum['Umum', 'Karyawan']
		'worker_description', //string, nullable
		'creation_date', //timestamp
		'status', //enum['1', '0'] : 1=success, 0=cancel
		'cancel_reason', //string, nullable
    ];

	protected $dates = [
		'creation_date',
	];

	public function mechanics()
	{
		return $this->belongsToMany('App\Mechanic');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function products()
	{
		return $this->belongsToMany('App\Product')->withPivot(
			'qty', //integer
			'price' //integer
		);
	}

	public function washes()
	{
		return $this->hasMany('App\Wash');
	}
}
