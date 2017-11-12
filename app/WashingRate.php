<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WashingRate extends Model
{
	use SoftDeletes;

	public $timestamps = false;

    protected $fillable = [
		'name', //string
		'price', //integer
    ];

	protected $dates = [
		'deleted_at',
	];

	public function washes()
	{
		return $this->belongsToMany('App\Wash')->withPivot(
			'price' //integer
		);
	}
}
