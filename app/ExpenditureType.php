<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenditureType extends Model
{
    public $timestamps = false;

	protected $fillable = [
		'name', //string
    ];

    public function expenditures()
    {
        $this->hasMany('App\Expenditure');
    }
}
