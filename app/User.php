<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

  protected $table = 'users';
  protected $guarded = array('id');

  public function pref()
  {
    return $this->belongsTo('App\Pref');
  }

  public function branch()
  {
    return $this->belongsTo('App\Branch');
  }

  // public function team(){
  //   return $this->belongsTo('App\Teams');
  //   // return $this->hasOne('App\Teams','id','team_id');
  // }

}
