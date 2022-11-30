<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerSuspend extends Model
{
	protected $table = 'player_suspend';
	protected $guarded = array('id');

	public function player(){
		return $this->hasOne('App\Players','id','player_id');
	}

	public function team(){
		return $this->hasOne('App\Teams','id','team_id');
	}

	public function match(){
		return $this->hasOne('App\Matches','id','match_id');
	}
}
