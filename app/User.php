<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', //string
		'username', //string
		'password', //string
		'level_id', //unsignedInteger
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

	protected $dates = [
		'deleted_at',
	];

	public function transactions()
	{
		return $this->hasMany('App\Transaction');
	}

	public function expenditures()
	{
		return $this->hasMany('App\Expenditure');
	}

	public function logs()
	{
		return $this->hasMany('App\UserLog');
	}

    public function level()
    {
        return $this->belongsTo('App\UserLevel');
    }
}
