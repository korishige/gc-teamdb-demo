<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;
use App\Teams;
use App\Goals;
use App\Options;
use App\Cards;
use App\Players;
use Input;
use Cache;
use DB;

class LeagueController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth.team');
	}

	public function index()
	{
		$team_id = \Session::get('team_id');
		$team = Teams::find($team_id);	// join不要

		// 参加したリーグだけ表示する
		$_matches = Matches::select('leagues_id')->where(function ($q) use ($team_id) {
			$q->where('home_id', $team_id)->orWhere('away_id', $team_id);
		})->groupBy('leagues_id')->lists('leagues_id');

		$leagueObj = Leagues::whereIn('id', $_matches)->orderBy('id', 'desc');

		if (Input::has('year') && Input::get('year') != '')
			$leagueObj = $leagueObj->where('year', Input::get('year'));

		if (Input::has('season') && Input::get('season') != '')
			$leagueObj = $leagueObj->where('season', Input::get('season'));

		if (Input::has('keyword') && Input::get('keyword') != '')
			$leagueObj = $leagueObj->where('name', 'like', '%' . Input::get('keyword') . '%');

		$leagueObj = $leagueObj->paginate(10);

		return view('team.league.index', ['leagueObj' => $leagueObj]);
	}

	public function goals($id)
	{
		$league = Leagues::find($id);
		$goals = Goals::selectRaw('goal_player_id as id, count(*) cnt')->where('league_id', $league->id)->where('team_id', \Session::get('team_id'))->groupBy('goal_player_id')->orderBy('cnt', 'desc')->get();
		//		dd($goals);
		return view('team.league.goals', compact('league', 'goals'));
	}

	public function block(Request $req, $id)
	{
		//$players = Players::where('is_block', 1)->orderBy('team_id')->get();
		$league = Leagues::find($id);
		$option = Options::where('option_number', '1')->first();

		$sort = $req->has('sort') ? $req->get('sort') : '';

		$orderby = '';
		if ($sort == 'school_year') {
			$orderby = 'p.school_year desc';
		} elseif ($sort == 'team') {
			$orderby = 'team_name desc';
		} else {
			$orderby = 'g.id asc';
		}

		$whereConds = [];

		if (count($option) != 0) {
			$opval = $option->value;
		} else {
			$opval = 0;
		}

		//$opval == 1の時はそのリーグに所属しているチームのみ
		if ($opval == 1) {
			$league = Leagues::where('id', $id)->first();
			$whereConds[] = "g.id =" . $league->group_id;
			$teams = Teams::select(['teams.*', 'team_yearly_group.group_id'])->with('user', 'group', 'players')->leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo_backend'))->where('team_yearly_group.group_id', '=', $league->group_id)
				->where(function ($q) {
					$q->whereNull('period')->orWhere('period', config('app.period'));
				})->lists('name', 'id');
		}

		if ($req->has('group_id') and $req->get('group_id') != '') {
			$whereConds[] = "g.id = " . $req->get('group_id');
		}

		if ($req->has('team_id') and $req->get('team_id') != '') {
			$whereConds[] = "t.id = " . $req->get('team_id');
		}

		if ($req->has('school_year') and $req->get('school_year') != '') {
			// $players = $players->where('school_year',$req->get('school_year'));
			$whereConds[] = "p.school_year = " . $req->get('school_year');
		}

		if ($req->has('keyword') and $req->get('keyword') != '') {
			// $players = $players->where('is_block',$req->get('is_block'));
			$whereConds[] = "(p.name like '%" . $req->get('keyword') . "%' or t.name like '%" . $req->get('keyword') . "%')";
		}

		// dd($whereConds);
		if (count($whereConds) > 0) {
			$whereCond = " and " . implode($whereConds, ' and ');
			// var_dump($whereCond);
		} else {
			$whereCond = '';
		}

		// 	$players = DB::select("select p.id, p.name, p.school_year, p.is_block, p.team_id from players as p
		// where p.deleted_at is null" . $whereCond . " order by p.team_id desc ");

		// $players = DB::select("select g.id, g.name as group_name, ifnull(t.name, '') as team_name, ifnull(p.name, '') as player_name, ifnull(p.school_year, '') as school_year from groups as g
		// left join (select teams.id, teams.name, teams.group_id from teams where deleted_at is null) as t on t.group_id = g.id
		// left join (select players.id, players.team_id, players.name, players.school_year, players.is_block from players where deleted_at is null) as p on p.team_id = t.id
		// where p.is_block = 1" . $whereCond . " order by " . $orderby);

		$players = DB::select("select g.name as group_name, ifnull(t.name, '') as team_name, ifnull(p.name, '') as player_name, ifnull(p.school_year, '') as school_year from teams as t
    left join (select team_yearly_group.group_id, team_yearly_group.team_id from team_yearly_group where yyyy = " . config('app.nendo_backend') . ") as tyg on tyg.team_id = t.id
    left join (select groups.id, groups.name from groups) as g on g.id = tyg.group_id
    left join (select players.id, players.team_id, players.name, players.school_year, players.is_block from players where deleted_at is null and (school_year = 1 or school_year = 2 or school_year = 3)) as p on p.team_id = t.id
		where deleted_at is null and p.is_block = 1" . $whereCond . " order by " . $orderby);

		return view('team.league.block')->with(compact('players', 'league', 'opval', 'teams'));
	}

	public function warning(Request $req, $id, $nendo)
	{
		$league = Leagues::find($id);
		$sort = $req->has('sort') ? $req->get('sort') : '';
		$option = Options::where('option_number', '1')->first();

		$orderby = '';
		if ($sort == 'yellow') {
			$orderby = 'yellow desc';
		} elseif ($sort == 'red') {
			$orderby = 'red desc';
		} elseif ($sort == 'school_year') {
			$orderby = 'p.school_year desc';
		} elseif ($sort == 'team') {
			$orderby = 'team_name desc';
		} elseif ($sort == 'suspension_at') {
			$orderby = 'p.suspension_at desc';
		} else {
			$orderby = 'g.id asc';
		}

		$whereConds = [];

		if (count($option) != 0) {
			$opval = $option->value;
		} else {
			$opval = 0;
		}

		//$opval == 1の時はそのリーグに所属しているチームのみ
		if ($opval == 1) {
			$league = Leagues::where('id', $id)->first();
			$whereConds[] = "g.id =" . $league->group_id;
			$teams = Teams::select(['teams.*', 'team_yearly_group.group_id'])->with('user', 'group', 'players')->leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo_backend'))->where('team_yearly_group.group_id', '=', $league->group_id)
				->where(function ($q) {
					$q->whereNull('period')->orWhere('period', config('app.period'));
				})->lists('name', 'id');
		}

		if ($req->has('group_id') and $req->get('group_id') != '') {
			$whereConds[] = "g.id = " . $req->get('group_id');
		}

		if ($req->has('school_year') and $req->get('school_year') != '') {
			// $players = $players->where('school_year',$req->get('school_year'));
			$whereConds[] = "p.school_year = " . $req->get('school_year');
		}

		if ($req->has('team_id') and $req->get('team_id') != '') {
			$whereConds[] = "t.id = " . $req->get('team_id');
		}

		if ($req->has('has_cards') && $req->get('has_cards') == 1) {
			// $players = $players->has('cards','>=',1);
			$whereConds[] = "yellow is not null";
		} elseif ($req->has('has_cards') && $req->get('has_cards') == 0) {
			// $players = $players->doesnthave('cards');
			$whereConds[] = "yellow is null";
		}

		if ($req->has('keyword') and $req->get('keyword') != '') {
			// $players = $players->where('is_block',$req->get('is_block'));
			$whereConds[] = "(p.name like '%" . $req->get('keyword') . "%' or t.name like '%" . $req->get('keyword') . "%')";
		}

		// dd($whereConds);
		if (count($whereConds) > 0) {
			$whereCond = " and " . implode($whereConds, ' and ');
			// var_dump($whereCond);
		} else {
			$whereCond = '';
		}

		// $players = DB::select("select g.id, g.name as group_name, ifnull(t.name, '') as team_name, ifnull(p.name, '') as player_name, ifnull(p.school_year, '') as school_year, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red from groups as g 
		// left join (select teams.id, teams.name, teams.group_id from teams where deleted_at is null) as t on t.group_id = g.id
		// left join (select players.id, players.team_id, players.name, players.school_year from players where deleted_at is null) as p on p.team_id = t.id
		// left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and color='yellow' and is_cleared=0 group by player_id) as y_card on y_card.player_id=p.id 
		// left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and color='red' and is_cleared=0 group by player_id) as r_card on r_card.player_id=p.id 
		// where (y_card.y_cnt != 0 or r_card.r_cnt != 0) " . $whereCond . " order by " . $orderby);

		$players = DB::select("select g.id, g.name as group_name, p.id as player_id, ifnull(t.name, '') as team_name, ifnull(p.name, '') as player_name, ifnull(p.school_year, '') as school_year, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red, ifnull(p.suspension_at, '') as suspension_at from teams as t
    left join (select team_yearly_group.group_id, team_yearly_group.team_id from team_yearly_group where yyyy = " . config('app.nendo_backend') . ") as tyg on tyg.team_id = t.id
    left join (select groups.id, groups.name from groups) as g on g.id = tyg.group_id
    left join (select players.id, players.team_id, players.name, players.school_year, players.is_block, players.suspension_at from players where deleted_at is null) as p on p.team_id = t.id
    left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and color='yellow' and is_cleared=0 and nendo=" . $nendo . " group by player_id) as y_card on y_card.player_id=p.id 
    left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and color='red' and is_cleared=0 and nendo=" . $nendo . " group by player_id) as r_card on r_card.player_id=p.id 
    where (y_card.y_cnt != 0 or r_card.r_cnt != 0) " . $whereCond . " order by " . $orderby);

		return view('team.league.warning')->with(compact('players', 'league', 'opval', 'teams'));
	}

	public function wmatch($id, $player_id, $nendo)
	{
		$league = Leagues::find($id);
		$player = Players::find($player_id);
		$cards = Cards::where('deleted_at', null)->where('is_cleared', 0)->where('player_id', $player_id)->where('nendo', $nendo)->get();

		return view('team.league.wmatch')->with(compact('league', 'player', 'cards'));
	}

	public function match_all($id)
	{
		$league = Leagues::find($id);
		$matches = Matches::where('leagues_id', $id)->orderBy('match_date', 'desc')->paginate(10);
		return view('team.league.match', compact('league', 'matches'));
	}

	public function match_self($id)
	{
		$league = Leagues::find($id);
		$matches = Matches::with('leagueOne', 'home0', 'away0', 'place')->where('leagues_id', $id)->where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->orderBy('match_date', 'desc')->paginate(10);
		return view('team.league.match', compact('league', 'matches'));
	}

	public function order($id)
	{

		$league = Leagues::find($id);
		$teamObj = LeagueTeams::where('leagues_id', $id)->orderBy('id', 'asc')->lists('name', 'id');

		$resultObj = leagueOrder($id);
		// dd($resultObj);

		return view('team.league.order', compact('league', 'resultObj', 'teamObj'));

		// $content = view('front.league.order')
		// ->with(compact('resultObj','commentObj','teamObj'))
		// ->render();
		// return $content;
	}

	public function table($id)
	{

		$league = Leagues::find($id);
		$teamObj = LeagueTeams::where('leagues_id', $id)->orderBy('id', 'asc')->lists('name', 'id');
		// $commentObj = Comments::where('leagues_id',$id)->orderBy('updated_at','desc')->paginate(5);
		$resultObj = leagueOrder($id);

		//dd($resultObj);
		foreach ($resultObj as $result) :
			$teams[] = $result->team_id;
		//$teamAry[$result->team_id] = $result->team_id;
		endforeach;
		// dd($teams);

		// $league = Leagues::find($id);
		// $resultObj = leagueOrder($id);
		// // dd($resultObj);

		// foreach($resultObj as $result):
		//   $teams[] = $result->id;
		// endforeach;

		$hoge = DB::select('SELECT t1.id, lt.leagues_id, m.home_id, m.away_id, m.home_pt, m.away_pt FROM teams AS t1 INNER JOIN (league_teams lt INNER JOIN matches m ON lt.team_id = m.home_id) ON t1.id = m.away_id WHERE lt.leagues_id = ' . $id . ' and m.leagues_id=' . $id);

		// dd($hoge);
		// return 1;
		// var_dump($hoge, $teams);

		$vs_num = 1;

		if ($vs_num == 2) {
			$table = array_fill_keys($teams, array_fill_keys($teams, array_fill_keys([0, 1], '-')));
			// dd($table);

			foreach ($hoge as $game) {
				// var_dump($game);
				if ($game->home_pt > $game->away_pt) {
					if ($table[$game->home_id][$game->away_id][0] == '-') {
						$table[$game->home_id][$game->away_id][0] = $game->home_pt . '○' . $game->away_pt;
						$table[$game->away_id][$game->home_id][0] = $game->away_pt . '●' . $game->home_pt;
					} else {
						$table[$game->home_id][$game->away_id][1] = $game->home_pt . '○' . $game->away_pt;
						$table[$game->away_id][$game->home_id][1] = $game->away_pt . '●' . $game->home_pt;
					}
				} elseif ($game->home_pt < $game->away_pt) {
					if ($table[$game->home_id][$game->away_id][0] == '-') {
						$table[$game->home_id][$game->away_id][0] = $game->home_pt . '●' . $game->away_pt;
						$table[$game->away_id][$game->home_id][0] = $game->away_pt . '○' . $game->home_pt;
					} else {
						$table[$game->home_id][$game->away_id][1] = $game->home_pt . '●' . $game->away_pt;
						$table[$game->away_id][$game->home_id][1] = $game->away_pt . '○' . $game->home_pt;
					}
				} else {
					if ($table[$game->home_id][$game->away_id][0] == '-') {
						$table[$game->home_id][$game->away_id][0] = $game->home_pt . '△' . $game->away_pt;
						$table[$game->away_id][$game->home_id][0] = $game->away_pt . '△' . $game->home_pt;
					} else {
						$table[$game->home_id][$game->away_id][1] = $game->home_pt . '△' . $game->away_pt;
						$table[$game->away_id][$game->home_id][1] = $game->away_pt . '△' . $game->home_pt;
					}
				}
			}
		} elseif ($vs_num == 1) {
			$table = array_fill_keys($teams, array_fill_keys($teams, array_fill_keys([0], '対戦無')));
			// dd($table);
			foreach ($hoge as $game) {
				// dd($game);
				if ($game->home_pt > $game->away_pt) {
					if ($table[$game->home_id][$game->away_id][0] == '対戦無') {
						$table[$game->home_id][$game->away_id][0] = $game->home_pt . '○' . $game->away_pt;
						$table[$game->away_id][$game->home_id][0] = $game->away_pt . '●' . $game->home_pt;
					}
				} elseif ($game->home_pt < $game->away_pt) {
					if ($table[$game->home_id][$game->away_id][0] == '対戦無') {
						$table[$game->home_id][$game->away_id][0] = $game->home_pt . '●' . $game->away_pt;
						$table[$game->away_id][$game->home_id][0] = $game->away_pt . '○' . $game->home_pt;
					}
				} elseif ($game->home_pt === NULL and $game->away_pt === NULL) {
					if ($table[$game->home_id][$game->away_id][0] == '対戦無') {
						$table[$game->home_id][$game->away_id][0] = '';
						$table[$game->away_id][$game->home_id][0] = '';
					}
				} else {
					if ($table[$game->home_id][$game->away_id][0] == '対戦無') {
						$table[$game->home_id][$game->away_id][0] = $game->home_pt . '△' . $game->away_pt;
						$table[$game->away_id][$game->home_id][0] = $game->away_pt . '△' . $game->home_pt;
					}
				}
			}
		}

		// dd($table);


		// foreach($resultObj as $home):
		//   foreach($resultObj as $away):
		//     $matchAry[$home->id][$away->id] = Matches::where('leagues_id',$home->leagues_id)->where('home_id',$home->id)->where('away_id',$away->id)->select(['home_pt','away_pt'])->get()->toArray();
		//   endforeach;
		// endforeach;

		//dd($matchAry);

		return view('team.league.table', compact('resultObj', 'league', 'table'));
	}

	public function show($id)
	{
		$league = Leagues::find($id);
		$resultObj = leagueOrder($id);

		//dd($resultObj);

		return view('admin.league.show', compact('resultObj', 'league'));
		return "順位表表示";
	}
}
