<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;
use Cache;
use DB;

// use App\Cfg;
// use App\Pref;
// use App\Sports;
use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Groups;
use App\Goals;

// use App\Comments;

class PcLeagueController extends Controller
{

	public function __construct()
	{
	}

	public function index()
	{
		return "table 検討中";
	}

	public function order_groups($groups_id, $yyyy = '', $period = '')
	{
		$yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
		$period = ($period == '') ? config('app.period') : $period;
		if ($period == 'first') {
			$season = 0;
		} else {
			$season = 1;
		}
		//		$period = config('app.period');
		$nav_on = 'order';

		// 部に所属するグループ抜き出し
		// if ($groups_id != 3) {
		// 	$groups = Groups::where('grouping', $groups_id)->lists('id');
		// } else {
		// $groups = Groups::where('grouping', $groups_id)->lists('id');
		// }

		$groups = Groups::where('convention', config('app.convention'))->get();

		// 部に属するリーグ抜き出し
		$leagues = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->get();
		// 部に属するリーグIDのみ抜き出し
		$league_ids = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->lists('id');
		// dd($leagues);

		if ($leagues != null) {
			foreach ($league_ids as $league_id) {
				$teamObj[$league_id] = LeagueTeams::where('leagues_id', $league_id)->orderBy('id', 'asc')->lists('name', 'id');
				$resultObj[$league_id] = leagueOrder($league_id);

				if ($resultObj[$league_id]  != null) {
					foreach ($resultObj[$league_id] as $key => $result) {
						$adjust_result = LeagueTeams::whereNotNull('prestage_win_pt')->where('team_id', $result->team_id)->first();
						if ($adjust_result != null) {
							$resultObj[$league_id][$key]->prestage_win_pt = $adjust_result->prestage_win_pt;
							$resultObj[$league_id][$key]->win_pt = $adjust_result->prestage_win_pt + $resultObj[$league_id][$key]->win_pt;
						} else {
							$resultObj[$league_id][$key]->prestage_win_pt = 0;
						}
					}

					//1st1含めた勝ち点でソートする
					$resultObj[$league_id] = sortByKey('win_pt', SORT_DESC, $resultObj[$league_id]);

					$i = 1;
					foreach ($resultObj[$league_id] as $key => $result) {
						$result->rank = $i;
						$i++;
					}
				} else {
					$resultObj[$league_id] = null;
				}
			}
		} else {
			$teamObj = null;
			$resultObj = null;
		}
		// dd($resultObj);
		// dd($teamObj);

		return view('front.league.order_group', compact('groups_id', 'nav_on', 'leagues', 'resultObj', 'teamObj', 'yyyy', 'period', 'groups'));
	}

	public function order($group_id, $yyyy = '', $period = '')
	{
		$yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'order';

		$g = Groups::where('id', $group_id)->first();
		$groups = $g->grouping;

		// 対象グループのリーグ抜き出し
		$leagues = Leagues::where('year', $yyyy)->where('group_id', $group_id)->get();

		if ($leagues != NULL) {
			foreach ($leagues as $league) {
				$teamObj[$league->id] = LeagueTeams::where('leagues_id', $league->id)->orderBy('id', 'asc')->lists('name', 'id');
				$resultObj[$league->id] = leagueOrder($league->id);

				foreach ($resultObj[$league->id] as $key => $result) {
					$adjust_result = LeagueTeams::whereNotNull('prestage_win_pt')->where('team_id', $result->team_id)->first();
					if ($adjust_result != null) {
						$resultObj[$league->id][$key]->prestage_win_pt = $adjust_result->prestage_win_pt;
					} else {
						$resultObj[$league->id][$key]->prestage_win_pt = 0;
					}
				}
			}
		} else {
			$teamObj = null;
			$resultObj = null;
		}
		//dd($resultObj);

		return view('front.league.order')->with(compact('groups', 'group_id', 'nav_on', 'leagues', 'resultObj', 'teamObj', 'yyyy', 'period'));
	}

