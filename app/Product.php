<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

	public $timestamps = false;

    protected $fillable = [
        'type_id', //unsignedSmallInteger
		'name', //string
		'qty', //integer
		'price', //integer
    ];

	protected $dates = [
		'deleted_at',
	];

	public function transactions()
	{
		return $this->belongsToMany('App\Transaction')->withPivot(
            'qty', //integer
            'price' //integer
        );
	}

    public function type()
    {
        return $this->belongsTo('App\ProductType');
    }
}
