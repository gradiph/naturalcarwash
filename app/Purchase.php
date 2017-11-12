<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	public $timestamps = false;

    protected $fillable = [
        'type', //['Minuman', 'Parfum', 'Gelas Kopi', 'Lain-lain']
		'name', //string
		'qty', //integer
		'price', //integer
        'creation_date', //timestamp
		'user_id', //unsignedInteger
    ];

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
