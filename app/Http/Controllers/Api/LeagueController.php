<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;
use Cache;
use DB;
use View;

use App\Cfg;
use App\Pref;
use App\Sports;
use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;

class LeagueController extends Controller {

	public function __construct(){
    $this->prefAry = Pref::orderBy('id','asc')->lists('name','slug')->toArray();
    $this->cacheMin = 5;
	}

	public function order($league_id){
    $key = 'LEAGUE_API_ORDER_'.$league_id;
    if(Cache::has($key)){
      return Cache::get($key);
    }

    $prefAry = $this->prefAry;
		$league = Leagues::find($league_id);
    $teamObj = LeagueTeams::where('leagues_id',$league_id)->orderBy('id','asc')->lists('name','id');
    $resultObj = leagueOrder($league_id);
// 		$resultObj = DB::select('select
// (select count(*)+1
// from (
// select team_id
// ,sum((home_pt>away_pt)*3 +(home_pt=away_pt)) as 勝ち点
// ,sum(home_pt) - sum(away_pt) as 得失点差
// ,sum(home_pt) as 得点
// from (
// select home_id as team_id,home_pt,away_pt from matches where leagues_id='.$league->id.'
// union all select away_id as team,away_pt,home_pt from matches where leagues_id='.$league->id.'
// ) as sub1
// group by team_id
// ) as sub2
// where 
// 勝ち点>(@a:=coalesce(sum((home_pt>away_pt)*3 +(home_pt=away_pt)),0))
// or ( 勝ち点=@a and 得失点差>@b:=coalesce((sum(home_pt) - sum(away_pt)),0))
// or ( 勝ち点=@a and 得失点差=@b and 得点>coalesce(sum(home_pt),0))
// ) as rank
// ,name
// ,coalesce(sum((home_pt>away_pt)*3 +(home_pt=away_pt)),0) as win_pt
// ,coalesce(count(sub.team_id),0) as match_cnt
// ,coalesce(sum(home_pt>away_pt),0) as win_cnt
// ,coalesce(sum(home_pt=away_pt),0) as draw_cnt
// ,coalesce(sum(home_pt<away_pt),0) as lose_cnt
// ,coalesce(sum(home_pt),0) as get_pt
// ,coalesce(sum(away_pt),0) as lose_pt
// ,coalesce(sum(home_pt) - sum(away_pt),0) as get_lose
// from (
// select home_id as team_id,home_pt,away_pt from matches where leagues_id='.$league->id.'
// union all select away_id as team,away_pt,home_pt from matches where leagues_id='.$league->id.'
// ) as sub
// right join league_teams on sub.team_id=league_teams.id
// where league_teams.leagues_id = '.$league->id.'
// group by league_teams.id
// order by win_pt desc,get_lose desc,get_pt desc, league_teams.id asc;
// ');

    $content = View::make('api.league.order')
    ->with(compact('league','resultObj','teamObj','prefAry'))
    ->render();

    Cache::put($key,$content,$this->cacheMin);
    return $content;
		//return view('api.league.order',compact('league','resultObj','teamObj','prefAry'));
	}

