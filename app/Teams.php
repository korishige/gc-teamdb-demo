<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Teams extends Model
{

	protected $table = 'teams';
	protected $guarded = array('id');

	use SoftDeletes;
	protected $dates = ['deleted_at'];

	public function pref()
	{
		return $this->belongsTo('App\Pref');
	}

	public function group()
	{
		return $this->hasOne('App\Groups', 'id', 'group_id');
	}

	public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id');
	}

	// public function organization(){
	// 	return $this->belongsTo('App\Teams','organization_team','organizations_id','teams_id');
	// }

	// public function organization2(){
	// 	return $this->hasManyThrough('App\Organization','App\Teams');
	// }

	public function organization()
	{
		return $this->belongsTo('App\Organizations', 'organizations_id', 'id');
	}

	public function players()
	{
		return $this->belongsTo('App\Players', 'id', 'team_id');
	}

	public function block_players()
	{
		return $this->belongsTo('App\Players', 'id', 'team_id')->where('is_block', 1)->count();
	}

	//	public function yearly_group($year=2021){
	//		return $this->belongsTo('App\TeamYearlyGroup','id','team_id')->where('yyyy',$year);
	//	}

}
