<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    public $timestamps = false;

	protected $fillable = [
		'user_id', //unsignedInteger
		'description', //string
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
