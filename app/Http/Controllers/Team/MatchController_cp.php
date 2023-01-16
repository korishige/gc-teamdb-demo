<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;
use App\Players;
use App\Goals;
use App\Cards;
use App\Options;

use Input;
use Cache;

class MatchController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth.team');
	}

	public function edit($id)
	{
		$match = Matches::where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->findOrFail($id);
		// dd($match);
		$teams = LeagueTeams::where('leagues_id', $match->leagues_id)->orderBy('id', 'asc')->lists('name', 'team_id');

		$players1 = Players::with('team')->where('team_id', $match->home_id)->where('school_year', '<', 2000)->get();
		$players2 = Players::with('team')->where('team_id', $match->away_id)->where('school_year', '<', 2000)->get();

		// 選手が登録されていないと例外が発生する
		$all_players_home['name'] = array();
		$all_players_away['name'] = array();
		$players_home['name'] = array();
		$players_away['name'] = array();

		foreach ($players1 as $player) {
			$all_players_home['name'][$player->id] = $player->team->name . ' | ' . $player->name;
			$players_home['name'][$player->id] = $player->name;
			if ($player->yellow_cards() != 0) $players_home['name'][$player->id] . ' | 警告:' . $player->yellow_cards();
			if ($player->red_cards() != 0) $players_home['name'][$player->id] . ' | 退場:' . $player->red_cards();
		}

		foreach ($players2 as $player) {
			$all_players_home['name'][$player->id] = $player->team->name . ' | ' . $player->name;
			$players_away['name'][$player->id] = $player->name;
			if ($player->yellow_cards() != 0) $players_away['name'][$player->id] . ' | 警告:' . $player->yellow_cards();
			if ($player->red_cards() != 0) $players_away['name'][$player->id] . ' | 退場:' . $player->red_cards();
		}

		foreach ($players2 as $player) {
			$all_players_away['name'][$player->id] = $player->team->name . ' | ' . $player->name;
		}

		foreach ($players1 as $player) {
			$all_players_away['name'][$player->id] = $player->team->name . ' | ' . $player->name;
		}

		// $players = Players::where(function($q) use ($match){
		//   $q->where('team_id',$match->home_id)->orWhere('team_id', $match->away_id);
		// })->get()->lists('name','id');

		return view('team.match.edit')->with(compact('match', 'teams', 'all_players_home', 'all_players_away', 'players_home', 'players_away'));
	}

	public function update(Request $req)
	{
		// dd(\Input::all());
		$input_match = $req->only('home_pt', 'away_pt', 'home_pk', 'away_pk', 'note', 'home_comment', 'away_comment', 'mom_home', 'mom_away');
		$input_goals = $req->only(['home_goals', 'away_goals']);
		$input_cards = $req->only(['home_cards', 'away_cards']);
		$id = Input::get('id');

		// dd($input_match, $input_goals, $input_cards);

		// homeチームだけが、得点、ゴール、警告を記載可能
		$match = Matches::find($id);

		if ($match->home_id == $req->session()->get('team_id')) {
			$input_match = $req->only('home_pt', 'away_pt', 'home_pk', 'away_pk', 'note', 'home_comment', 'mom_home', 'mom_away');

			$rules = array(
				'home_pt' => 'required|integer',
				'away_pt' => 'required|integer',
			);

			$messages = array(
				'home_pt.required' => 'ホームチームの得点を入力してください',
				'home_pt.integer' => 'ホームチームの得点が整数ではないようです',
				'away_pt.required' => 'アウェイチームの得点を入力してください',
				'away_pt.integer' => 'アウェイチームの得点が整数ではないようです',
			);

			$val = \Validator::make($input_match, $rules, $messages);
			if ($val->fails()) {
				return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
			}

			// TODO : 本当はここで、home_ptとhome_goals数、away_ptとaway_goals数のチェックをしたい
			if (1) {
				$rules = array();
				$messages = array();
				for ($i = 0; $i < 20; $i++) {
					$rules["home_goals.$i.player"] = "required_with:home_goals.$i.time";
					$rules["away_goals.$i.player"] = "required_with:away_goals.$i.time";
					$rules["home_goals.$i.time"] = "required_with:home_goals.$i.player";
					$rules["away_goals.$i.time"] = "required_with:away_goals.$i.player";

					$messages["home_goals.$i.player.required_with"] = 'ホームチーム得点の時間が設定されていないようです';
					$messages["away_goals.$i.player.required_with"] = 'アウェイチーム得点の時間が設定されていないようです';
					$messages["home_goals.$i.time.required_with"] = 'ホームチーム得点の選手が設定されていないようです';
					$messages["away_goals.$i.time.required_with"] = 'アウェイチーム得点の選手が設定されていないようです';
				}

				$val = \Validator::make($input_goals, $rules, $messages);

				if ($val->fails()) {
					return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
				}

				$rules = [];
				$messages = array();

				for ($i = 0; $i < 5; $i++) {
					$rules["home_cards.$i.time"] = "required_with:home_cards.$i.player,home_cards.$i.type";
					$rules["away_cards.$i.time"] = "required_with:away_cards.$i.player,away_cards.$i.type";
					$rules["home_cards.$i.type"] = "required_with:home_cards.$i.player,home_cards.$i.time";
					$rules["away_cards.$i.type"] = "required_with:away_cards.$i.player,away_cards.$i.time";
					$rules["home_cards.$i.player"] = "required_with:home_cards.$i.time,home_cards.$i.type";
					$rules["away_cards.$i.player"] = "required_with:away_cards.$i.time,away_cards.$i.type";

					$messages["home_cards.$i.time.required_with"] = 'ホームチーム 警告・退場の時間が設定されていません';
					$messages["away_cards.$i.time.required_with"] = 'アウェイチーム 警告・退場の時間が設定されていません';
					$messages["home_cards.$i.type.required_with"] = 'ホームチーム 警告・退場の警告種別が設定されていません';
					$messages["away_cards.$i.type.required_with"] = 'アウェイチーム 警告・退場の警告種別が設定されていません';
					$messages["home_cards.$i.player.required_with"] = 'ホームチーム 警告・退場の対象選手が設定されていません';
					$messages["away_cards.$i.player.required_with"] = 'アウェイチーム 警告・退場の対象選手が設定されていません';
				}

				$val = \Validator::make($input_cards, $rules, $messages);

				if ($val->fails()) {
					return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
				}

				$goals['home'] = 0;
				$goals['away'] = 0;

				foreach (['home', 'away'] as $type) {
					foreach ($req->only($type . '_goals') as $_goals) {
						foreach ($_goals as $goal) {
							if ($type == 'home' && $goal['player'] != '') $goals['home'] += 1;
							if ($type == 'away' && $goal['player'] != '') $goals['away'] += 1;
						}
					}
				}

				$msg = '';

				if ($input_match['home_pt'] != $goals['home']) $msg += 'ホームチームの得点と得点情報の結果が異なります。';
				if ($input_match['away_pt'] != $goals['away']) $msg += 'アウェイチームの得点と得点情報の結果が異なります。';

				if ($msg != '') {
					return \Redirect::back()->withErrors($val->errors())->withInput()->with(['error-msg' => $msg]);
				}

				// dd($goals);
				// dd($input_match, $input_goals, $input_cards);
			}

			$data = array();
			$match = Matches::find($id);

			// TODO : 既存のデータを削除
			Goals::where('match_id', $match->id)->delete();
			Cards::where('match_id', $match->id)->delete();

			foreach (['home', 'away'] as $type) {
				foreach ($req->only($type . '_goals') as $_goals) {
					foreach ($_goals as $goal) {
						// var_dump($goal);
						$data['league_id'] = $match->leagueOne->id;
						$data['match_id'] = $match->id;
						if ($type == 'home') {
							$data['team_id'] = $match->home_id;
						} else {
							$data['team_id'] = $match->away_id;
						}

						// dd($goal);
						// if($goal['time']!='' or $goal['addtime']!=''){
						if ($goal['time'] != '') {
							$data['h_or_a'] = $type;
							$data['time'] = ($goal['time'] != '') ? $goal['time'] : NULL;
							// $data['addtime'] = ($goal['addtime']!='')?$goal['addtime']:NULL;
							$data['goal_player_id'] = ($goal['player'] != '') ? $goal['player'] : NULL;
							// $data['ass_player_id'] = ($goal['assist']!='')?$goal['assist']:NULL;

							Goals::create($data);
						}
					}
				}
			}

			$data = array();
			$_players = array();
			foreach (['home', 'away'] as $type) {
				foreach ($req->only($type . '_cards') as $_cards) {
					foreach ($_cards as $card) {
						$data['league_id'] = $match->leagueOne->id;
						$data['match_id'] = $match->id;
						if ($type == 'home') {
							$data['team_id'] = $match->home_id;
						} else {
							$data['team_id'] = $match->away_id;
						}

						// dd($goal);
						// if($card['time']!='' or $card['addtime']!=''){
						if ($card['time'] != '') {
							$data['h_or_a'] = $type;
							$data['time'] = ($card['time'] != '') ? $card['time'] : NULL;
							// $data['addtime'] = ($card['addtime']!='')?$card['addtime']:NULL;
							$data['player_id'] = ($card['player'] != '') ? $card['player'] : NULL;
							$data['color'] = $card['type'];
							$data['nendo'] = config('app.nendo');

							// カードが出された選手IDを保存しておく
							$_players[] = $card['player'];
							Cards::create($data);
						}
					}
				}
			}

			//大会設定のイエロカードの出場停止枚数を取得
			$option = Options::where('option_number', 2)->first();
			// カードが出された選手のみイエロー２枚 or レッド１枚にならないかチェック
			foreach (array_unique($_players) as $p) {
				$player = Players::find($p);
				// 該当選手のイエローカードが２枚 or レッドカードが１枚の場合、次の試合開始日時＋２時間まで、出場停止期間を設定する。
				$y_count = Cards::where('player_id', $p)->where('color', 'yellow')->where('is_cleared', 0)->where('nendo', config('app.nendo'))->count();
				$r_count = Cards::where('player_id', $p)->where('color', 'red')->where('is_cleared', 0)->where('nendo', config('app.nendo'))->count();
				if ($y_count == $option->value) {
					$next_match = Matches::selectRaw('match_at')->with('leagueOne', 'home0', 'away0', 'place')->where('is_filled', 0)->where(function ($q) use ($player) {
						return $q->where('home_id', $player->team_id)->orWhere('away_id', $player->team_id);
					})->where('match_at', '>', date('Y-m-d H:i'))->orderBy('match_at', 'asc')->take(1)->first();

					$next_match_after_2h = date('Y-m-d H:i', strtotime($next_match['match_at'] . " +2 hours"));
					Players::where('id', $player->id)->update(['suspension_at' => $next_match_after_2h]);

					// イエロー２枚のあとは、既存のイエローカードをリフレッシュ
					// Cards::where('player_id', $p)->where('color', 'yellow')->where('is_cleared',0)->update(['is_cleared'=>1]);

				}

				if ($r_count == 1) {
					$next_match = Matches::selectRaw('match_at')->with('leagueOne', 'home0', 'away0', 'place')->where('is_filled', 0)->where(function ($q) use ($player) {
						return $q->where('home_id', $player->team_id)->orWhere('away_id', $player->team_id);
					})->where('match_at', '>', date('Y-m-d H:i'))->orderBy('match_at', 'asc')->take(1)->first();

					$next_match_after_2h = date('Y-m-d H:i', strtotime($next_match['match_at'] . " +2 hours"));
					Players::where('id', $player->id)->update(['suspension_at' => $next_match_after_2h]);

					// レッド後、出場停止期間を設定後は、リセット
					// Cards::where('player_id', $p)->where('color', 'red')->where('is_cleared',0)->update(['is_cleared'=>1]);
				}
			}
			// return "hoge";

			// 入力済みフラグをセット
			$input_match['is_filled'] = 1;
		} else {
			$input_match = $req->only('away_comment', 'away_note');
		}

		Matches::where('id', $id)->update($input_match);

		return redirect()->route('team.top')->with('msg', '保存しました');
	}

	public function day_edit($id)
	{
		$match = Matches::where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->findOrFail($id);

		return view('team.match.day_edit')->with(compact('match'));
	}


	public function day_update(Request $request)
	{
		$match = Matches::where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->findOrFail($request->id);

		if ($request->is_publish == 2) {
			$match->is_publish = $request->is_publish;
		} elseif ($request->is_publish == 3) {
			$match->is_publish = $request->is_publish;
			$match->match_date = '2023-04-01';
			$match->match_time = null;
		} else {
			$match->match_date = $request->match_date;
			$match->match_time = $request->match_time;
			$match->match_at = $request->match_date . ' ' . $request->match_time;
			$match->is_publish = 0;
		}

		$match->save();

		return redirect()->route('team.top')->with('msg', '試合日を変更しました');
	}

	public function venue_edit($id)
	{
		$match = Matches::where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->findOrFail($id);

		return view('team.match.venue_edit')->with(compact('match'));
	}

	public function venue_update(Request $request)
	{
		$match = Matches::where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->findOrFail($request->id);

		$match->place_id = $request->place_id;

		$match->save();

		return redirect()->route('team.top')->with('msg', '会場を変更しました');
	}

	// public function delete($id){
	//   Matches::where('id',$id)->delete();
	//   // Comments::where('match_id',$id)->delete();
	//   return redirect()->route('admin.match.index')->with('msg','削除しました');
	// }

	public function mom_mov_edit($id)
	{
	}
}
