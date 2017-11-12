<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mechanic extends Model
{
    use SoftDeletes;

	public $timestamps = false;

    protected $fillable = [
		'name', //string
    ];

	protected $dates = [
		'deleted_at',
	];

	public function transactions()
	{
		return $this->belongsToMany('App\Transaction');
	}
}
