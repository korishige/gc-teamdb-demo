<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueTeams extends Model
{

	protected $table = 'league_teams';
	protected $guarded = [];
	public $timestamps = false;
}
