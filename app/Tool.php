<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tool extends Model
{
	public $timestamps = false;

    protected $fillable = [
		'name', //string
		'qty', //integer
        'status', //enum['Bagus', 'Kurang Bagus', 'Rusak']
    ];
}
