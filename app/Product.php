<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

	public $timestamps = false;

    protected $fillable = [
        'type', //enum['Minuman', 'Parfum', 'Gelas Kopi', 'Lain-lain']
		'name', //string
		'qty', //integer
		'price', //integer
    ];

	protected $dates = [
		'deleted_at',
	];

	public function transactions()
	{
		return $this->belongsToMany('App\Transaction')->withPivot('qty', 'price');
	}
}
