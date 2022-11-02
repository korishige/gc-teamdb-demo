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

class ScheduleController extends Controller
{

	public function __construct()
	{
	}

	public function index(Request $req, $groups_id = 1, $period = '')
	{
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'schedule';

		if ($period == 'second') {
			$season = 1;
		} else {
			$season = 0;
		}

		$sort = $req->has('sort') ? $req->get('sort') : 'match_at';

		//    $group_id = Input::has('groups')?Input::get('groups'):1;
		//	  $groups_id =

		// 部に所属するグループ抜き出し
		// if ($groups_id != 3) {
		// 	$groups = Groups::where('grouping', $groups_id)->lists('id');
		// } else {
		// $groups = Groups::where('grouping', $groups_id)->lists('id');
		// }

		$groups = Groups::where('convention', config('app.convention'))->get();


		// 部に属するリーグ抜き出し
		$leagues = Leagues::where('year', config('app.nendo'))->where('group_id', $groups_id)->where('season', $season)->where('convention', config('app.convention'))->get();
		// 部に属するリーグIDのみ抜き出し
		$league_ids = Leagues::where('year', config('app.nendo'))->where('group_id', $groups_id)->where('convention', config('app.convention'))->lists('id');

		foreach ($league_ids as $league_id) {
			// $matches = Matches::with('away0','home0','place')->whereIn('leagues_id',$league_ids)->orderBy('section','asc')->get();
			$matches[$league_id] = Matches::with('away0', 'home0', 'place')->where('leagues_id', $league_id)->orderBy($sort, 'asc')->get();
		}
		// dd($matches);

		return view('front.schedule.index')->with(compact('groups_id', 'nav_on', 'matches', 'leagues', 'period', 'groups'));
	}

	public function group($group_id, $period = '')
	{
		$period = ($period == '') ? config('app.period') : $period;
		$nav_on = 'schedule';

		if ($period == 'first') {
			$season = 0;
		} else {
			$season = 1;
		}

		// 対象グループのリーグ抜き出し
		// $league = Leagues::where('group_id',$group_id)->first();
		$leagues = Leagues::where('year', config('app.nendo'))->where('group_id', $group_id)->where('season', $season)->get();

		$g = Groups::where('id', $group_id)->first();
		$groups = $g->grouping;

		if ($leagues != NULL) {
			// 部に属するリーグIDのみ抜き出し
			$league_ids = Leagues::where('year', config('app.nendo'))->where('group_id', $group_id)->lists('id');
			$matches = Matches::with('away', 'home', 'place')->whereIn('leagues_id', $league_ids)->orderBy('match_at', 'asc')->get();
		} else {
			$matches = null;
		}

		return view('front.schedule.group')->with(compact('groups', 'group_id', 'nav_on', 'matches', 'leagues', 'period'));
	}

	public function show($id)
	{
		$nav_on = 'schedule';
		$news = News2::findOrFail($id);
		return view('front.news.show')->with(compact('nav_on', 'news'));
	}
}
