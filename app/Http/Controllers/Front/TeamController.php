<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Session;
use Input;

use App\Teams;
use App\Groups;
use App\Players;
use App\Goals;

class TeamController extends Controller
{

	public function __construct()
	{
	}

	public function index($period = '')
	{
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'team';

		// for ($i = 1; $i < 3; $i++) {
		// 	// if (config('app.nendo') == 2020) {
		// 	// 	$g[$i] = Groups::where('grouping', $i)->whereNotNull('order')->lists('id')->toArray();
		// 	// } else {
		// 	$g[$i] = Groups::where('grouping', $i)->whereNotNull('order')->lists('id')->toArray();
		// 	// }
		// 	$sort = implode(',', $g[$i]);
		// 	$league_groups[$i] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->whereIn('group_id', $g)->orderByRaw("FIELD(group_id, " . $sort . ")")->get();
		// }

		// $groups[1] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->whereIn('group_id', $g[1])->get();
		// $groups[2] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->whereIn('group_id', $g[2])->get();
		//$groups[3] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->whereIn('group_id', $g[3])->get();

		$groups = Groups::where('convention', config('app.convention'))->get();

		foreach ($groups as $group) {
			// if ($period == 'first') {
			$teams[$group->id] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', $group->id)->get();
			// } else {
			// 	$teams[1] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 1)->get();
			// 	$teams[2] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 3)->get();
			// }
		}
		// $teams['2A'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 2)->get();
		// $teams['2B'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 3)->get();
		// if (config('app.nendo') == 2020) {
		// 	$teams['2C'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 26)->get();
		// 	$teams['2D'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 27)->get();
		// }
		// if ($period == 'first') {
		// 	$teams['3A'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 4)->get();
		// 	$teams['3B'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 5)->get();
		// 	$teams['3C'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 6)->get();
		// 	$teams['3D'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 7)->get();
		// 	$teams['3E'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 8)->get();
		// 	$teams['3F'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 9)->get();
		// 	$teams['3G'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 10)->get();
		// 	$teams['3H'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 11)->get();
		// 	if (config('app.nendo') != 2020) {
		// 		$teams['3I'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 12)->get();
		// 	}
		// 	if (config('app.nendo') == 2022) {
		// 		$teams['3J'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 29)->get();
		// 	}
		// }else{
		// 	$teams['3FA'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 13)->get();
		// 	$teams['3FB'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 14)->get();
		// 	$teams['3FC'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 15)->get();
		// 	$teams['3FD'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 16)->get();
		// 	$teams['3FE'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 17)->get();
		// 	$teams['3FF'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 18)->get();
		// 	$teams['3SA'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 19)->get();
		// 	$teams['3SB'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 20)->get();
		// 	$teams['3SC'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 21)->get();
		// 	$teams['3SD'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 22)->get();
		// 	$teams['3SE'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 23)->get();
		// 	$teams['3SF'] = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->where('group_id', 24)->get();
		// }

		return view('front.team.index')->with(compact('nav_on', 'teams', 'period', 'groups'));
	}

	public function show($id, Request $req)
	{
		$nav_on = 'team';
		$team = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->findOrFail($id);

		$sort = $req->has('sort') ? $req->get('sort') : 'p.id';

		if ($sort == "goals") {
			$orderby = $sort . ' desc';
		} elseif ($sort == "school_year") {
			$orderby = $sort . ' desc';
		} elseif ($sort == "name") {
			$orderby = $sort . ' desc';
		} elseif ($sort == "height") {
			$orderby = $sort . ' desc';
		} elseif ($sort == "related_team") {
			$orderby = $sort . ' desc';
		} elseif ($sort == "position") {
			$orderby = $sort . ' desc';
		} else {
			$orderby = $sort;
		}

		$players = DB::select("select p.id, p.team_id, p.name, p.school_year, p.position, p.height, p.related_team, p.is_block, t.id as team_id, t.name as team_name, ifnull(g.g_cnt,0) as goals from players as p
		left join (select teams.id, teams.name from teams where deleted_at is null) as t on t.id=p.team_id
		left join (select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where deleted_at is null and created_at >= '2021-03-01' and team_id=" . $team->id . " group by goal_player_id) as g on g.goal_player_id=p.id
		where p.deleted_at is null and p.organizations_id=" . $team->organizations_id . " order by " . $orderby);

		// $goals = Goals::select('count(goal_player_id) as count', 'goal_player_id')->whereNull('deleted_at')->groupBy('goal_player_id');

		// $players = Players::select('players.id', 'players.team_id', 'players.name', 'players.school_year', 'players.position', 'players.height', 'players.related_team', 'teams.id as team_id', 'teams.name as team_name')
		// 	->join('teams', function ($join) {
		// 		$join->on('teams.id', '=', 'players.team_id')
		// 			->whereNull('teams.deleted_at');
		// 	})
		// 	->joinSub($goals, 'goals', function ($join) {
		// 		$join->on('players.id', '=', 'goals.goal_player_id');
		// 	})
		// 	->first();


		// $p =  new Players();
		// $players = $p->front_show($team, $orderby);
		// dd($players);


		// return "デザイン待ち";
		return view('front.team.show')->with(compact('nav_on', 'team', 'players'));
	}
}
