<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cards extends Model
{

	protected $table = 'cards';
	protected $guarded = array('id');
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	public function match()
	{
		return $this->belongsTo('App\Matches');
	}

	public function league()
	{
		return $this->belongsTo('App\Leagues');
	}

	public function player()
	{
		return $this->belongsTo('App\Players');
	}
}
