<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{


	protected $table = 'matches';
	protected $guarded = array('id');
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	public function leagueOne()
	{
		//		return $this->hasOne('App\Leagues','id','leagues_id')->where('year',config('app.nendo'));
		return $this->hasOne('App\Leagues', 'id', 'leagues_id');
	}

	public function scopeYear($query, $year)
	{
		return $this->hasOne('App\Leagues', 'id', 'leagues_id')->where('year', $year);
		//		return $this->hasOne('App\Leagues','id','leagues_id');
	}

	public function league()
	{
		return $this->belongsTo('App\Leagues');
	}

	public function home()
	{
		return $this->belongsTo('App\LeagueTeams', 'home_id', 'id');
	}

	public function away()
	{
		return $this->belongsTo('App\LeagueTeams', 'away_id', 'id');
	}

	public function judge()
	{
		return $this->belongsTo('App\Teams', 'judge_id', 'id');
	}

	public function place()
	{
		return $this->belongsTo('App\Venue', 'place_id', 'id');
	}

	public function home0()
	{
		return $this->hasOne('App\Teams', 'id', 'home_id');
	}

	public function away0()
	{
		return $this->hasOne('App\Teams', 'id', 'away_id');
	}

	public function judge0()
	{
		return $this->hasOne('App\Teams', 'id', 'judge_id');
	}

	public function venue()
	{
		return $this->hasOne('App\Venue', 'id', 'place_id');
	}

	public function goals()
	{
		return $this->hasMany('App\Goals', 'id', 'match_id');
	}

	public function photos()
	{
		return $this->hasMany('App\MatchPhotos', 'id', 'match_id');
	}

	public function photo1()
	{
		return $this->hasMany('App\MatchPhotos', 'match_id', 'id');
	}

	public function gallery()
	{
		return $this->hasMany('App\MatchPhotos', 'match_id', 'id');
	}

	public function mom_hplayer()
	{
		return $this->hasOne('App\Players', 'id', 'mom_home');
	}

	public function mom_aplayer()
	{
		return $this->hasOne('App\Players', 'id', 'mom_away');
	}

	// public function awaygoals(){
	// 	return $this->hasMany('App\Goals','id','match_id');
	// }

}
