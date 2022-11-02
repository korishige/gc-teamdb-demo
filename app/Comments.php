<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{


	protected $table = 'comments';
	protected $guarded = array('id');

	public function league()
	{
		return $this->belongsTo('App\Leagues');
	}

	public function match()
	{
		return $this->belongsTo('App\Matches');
	}
}
