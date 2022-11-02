<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Players extends Model
{

    protected $table = 'players';
    protected $guarded = array('id');
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function team()
    {
        return $this->belongsTo('App\Teams', 'team_id', 'id');
    }

    public function cards()
    {
        return $this->hasMany('App\Cards', 'player_id', 'id')->where('is_cleared', 0);
    }

    public function yellow_cards()
    {
        return $this->hasMany('App\Cards', 'player_id', 'id')->where('color', 'yellow')->where('is_cleared', 0)->count();
    }

    public function red_cards()
    {
        return $this->hasMany('App\Cards', 'player_id', 'id')->where('color', 'red')->where('is_cleared', 0)->count();
    }

    public function point()
    {
        return $this->hasMany('App\Goals', 'goal_player_id', 'id');
    }

    public function getNameYearAttribute()
    {
        $hoge = array_get(config('app.schoolYearAry'), $this->school_year);
        return "{$this->name}({$hoge})";
        //        return "{$this->name} | {$this->school_year}年生";
        // return "{$this->name} | {$this->school_year}年生 | 警告：".count($this->yellow_cards)."枚";
    }

    public function front_show($team, $orderby)
    {
        return $this->select('players.id', 'players.team_id', 'players.name', 'players.school_year', 'players.position', 'players.height', 'players.related_team', 'teams.id as team_id', 'teams.name as team_name')
            ->join('teams', function ($join) {
                $join->on('teams.id', '=', 'players.team_id')
                    ->whereNull('teams.deleted_at');
            })
            ->join('laravel_local.goals', function ($join) {
                $join->on('goals.goal_player_id', '=', 'players.id')
                    ->whereNull('goals.deleted_at');
            })
            ->first();
    }

    //	public function getCurrentGradeAttribute(){
    //		return "{$this->school_year}年生";
    //		// return "{$this->name} | {$this->school_year}年生 | 警告：".count($this->yellow_cards)."枚";
    //	}
    //
    //	public function getGraduateYearAttribute(){
    //		return "{$this->school_year}年OB";
    //		// return "{$this->name} | {$this->school_year}年生 | 警告：".count($this->yellow_cards)."枚";
    //	}

    // public function cards(){
    //     return $this->belongsTo('App\Cards','id','player_id');
    // }

    // public function ycards(){
    //     return $this->hasMany('App\Cards','id','player_id')->where('color','yellow');
    // }

    // public function rcards(){
    //     return $this->hasMany('App\Cards','id','player_id')->where('color','red');
    // }

}
