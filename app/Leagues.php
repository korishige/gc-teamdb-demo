<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leagues extends Model
{


	protected $table = 'leagues';
	protected $guarded = array('id');
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	public function pref()
	{
		return $this->hasOne('App\Pref', 'slug', 'pref');
	}

	public function group()
	{
		// return $this->hasOne('App\Groups','id');
		return $this->hasOne('App\Groups', 'id', 'group_id');
	}

	public function matches()
	{
		return $this->hasMany('App\Matches');
	}

	public function filled_matches()
	{
		return $this->hasMany('App\Matches')->where('is_filled', 1);
	}

	public function matches1()
	{
		return $this->hasMany('App\Matches')->orderBy('updated_at', 'desc');
	}

	public function team()
	{
		return $this->hasMany('App\LeagueTeams')->orderBy('id');
	}
}
