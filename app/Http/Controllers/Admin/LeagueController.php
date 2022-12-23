<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;
use App\Teams;
use App\Pref;
use App\Groups;

use Input;
use Cache;
use DB;

class LeagueController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth.admin');
	}

	public function closing($id)
	{
		// $id : league_id

		$league = Leagues::find($id);
		$_teams = LeagueTeams::where('leagues_id', $id)->get();
		// dd($_teams);

		$resultObj = leagueOrder($id);

		// 順位補正
		$debug = array();
		// if(0 && ($league->is_closed or config('app.debug'))){
		if ($league->is_closed) {
			// dd($resultObj);
			// order by win_pt desc,get_lose desc,get_pt desc,league_teams.id asc
			foreach ($resultObj as $key => $result) {
				// $debug[] = sprintf("%d %s %d %d %d %d <br>", $result->rank, $result->name, $result->team_id, $result->win_pt, $result->get_lose, $result->get_pt);
				$adjust_result = LeagueTeams::where('leagues_id', $id)->where('team_id', $result->team_id)->first();
				// $debug[] = ['調整後の結果'=>$adjust_result->rank, '計算上のランク'=>$result->rank];
				$resultObj[$key]->rank = $adjust_result->rank;
				// dd($resultObj[$key]);
			}
			// 順位ソート
			// https://www.ritolab.com/entry/29
			$tmp = collect($resultObj);
			$sorted = $tmp->sortBy('rank');

			$resultObj = array();
			foreach ($sorted as $k => $sort) {
				//var_dump($sort);
				$resultObj[] = $sort;
			}
			// $resultObj = $sorted;
			// dd($tmp);
			// dd($sorted);
			// dd($resultObj);
		}

		foreach ($resultObj as $key => $result) {
			$adjust_result = LeagueTeams::whereNotNull('prestage_win_pt')->where('team_id', $result->team_id)->first();
			if ($adjust_result != null) {
				$resultObj[$key]->prestage_win_pt = $adjust_result->prestage_win_pt;
				$resultObj[$key]->win_pt = $adjust_result->prestage_win_pt + $resultObj[$key]->win_pt;
			} else {
				$resultObj[$key]->prestage_win_pt = 0;
			}
		}

		//1st1含めた勝ち点でソートする
		$resultObj = sortByKey('win_pt', SORT_DESC, $resultObj);

		$i = 1;
		foreach ($resultObj as $key => $result) {
			$result->rank = $i;
			$i++;
		}

		foreach ($resultObj as $result) :
			$teams[] = $result->team_id;
		endforeach;

		$hoge = DB::select('SELECT t1.id, lt.leagues_id, m.home_id, m.away_id, m.home_pt, m.away_pt, m.home_pk, m.away_pk FROM teams AS t1 INNER JOIN (league_teams lt INNER JOIN matches m ON lt.team_id = m.home_id) ON t1.id = m.away_id WHERE lt.leagues_id = ' . $id . ' and m.leagues_id=' . $id);

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
			//dd($table);
			foreach ($hoge as $game) {
				//dd($game);
				//var_dump($game);
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
					//dd($table);
				} else {
					if ($table[$game->home_id][$game->away_id][0] == '対戦無') {
						if ($game->home_pk > $game->away_pk) {
							$table[$game->home_id][$game->away_id][0] = $game->home_pt . '(' . $game->home_pk . ')' . '▲' . '(' . $game->away_pk . ')' . $game->away_pt;
							$table[$game->away_id][$game->home_id][0] = $game->away_pt . '(' . $game->away_pk . ')' . '△' . '(' . $game->home_pk . ')' . $game->home_pt;
						} else {
							$table[$game->home_id][$game->away_id][0] = $game->home_pt . '(' . $game->home_pk . ')' . '△' . '(' . $game->away_pk . ')' . $game->away_pt;
							$table[$game->away_id][$game->home_id][0] = $game->away_pt . '(' . $game->away_pk . ')' . '▲' . '(' . $game->home_pk . ')' . $game->home_pt;
						}
					}
					//dd($table);
				}
			}
			// dd($table);
		}

		return view('admin.league.closing', compact('resultObj', 'league', 'table', '_teams', 'debug'));
	}

	public function close(Request $req)
	{
		// dd($req->all());
		$league_id = $req->get('id');
		$league = Leagues::find($league_id);

		$resultObj = leagueOrder($league_id);

		if ($req->has('rank')) {
			$win_pt = null;
			foreach ($req->get('rank') as $team_id => $rank) {
				if ($league->season == 0) {
					foreach ($resultObj as $result) {
						if ($result->team_id == $team_id) {
							$win_pt = $result->win_pt;
						}
					}
				}
				LeagueTeams::where('leagues_id', $league_id)->where('team_id', $team_id)->update(['rank' => $rank, 'prestage_win_pt' => $win_pt]);
			}
		}

		$is_closed = $req->get('is_closed');
		Leagues::where('id', $league_id)->update(compact('is_closed'));

		return redirect()->route('admin.league.index')->with('msg', '保存しました');
	}

	public function index()
	{
		// dd(\Input::all());

		$leagueObj = Leagues::orderBy('id', 'desc');

		// if(Input::has('pref') && Input::get('pref')!='*')
		//   $leagueObj = $leagueObj->where('pref',Input::get('pref'));

		if (Input::has('convention') && Input::get('convention') != '')
			$leagueObj = $leagueObj->where('convention', Input::get('convention'));

		if (Input::has('group_id') && Input::get('group_id') != '')
			$leagueObj = $leagueObj->where('group_id', Input::get('group_id'));

		if (Input::has('year') && Input::get('year') != '')
			$leagueObj = $leagueObj->where('year', Input::get('year'));

		if (Input::has('season') && Input::get('season') != '')
			$leagueObj = $leagueObj->where('season', Input::get('season'));

		if (Input::has('keyword') && Input::get('keyword') != '')
			$leagueObj = $leagueObj->where('name', 'like', '%' . Input::get('keyword') . '%');

		$leagueObj = $leagueObj->get();

		return view('admin.league.index', ['leagueObj' => $leagueObj]);
	}

	public function table($id)
	{
		$league = Leagues::find($id);

		$resultObj = leagueOrder($id);

		//dd($resultObj);
		foreach ($resultObj as $result) :
			$teams[] = $result->id;
		endforeach;

		$hoge = DB::select('SELECT
			t.id,
			t.leagues_id,
			ti.home_id,
			ti.away_id,
			ti.home_pt,
			ti.away_pt 
			FROM
			teams AS t1 INNER JOIN (league_teams t INNER JOIN matches ti ON t.id = ti.home_id) ON t1.id = ti.away_id WHERE t.leagues_id = ' . $id);

		//dd($hoge);

		$table = array_fill_keys($teams, array_fill_keys($teams, array_fill_keys([0, 1], '-')));
		foreach ($hoge as $game) {
			//var_dump($game);
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


		//dd($table);


		// foreach($resultObj as $home):
		//   foreach($resultObj as $away):
		//     $matchAry[$home->id][$away->id] = Matches::where('leagues_id',$home->leagues_id)->where('home_id',$home->id)->where('away_id',$away->id)->select(['home_pt','away_pt'])->get()->toArray();
		//   endforeach;
		// endforeach;

		//dd($matchAry);

		return view('admin.league.table', compact('resultObj', 'league', 'table'));
	}

	public function show($id)
	{
		$league = Leagues::find($id);
		$resultObj = leagueOrder($id);

		//dd($resultObj);

		return view('admin.league.show', compact('resultObj', 'league'));
		return "順位表表示";
	}

	public function create()
	{
		// $pref = Input::has('pref') ? Input::get('pref') : '*';

		$group_sort = Groups::whereNotNull('order')->orderBy('order', 'asc')->lists('id')->toArray();
		$group_ids = implode(',', $group_sort);

		// TODO : グループごとにソートしてあげる
		// TODO : 大会を追加する際に、変更する
		// $_teams = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo_backend'))->where(function ($q) {
		// 	$q->whereNull('period')->orWhere('period', config('app.period'));
		// })->orderByRaw("FIELD(group_id, " . $group_ids . ")")->get();

		$_teams = Teams::get();
		$teams = array();
		foreach ($_teams as $team) {
			$teams[$team->id] = $team->name;
		}

		$_prefs = pref::get();
		$prefs = array();
		foreach ($_prefs as $pref) {
			$prefs[$pref->id] = $pref->name;
		}

		return view('admin.league.create', compact('teams', 'prefs'));
	}

	public function store()
	{
		$input = Input::except('_token', 'teams', 'prefs');

		$rules = array(
			'year' => 'required',
			'name' => 'required',
		);

		$messages = array(
			'name.required' => '名称を入力してください',
			'year.required' => '年度を入力してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		if ($val->fails()) {
			return redirect()->back()
				->withErrors($val->errors())
				->withInput()
				->with('messages');
		}

		// $array = [1,2,3];

		// $array[] = 4;

		// $array['prefs'] = [1,2,3];

		$prefs = Input::get('prefs');

		foreach ($prefs as $pref) {
			$ps[] = explode(':', $pref)[0];
			$prefec = implode(",", $ps);
		}

		$input['pref'] = $prefec;
		$league = Leagues::create($input);


		foreach (Input::get('teams') as $team) {
			$tmp = explode(':', $team);
			LeagueTeams::create(['leagues_id' => $league->id, 'team_id' => $tmp[0], 'name' => explode('@', $tmp[1])[0]]);
		}

		return redirect()->route('admin.league.index')->with('msg', '保存しました');
	}

	public function edit($id)
	{
		$league = Leagues::find($id);
		$_teams = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', $league->year)->orderBy('group_id', 'asc')->get();
		$teams = array();
		foreach ($_teams as $team) {
			$teams[$team->id] = $team->name;
		}

		$_prefs = pref::get();
		// dd($_prefs);
		$prefs = array();
		foreach ($_prefs as $pref) {
			$prefs[$pref->id] = $pref->name;
		}
		// $teams = Teams::all()->lists('name','id');

		return view('admin.league.edit', compact('league', 'teams', 'prefs'));
	}

	public function update()
	{
		// dd(Input::all());
		$input = Input::except('_token', 'id', 'teams', 'prefs');
		$prefs = Input::get('prefs');
		foreach ($prefs as $pref) {
			$ps[] = explode(':', $pref)[0];
			$prefec = implode(",", $ps);
		}
		$input['pref'] = $prefec;
		// dd($input);
		// foreach ($prefs as $pref) {
		// 	$ps[] = explode(':', $pref)[0];
		// 	$prefec = implode(",", $ps);
		// }


		$id = Input::get('id');

		$rules = array(
			'year' => 'required',
			'name' => 'required'
		);

		$messages = array(
			'name.required' => '名称を入力してください',
			'year.required' => '年度を入力してください'
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		if ($val->fails()) {
			redirect()->back()
				->withErrors($val->errors())
				->withInput()
				->with('messages');
		}



		Leagues::where('id', $id)->update($input);

		// TODO: 開始されたら変更できないようにしたい
		// LeagueTeams::where('leagues_id',$id)->delete();
		// foreach(Input::get('teams') as $team){
		//   $tmp = explode(':',$team);
		//   LeagueTeams::create(['leagues_id'=>$league->id,'team_id'=>$tmp[0], 'name'=>$tmp[1]]);      
		// }

		// foreach(explode('/',Input::get('team')) as $team){
		//   LeagueTeams::create(['leagues_id'=>$id,'name'=>$team]);
		// }
		// $league = Leagues::create($input);

		// foreach (Input::get('teams') as $team) {
		// 	$tmp = explode(':', $team);
		// 	// チーム名@所属グループのようになっているので、チーム名だけ抜き出す
		// 	LeagueTeams::create(['leagues_id' => $league->id, 'team_id' => $tmp[0], 'name' => $tmp[1]]);
		// }

		return redirect()->route('admin.league.index')->with('msg', '保存しました');
	}

	public function delete($id)
	{
		Leagues::where('id', $id)->delete();
		LeagueTeams::where('leagues_id', $id)->delete();
		Matches::where('leagues_id', $id)->delete();
		Comments::where('leagues_id', $id)->delete();

		return redirect()->route('admin.league.index')->with('msg', '削除しました');
	}
}
