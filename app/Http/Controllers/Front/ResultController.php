<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;

use App\Matches;
use App\Leagues;
use App\Groups;

class ResultController extends Controller
{

	public function __construct()
	{
	}

	public function index($groups_id = 1, $period = '')
	{
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'result';

		if ($period == 'first') {
			$season = 0;
		} else {
			$season = 1;
		}

		// 部に所属するグループ抜き出し
		// if ($groups_id != 3) {
		// 	$group_ids = Groups::where('grouping', $groups_id)->lists('id');
		// } else {
		//$group_ids = Groups::where('grouping', $groups_id)->lists('id');
		// }

		$group = Groups::find($groups_id);
		$groups = Groups::where('convention', config('app.convention'))->get();

		//	$group_ids = Groups::where('grouping',$groups_id)->lists('id');
		// 部に属するリーグ抜き出し

		// 指定順にソートする方法のサンプル
		//	  $_teams = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy',2021)->orderByRaw( "FIELD(group_id, ".$group_ids.")" )->get();

		// $leagues = Leagues::where('year', config('app.nendo'))->whereIn('group_id', $group_id)->orderByRaw("FIELD(group_id, " . implode(',', $group_ids->toArray()) . ")")->get();

		$leagues = Leagues::where('convention', config('app.convention'))->where('year', config('app.nendo'))->where('group_id', $groups_id)->where('season', $season)->get();

		// $g = Groups::where('grouping', $groups_id)->lists('id');
		// dd($g);

		foreach ($leagues as $league) {
			$matches[$league->id] = Matches::with('away', 'home', 'venue', 'goals', 'leagueOne')->where('leagues_id', $league->id)->whereHas('leagueOne', function ($q) use ($groups_id) {
				// return $q->whereIn('group_id',$g);
				return $q->where('year', config('app.nendo'))->where('group_id', $groups_id);
			})->where('match_date', '<=', \DB::raw('current_timestamp + interval -6 hour'))->orderBy('match_at', 'desc')->paginate(18);
		}

		return view('front.result.index')->with(compact('groups_id', 'leagues', 'nav_on', 'matches', 'period', 'group', 'groups'));
	}

	public function group($group_id = 2, $period = '')
	{
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'result';

		$leagues = Leagues::where('year', config('app.nendo'))->where('group_id', $group_id)->get();

		$g = Groups::where('id', $group_id)->first();
		$groups = $g->grouping;

		if ($leagues != NULL) {
			$league_ids = Leagues::where('year', config('app.nendo'))->where('group_id', $group_id)->lists('id');
			foreach ($league_ids as $league_id) {
				$matches = Matches::with('away', 'home', 'venue', 'goals', 'leagueOne')->where('match_date', '<=', \DB::raw('current_timestamp + interval -6 hour'))->whereIn('leagues_id', $league_ids)->orderBy('match_at', 'desc')->paginate(18);
			}
		} else {
			$matches = null;
		}

		return view('front.result.group')->with(compact('group_id', 'groups', 'leagues', 'nav_on', 'matches', 'period'));
	}

	public function show($id)
	{
		// $id : 試合ID
		$nav_on = 'result';

		$match = Matches::with('away0', 'home0', 'venue', 'goals', 'leagueOne', 'gallery')->find($id);
		return view('front.result.show')->with(compact('nav_on', 'match'));
	}
}
