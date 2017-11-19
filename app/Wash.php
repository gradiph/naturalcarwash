<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wash extends Model
{
	use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
		'transaction_id', //unsignedBigInteger
		'description', //string
    ];

	protected $dates = [
		'deleted_at',
	];

	public function transaction()
	{
		return $this->belongsTo('App\Transaction');
	}

	public function rates()
	{
		return $this->belongsToMany('App\WashingRate')->withPivot(
			'price' //integer
		);
	}
}