	public function table($league_id){
    $key = 'LEAGUE_API_TABLE_'.$league_id;
    if(Cache::has($key)){
      return Cache::get($key);
    }

    $prefAry = $this->prefAry;
		$league = Leagues::find($league_id);
    $teamObj = LeagueTeams::where('leagues_id',$league_id)->orderBy('id','asc')->lists('name','id');

    // rank取得のため、以下のクエリが必要
    $resultObj = leagueOrder($league_id);
// 		$resultObj = DB::select('select
// (select count(*)+1
// from (
// select team_id
// ,sum((home_pt>away_pt)*3 +(home_pt=away_pt)) as 勝ち点
// ,sum(home_pt) - sum(away_pt) as 得失点差
// ,sum(home_pt) as 得点
// from (
// select home_id as team_id,home_pt,away_pt from matches where leagues_id='.$league_id.'
// union all select away_id as team,away_pt,home_pt from matches where leagues_id='.$league_id.'
// ) as sub1
// group by team_id
// ) as sub2
// where 
// 勝ち点>(@a:=coalesce(sum((home_pt>away_pt)*3 +(home_pt=away_pt)),0))
// or ( 勝ち点=@a and 得失点差>@b:=coalesce((sum(home_pt) - sum(away_pt)),0))
// or ( 勝ち点=@a and 得失点差=@b and 得点>coalesce(sum(home_pt),0))
// ) as rank
// ,name
// ,league_teams.id
// ,league_teams.leagues_id
// ,coalesce(sum((home_pt>away_pt)*3 +(home_pt=away_pt)),0) as win_pt
// ,coalesce(count(sub.team_id),0) as match_cnt
// ,coalesce(sum(home_pt>away_pt),0) as win_cnt
// ,coalesce(sum(home_pt=away_pt),0) as draw_cnt
// ,coalesce(sum(home_pt<away_pt),0) as lose_cnt
// ,coalesce(sum(home_pt),0) as get_pt
// ,coalesce(sum(away_pt),0) as lose_pt
// ,coalesce(sum(home_pt) - sum(away_pt),0) as get_lose
// from (
// select home_id as team_id,home_pt,away_pt from matches where leagues_id='.$league_id.'
// union all select away_id as team,away_pt,home_pt from matches where leagues_id='.$league_id.'
// ) as sub
// right join league_teams on sub.team_id=league_teams.id
// where league_teams.leagues_id = '.$league_id.'
// group by league_teams.id
// order by win_pt desc,get_lose desc,get_pt desc, league_teams.id asc;
// ');

		//dd($resultObj);
		foreach($resultObj as $result):
			$teams[] = $result->id;
			$teamAry[$result->id] = $result->id;
		endforeach;
		//dd($teams);

		$hoge = DB::select('SELECT
t.id,
t.leagues_id,
ti.home_id,
ti.away_id,
ti.home_pt,
ti.away_pt 
FROM
league_teams AS t1 INNER JOIN (league_teams t INNER JOIN matches ti ON t.id = ti.home_id) ON t1.id = ti.away_id WHERE t.leagues_id = '.$league_id);

//dd($hoge);

if(0){
  $table = [];
  foreach($teams as $team1):
    foreach($teams as $team2):
    	// $table[$team1][$team2][0] = '-';
    	// $table[$team1][$team2][1] = '-';
    
      foreach($hoge as $game) {
        //var_dump($game);
        if($game->home_id == $team1 && $game->away_id == $team2){
          if ($game->home_pt > $game->away_pt) {
            $table[$game->home_id][$game->away_id][] = $game->home_pt . '○' . $game->away_pt;
            $table[$game->away_id][$game->home_id][] = $game->away_pt . '●' . $game->home_pt;
          } elseif ($game->home_pt < $game->away_pt) {
            $table[$game->home_id][$game->away_id][] = $game->home_pt . '●' . $game->away_pt;
            $table[$game->away_id][$game->home_id][] = $game->away_pt . '○' . $game->home_pt;
          } elseif ($game->home_pt == $game->away_pt) {
            $table[$game->home_id][$game->away_id][] = $game->home_pt . '△' . $game->away_pt;
            $table[$game->away_id][$game->home_id][] = $game->away_pt . '△' . $game->home_pt;
          }
        }
      }
    endforeach;
  endforeach;
  foreach($teams as $team1):
    foreach($teams as $team2):
      if(!isset($table[$team1][$team2][0])){
        $table[$team1][$team2][0] = '-';
        $table[$team2][$team1][0] = '-';
      }
      if(!isset($table[$team1][$team2][1])){
        $table[$team1][$team2][1] = '-';
        $table[$team2][$team1][1] = '-';
      }
    endforeach;
  endforeach;
}else{
  $table = array_fill_keys($teams,array_fill_keys($teams,array_fill_keys([0,1],'-')));
  foreach($hoge as $game) {
    //var_dump($game);
    if ($game->home_pt > $game->away_pt) {
    	if($table[$game->home_id][$game->away_id][0]=='-'){
	      $table[$game->home_id][$game->away_id][0] = $game->home_pt . '○' . $game->away_pt;
	      $table[$game->away_id][$game->home_id][0] = $game->away_pt . '●' . $game->home_pt;
	    }else{
	      $table[$game->home_id][$game->away_id][1] = $game->home_pt . '○' . $game->away_pt;
	      $table[$game->away_id][$game->home_id][1] = $game->away_pt . '●' . $game->home_pt;
	    }
    } elseif ($game->home_pt < $game->away_pt) {
    	if($table[$game->home_id][$game->away_id][0]=='-'){
	      $table[$game->home_id][$game->away_id][0] = $game->home_pt . '●' . $game->away_pt;
	      $table[$game->away_id][$game->home_id][0] = $game->away_pt . '○' . $game->home_pt;
	    }else{
	      $table[$game->home_id][$game->away_id][1] = $game->home_pt . '●' . $game->away_pt;
	      $table[$game->away_id][$game->home_id][1] = $game->away_pt . '○' . $game->home_pt;
	    }
    } else {
    	if($table[$game->home_id][$game->away_id][0]=='-'){
	      $table[$game->home_id][$game->away_id][0] = $game->home_pt . '△' . $game->away_pt;
	      $table[$game->away_id][$game->home_id][0] = $game->away_pt . '△' . $game->home_pt;
	    }else{
	      $table[$game->home_id][$game->away_id][1] = $game->home_pt . '△' . $game->away_pt;
	      $table[$game->away_id][$game->home_id][1] = $game->away_pt . '△' . $game->home_pt;
	    }
    }
  }  
}

    $content = View::make('api.league.table')
    ->with(compact('resultObj','table','league','teamAry','teamObj','prefAry'))
    ->render();

    Cache::put($key,$content,$this->cacheMin);
    return $content;
		// return view('api.league.table',compact('resultObj','table','league','teamAry','teamObj','prefAry'));

	}

	public function match($league_id){
    $key = 'LEAGUE_API_MATCH_'.$league_id;
    if(Cache::has($key)){
      return Cache::get($key);
    }

    $prefAry = $this->prefAry;
		$league = Leagues::find($league_id);
        $teamObj = LeagueTeams::where('leagues_id',$league_id)->orderBy('id','asc')->lists('name','id');

		$matchObj = Matches::where('leagues_id',$league->id)->orderByRaw('match_at desc,updated_at desc')->get();

    $content = View::make('api.league.match')
    ->with(compact('league','matchObj','teamObj','prefAry'))
    ->render();

    Cache::put($key,$content,$this->cacheMin);
    return $content;
		// return view('api.league.match',compact('league','matchObj','teamObj','prefAry'));

	}

}
