<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Goals extends Model
{

  protected $table = 'goals';
  protected $guarded = array('id');
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  public function player()
  {
    return $this->belongsTo('App\Players', 'goal_player_id', 'id');
  }

  public function player0()
  {
    return $this->hasOne('App\Players', 'id', 'goal_player_id');
  }

  public function league()
  {
    return $this->belongsTo('App\Leagues', 'league_id', 'id');
  }
}
