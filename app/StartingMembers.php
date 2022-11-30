<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StartingMembers extends Model
{
	protected $table = 'starting_members';
	protected $guarded = array('id');

	public function pref(){
		return $this->belongsTo('App\Pref');
	}

	public function group(){
		return $this->hasOne('App\Groups','id','group_id');
	}

	public function team(){
		return $this->hasOne('App\Teams','id','team_id');
	}

	public function match(){
		return $this->hasOne('App\Matches','id','match_id');
	}
}
