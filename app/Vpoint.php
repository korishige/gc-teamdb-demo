<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vpoint extends Model
{


	protected $table = 'v_point_settings';
	protected $guarded = array('id');

	public function league()
	{
		return $this->belongsTo('App\Leagues');
	}
}