	public function ranking_groups($groups_id, $yyyy = '', $period = '')
	{
		$yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
		$period = ($period == '') ? config('app.period') : $period;
		if ($period == 'first') {
			$season = 0;
		} else {
			$season = 1;
		}
		$nav_on = 'ranking';

		$groups = Groups::where('convention', config('app.convention'))->get();

		// 部に属するリーグ抜き出し
		$leagues = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->get();
		// 部に属するリーグIDのみ抜き出し
		$league_ids = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->lists('id');
		// dd($leagues);

		if ($leagues != null) {
			foreach ($league_ids as $league_id) {
				$teamObj[$league_id] = LeagueTeams::where('leagues_id', $league_id)->orderBy('id', 'asc')->lists('name', 'id');
				$rankings[$league_id] = Goals::selectRaw('team_id,goal_player_id as id, count(*) cnt')->where('league_id', $league_id)->groupBy('goal_player_id')->orderBy('cnt', 'desc')->get();
			}
		} else {
			$teamObj = null;
			$resultObj = null;
		}

		return view('front.league.ranking', compact('groups_id', 'nav_on', 'leagues', 'rankings', 'teamObj', 'yyyy', 'period', 'groups'));
	}

	public function table_groups($groups_id, $yyyy = '', $period = '')
	{
		$yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'order';

		if ($period == 'second') {
			$season = 1;
		} else {
			$season = 0;
		}

		// $g = Groups::where('id',$group_id)->first();
		// $groups = $g->grouping;

		// 部に所属するグループ抜き出し
		// if ($groups_id != 3) {
		// 	$groups = Groups::where('grouping', $groups_id)->lists('id');
		// } else {
		// $groups = Groups::where('grouping', $groups_id)->lists('id');
		// }
		//		$groups = Groups::where('grouping', $groups_id)->lists('id');

		$groups = Groups::where('convention', config('app.convention'))->get();

		// 部に属するリーグ抜き出し
		$leagues = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->get();
		// 部に属するリーグIDのみ抜き出し
		// $league_ids = Leagues::whereIn('group_id',$groups)->lists('id');

		if ($leagues != NULL) {
			foreach ($leagues as $league) {
				$teamObj[$league->id] = LeagueTeams::where('leagues_id', $league->id)->orderBy('id', 'asc')->lists('name', 'id');
				$resultObj[$league->id] = leagueOrder($league->id);

				if ($resultObj[$league->id] != null) {

					foreach ($resultObj[$league->id] as $result) :
						$teams[$league->id][] = $result->team_id;
						$teamAry[$league->id][$result->team_id] = $result->team_id;
					endforeach;
					// 2020-04-27 現状、１つのチームが複数のリーグに参加しているため、t1,ti の条件を追記している
					$hoge = DB::select('SELECT
          t.id,
          t.leagues_id,
          ti.home_id,
          ti.away_id,
          ti.home_pt,
          ti.away_pt,
					ti.home_pk,
					ti.away_pk
          FROM
          league_teams AS t1 INNER JOIN (league_teams t INNER JOIN matches ti ON t.team_id = ti.home_id) ON t1.team_id = ti.away_id WHERE t.leagues_id = ' . $league->id . ' and ti.leagues_id = ' . $league->id . ' and t1.leagues_id = ' . $league->id);


					$table[$league->id] = array_fill_keys($teams[$league->id], array_fill_keys($teams[$league->id], array_fill_keys([0, 1], '-')));
					// dd($table);
					foreach ($hoge as $game) {
						// var_dump($game);
						if ($game->home_pt > $game->away_pt) {
							if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
								$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '○' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '●' . $game->home_pt;
							} else {
								$table[$league->id][$game->home_id][$game->away_id][1] = $game->home_pt . '○' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][1] = $game->away_pt . '●' . $game->home_pt;
							}
						} elseif ($game->home_pt < $game->away_pt) {
							if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
								$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '●' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '○' . $game->home_pt;
							} else {
								$table[$league->id][$game->home_id][$game->away_id][1] = $game->home_pt . '●' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][1] = $game->away_pt . '○' . $game->home_pt;
							}
						} elseif ($game->home_pt === null and $game->away_pt === null) {
							if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
								$table[$league->id][$game->home_id][$game->away_id][0] = '-';
								$table[$league->id][$game->away_id][$game->home_id][0] = '-';
							} else {
								$table[$league->id][$game->home_id][$game->away_id][1] = '-';
								$table[$league->id][$game->away_id][$game->home_id][1] = '-';
							}
						} else {
							if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
								if ($game->home_pk > $game->away_pk) {
									$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '(' . $game->home_pk . ')' . '▲' . '(' . $game->away_pk . ')' . $game->away_pt;
									$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '(' . $game->away_pk . ')' . '△' . '(' . $game->home_pk . ')' . $game->home_pt;
								} else {
									$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '(' . $game->home_pk . ')' . '△' . '(' . $game->away_pk . ')' . $game->away_pt;
									$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '(' . $game->away_pk . ')' . '▲' . '(' . $game->home_pk . ')' . $game->home_pt;
								}
							} else {
								$table[$league->id][$game->home_id][$game->away_id][1] = $game->home_pt . '△' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][1] = $game->away_pt . '△' . $game->home_pt;
							}
						}
					}
				} else {
					$resultObj[$league->id] = null;
					$table[$league->id] = null;
				}
			}
		} else {
			$table = null;
			$teamAry = null;
			$teamObj = null;
		}

		return view('front.league.table_group')->with(compact('groups_id', 'nav_on', 'resultObj', 'table', 'leagues', 'teamAry', 'teamObj', 'yyyy', 'period', 'groups'));
	}

	public function table($group_id, $yyyy = '', $period = '')
	{
		$yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'order';

		$g = Groups::where('id', $group_id)->first();
		$groups = $g->grouping;
		//		dd($groups);

		$leagues = Leagues::where('year', $yyyy)->where('group_id', $group_id)->get();

		// if($leagues != NULL){
		//   foreach($leagues as $league){
		//     $teamObj[$league->id] = LeagueTeams::where('leagues_id',$league->id)->orderBy('id','asc')->lists('name','id');
		//     $resultObj[$league->id] = leagueOrder($league->id);
		//   }
		// }else{
		//   $teamObj = null;
		//   $resultObj = null;
		// }

		if ($leagues != null) {
			foreach ($leagues as $league) {
				$teamObj[$league->id] = LeagueTeams::where('leagues_id', $league->id)->orderBy('id', 'asc')->lists('name', 'id');
				$resultObj[$league->id] = leagueOrder($league->id);
				foreach ($resultObj[$league->id] as $result) :
					$teams[$league->id][] = $result->team_id;
					$teamAry[$league->id][$result->team_id] = $result->team_id;
				endforeach;
				// 2020-04-27 現状、１つのチームが複数のリーグに参加しているため、t1,ti の条件を追記している
				$hoge = DB::select('SELECT
          t.id,
          t.leagues_id,
          ti.home_id,
          ti.away_id,
          ti.home_pt,
          ti.away_pt,
					ti.home_pk,
					ti.away_pk
          FROM
          league_teams AS t1 INNER JOIN (league_teams t INNER JOIN matches ti ON t.team_id = ti.home_id) ON t1.team_id = ti.away_id WHERE t.leagues_id = ' . $league->id . ' and ti.leagues_id = ' . $league->id . ' and t1.leagues_id = ' . $league->id);


				$table[$league->id] = array_fill_keys($teams[$league->id], array_fill_keys($teams[$league->id], array_fill_keys([0, 1], '-')));
				// dd($table);
				foreach ($hoge as $game) {
					// var_dump($game);
					if ($game->home_pt > $game->away_pt) {
						if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
							$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '○' . $game->away_pt;
							$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '●' . $game->home_pt;
						} else {
							$table[$league->id][$game->home_id][$game->away_id][1] = $game->home_pt . '○' . $game->away_pt;
							$table[$league->id][$game->away_id][$game->home_id][1] = $game->away_pt . '●' . $game->home_pt;
						}
					} elseif ($game->home_pt < $game->away_pt) {
						if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
							$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '●' . $game->away_pt;
							$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '○' . $game->home_pt;
						} else {
							$table[$league->id][$game->home_id][$game->away_id][1] = $game->home_pt . '●' . $game->away_pt;
							$table[$league->id][$game->away_id][$game->home_id][1] = $game->away_pt . '○' . $game->home_pt;
						}
					} elseif ($game->home_pt === null and $game->away_pt === null) {
						if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
							$table[$league->id][$game->home_id][$game->away_id][0] = '-';
							$table[$league->id][$game->away_id][$game->home_id][0] = '-';
						} else {
							$table[$league->id][$game->home_id][$game->away_id][1] = '-';
							$table[$league->id][$game->away_id][$game->home_id][1] = '-';
						}
					} else {
						if ($table[$league->id][$game->home_id][$game->away_id][0] == '-') {
							if ($game->home_pk > $game->away_pk) {
								$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '(' . $game->home_pk . ')' . '▲' . '(' . $game->away_pk . ')' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '(' . $game->away_pk . ')' . '△' . '(' . $game->home_pk . ')' . $game->home_pt;
							} else {
								$table[$league->id][$game->home_id][$game->away_id][0] = $game->home_pt . '(' . $game->home_pk . ')' . '△' . '(' . $game->away_pk . ')' . $game->away_pt;
								$table[$league->id][$game->away_id][$game->home_id][0] = $game->away_pt . '(' . $game->away_pk . ')' . '▲' . '(' . $game->home_pk . ')' . $game->home_pt;
							}
						} else {
							$table[$league->id][$game->home_id][$game->away_id][1] = $game->home_pt . '△' . $game->away_pt;
							$table[$league->id][$game->away_id][$game->home_id][1] = $game->away_pt . '△' . $game->home_pt;
						}
					}
				}
			}
		} else {
			$teamObj = null;
			$resultObj = null;
			$teams = null;
			$teamAry = null;
		}

		return view('front.league.table', compact('groups', 'group_id', 'nav_on', 'resultObj', 'table', 'leagues', 'teamAry', 'teamObj', 'yyyy', 'period'));
		// $content = view('front.league.table')
		// ->with(['cfg'=>$this->cfg,'terms'=>$this->tagall,'sponsorAry'=>$this->sponsorAry,'news8Obj'=>$this->news8Obj])
		// ->with(compact('pref','resultObj','table','league','teamAry','commentObj','teamObj'))
		// ->render();
		// return $content;

	}

	public function match($groups_id, $yyyy = '', $period = '')
	{
		$yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
		$period = ($period == '') ? config('app.period') : $period;
		// この関数は、groupsではなく、group_id
		$nav_on = 'order';

		if ($period == 'second') {
			$season = 1;
		} else {
			$season = 0;
		}

		// $groups = Groups::where('grouping', $groups_id)->lists('id');
		// $g = Groups::where('id', $group_id)->first();
		// $groups = $g->grouping;

		// $leagues = Leagues::where('year', $yyyy)->where('group_id', $groups_id)->get();
		$groups = Groups::where('convention', config('app.convention'))->get();

		// 部に属するリーグ抜き出し
		$leagues = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->get();
		// 部に属するリーグIDのみ抜き出し
		$league_ids = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->where('season', $season)->lists('id');
		// dd($leagues);

		if ($leagues != NULL) {
			foreach ($leagues as $league) {
				$teamObj[$league->id] = LeagueTeams::where('leagues_id', $league->id)->orderBy('id', 'asc')->lists('name', 'id');
				$matchObj[$league->id] = Matches::with('away', 'home', 'leagueOne', 'venue')->where('leagues_id', $league->id)->orderBy('match_at', 'asc')->get();
			}
		} else {
			$teamObj = null;
			$matchObj = null;
		}

		// dd($group_id);
		return view('front.league.match', compact('groups', 'groups_id', 'nav_on', 'leagues', 'matchObj', 'teamObj', 'yyyy', 'period'));
	}
}
