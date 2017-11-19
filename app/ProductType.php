<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public $timestamps = false;

	protected $fillable = [
		'name', //string
    ];

	public function products()
	{
		return $this->hasMany('App\Product');
	}
}
