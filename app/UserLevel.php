<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    public $timestamps = false;

	protected $fillable = [
		'name', //string
    ];

	public function users()
	{
		return $this->hasMany('App\User');
	}
}
