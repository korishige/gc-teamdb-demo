<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;
use App\Venue;

use Input;
use Cache;

class MatchController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth.admin');
	}

	public function index($league_id)
	{
		$league = Leagues::find($league_id);
		$matchObj = Matches::where('leagues_id', $league_id)->orderBy('id', 'asc')->get();
		return view('admin.match.index', ['matchObj' => $matchObj, 'league' => $league]);
	}

	public function create($league_id)
	{
		
		// $pref = Leagues::where('id', $league_id)->select('pref')->first();
		$league = Leagues::where('id', $league_id)->first();
		// dd($league->pref);
		$prefs = explode(",", $league->pref);
		$prefs[] = 0;
		$teams = LeagueTeams::where('leagues_id', $league_id)->orderBy('id', 'asc')->lists('name', 'team_id');
		$matchObj = Matches::where('leagues_id', $league_id)->orderBy('id', 'asc')->get();
		return view('admin.match.create', compact('league', 'teams', 'matchObj', 'league_id', 'prefs'));
	}

	public function store()
	{	
		
		// $items = \App\Leagues::select('pref')->get();
		// dd($items);
		$input = Input::except('_token', 'pending');
		$pending = Input::get('pending');

		if ($pending == 1) {
			$input['match_date'] = date('Y-m-d');
			$sort = $input['match_date'] . '+1 year';
			$date = date("Y-m-d", strtotime($sort));
			$input['match_at'] = sprintf("%s %s", $date, $input['match_time']);
			$input['is_publish'] = 3;
		} else {
			$rules = array(
				//      'section'=>'required',
				'match_date' => 'required',
				'match_time' => 'required',
			);

			$messages = array(
				'section.required' => '節を入力してください',
				'match_date.required' => '試合日を入力してください',
				'match_time.required' => '試合開始時刻を入力してください',
			);

			$matchCnt = Matches::where('leagues_id', $input['leagues_id'])->where('home_id', $input['home_id'])->where('away_id', $input['away_id'])->count();
			//	  	$matchCnt = Matches::where('leagues_id',$input['leagues_id'])->where(function($q) use($input) { $q->where('home_id',$input['home_id'])->orWhere('away_id',$input['away_id']);})->count();

			if ($matchCnt > 1) {
				return redirect()->back()
					->withInput()
					->with('error-msg', 'すでに登録された対戦です');
			}

			if ($input['home_id'] == $input['away_id']) {
				return redirect()->back()
					->withInput()
					->with('error-msg', '同じチームが設定されています');
			}

			//バリデーション処理
			$val = \Validator::make($input, $rules, $messages);
			if ($val->fails()) {
				return redirect()->back()
					->withErrors($val->errors())
					->withInput()
					->with('messages');
			}
			$input['match_at'] = sprintf("%s %s", $input['match_date'], $input['match_time']);
		}

		// if($input['home_pk']=='') unset($input['home_pk']);
		// if($input['away_pk']=='') unset($input['away_pk']);

		if ($input['judge_id'] == '') $input['judge_id'] = NULL;
		if ($input['section'] == '') $input['section'] = NULL;


		// $input['ip'] = $_SERVER['REMOTE_ADDR'];
		Matches::create($input);

		return redirect()->route('admin.match.index', ['leagues_id' => $input['leagues_id']])->with('msg', '保存しました');
	}

	public function edit($id)
	{
		$match = Matches::find($id);
		
		// dd($league);
		// dd($match);
		
		$teamObj = LeagueTeams::where('leagues_id', $match->leagues_id)->orderBy('id', 'asc')->lists('name', 'team_id');
		
		// $prefs = explode(",", $league->pref);
		// $prefs[] = 0;
		
		$league_id = $match->leagues_id;
		$league = Leagues::where('id', $league_id)->first();
		$prefs = explode(",", $league->pref);
		$prefs[] = 0;
				
		return view('admin.match.edit')->with(compact('match', 'league', 'teamObj', 'prefs'));
	}

	public function update()
	{
		// dd(\Input::all());
		$input = Input::except('_token', 'id');
		$id = Input::get('id');

		if ($input['is_publish'] == 3) {
			$input['match_date'] = date('Y-m-d');
			$sort = $input['match_date'] . '+1 year';
			$date = date("Y-m-d", strtotime($sort));
			$input['match_at'] = sprintf("%s %s", $date, $input['match_time']);
			$input['is_publish'] = 3;
		} else {
			$rules = array(
				//			'section' => 'required',
				'match_date' => 'required',
				'match_time' => 'required',
			);

			$messages = array(
				'section.required' => '節を入力してください',
				'match_date.required' => '試合日を入力してください',
				'match_time.required' => '試合開始時刻を入力してください',
			);

			// dd($input);

			//		$matchCnt = Matches::where('leagues_id', $input['leagues_id'])->where('home_id', $input['home_id'])->where('away_id', $input['away_id'])->count();
			//		$matchCnt = Matches::where('leagues_id',$input['leagues_id'])->where(function($q) use($input) { $q->where('home_id',$input['home_id'])->orWhere('away_id',$input['away_id']);})->count();

			//		if ($matchCnt > 1) {
			//			return redirect()->back()
			//				->withInput()
			//				->with('error-msg', 'すでに登録された対戦です');
			//		}

			if ($input['home_id'] == $input['away_id']) {
				return redirect()->back()
					->withInput()
					->with('msg', '同じチームが設定されています');
			}

			//バリデーション処理
			$val = \Validator::make($input, $rules, $messages);
			if ($val->fails()) {
				redirect()->back()
					->withErrors($val->errors())
					->withInput()
					->with('messages');
			}

			if ($input['is_publish'] == 2) {
				$sort = $input['match_date'] . '+1 year';
				$date = date("Y-m-d", strtotime($sort));
				$input['match_at'] = sprintf("%s %s", $date, $input['match_time']);
			} else {
				$input['match_at'] = sprintf("%s %s", $input['match_date'], $input['match_time']);
			}
		}

		if ($input['judge_id'] == '') $input['judge_id'] = NULL;
		if ($input['section'] == '') $input['section'] = NULL;

		Matches::where('id', $id)->update($input);

		return redirect()->route('admin.match.index', ['league_id' => $input['leagues_id']])->with('msg', '保存しました');
	}

	public function delete($id)
	{
		Matches::where('id', $id)->delete();
		// Comments::where('match_id',$id)->delete();
		return redirect()->route('admin.match.index')->with('msg', '削除しました');
	}
}
