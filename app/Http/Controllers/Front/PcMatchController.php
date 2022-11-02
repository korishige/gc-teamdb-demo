<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;
use Cache;

use App\Cfg;
use App\Pref;
use App\Sports;
use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;

class PcMatchController extends Controller
{

	public function __construct()
	{
	}

	public function create()
	{
		return "match.create";
		$pref = $this->pref[$id_sites];

		$branchs = ['*' => $pref->title_full . '全域'] + DB::table('m_branchs')->where('id_sites', $id_sites)->lists('title', 'id');

		return View::make('front.pref.league.create')
			->with(['cfg' => $this->cfg, 'terms' => $this->tagall, 'sponsorAry' => $this->sponsorAry, 'news8Obj' => $this->news8Obj])
			->with(compact('pref', 'branchs'))
			->render();
	}

	public function store()
	{
		//var_dump($id_sites);
		//dd(Input::all());

		$input = Input::except('_token');

		$rules = array(
			'pass' => 'required'
		);

		$messages = array(
			'pass.required' => 'パスワードを入力してください'
		);

		$matchCnt = Matches::where('leagues_id', $input['leagues_id'])->where('home_id', $input['home_id'])->where('away_id', $input['away_id'])->count();

		if ($matchCnt > 1) {
			return \Redirect::back()
				->withInput()
				->with('msg0', 'すでに登録された対戦です');
		}

		if ($input['home_id'] == $input['away_id']) {
			return \Redirect::back()
				->withInput()
				->with('msg0', '同じチームが設定されています');
		}

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		if ($val->fails()) {
			return \Redirect::back()
				->withErrors($val->errors())
				->withInput()
				->with('messages');
		}

		$input['ip'] = $_SERVER['REMOTE_ADDR'];
		$match = Matches::create($input);

		return redirect()->back()->with('msg', '試合結果を登録しました');
	}

	public function edit($match_id)
	{
		// $pref = $this->pref[$id_sites];
		// $branchs = ['*'=>$pref->title_full.'全域']+DB::table('m_branchs')->where('id_sites',$id_sites)->lists('title','id');

		$match = Matches::find($match_id);
		$league = Leagues::find($match->leagues_id);
		$teamObj = LeagueTeams::where('leagues_id', $league->id)->orderBy('id', 'asc')->lists('name', 'id');

		return view('front.match.edit', compact('match', 'league', 'teamObj'));
	}

	public function update()
	{
		$pref = $this->pref[$id_sites];

		$input = Input::except('_token', 'id');
		$id = Input::get('id');

		$match = Matches::find($id);
		// passのチェック必須
		if ($input['pass'] != $match->pass) {
			return \Redirect::back()
				->withInput()
				->with('msg', 'パスワードが異なります');
		}

		$matchCnt = Matches::where('leagues_id', $input['leagues_id'])->where('home_id', $input['home_id'])->where('away_id', $input['away_id'])->count();

		if ($matchCnt > 1) {
			return redirect()->back()
				->withInput()
				->with('msg0', 'すでに登録された対戦です');
		}

		if ($input['home_id'] == $input['away_id']) {
			return redirect()->back()
				->withInput()
				->with('msg0', '同じチームが設定されています');
		}

		$rules = array(
			'pass' => 'required'
		);

		$messages = array(
			'pass.required' => 'パスワードを入力してください'
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		if ($val->fails()) {
			redirect()->back()
				->withErrors($val->errors())
				->withInput()
				->with('messages');
		}

		Matches::where('id', $id)->update($input);

		return redirect()->route('front.league.match', ['id' => $match->leagues_id])->with('msg', '試合結果を更新しました');
	}

	public function delete()
	{
		$input = Input::except('_token', 'id');
		$id = Input::get('id');
		$match = Matches::find($id);
		//$league_id = $match->leagues_id;

		if ($input['pass'] != $match->pass) {
			return redirect()
				->back()
				->withInput()
				->with('msg', 'パスワードが異なります');
		}
		Matches::where('id', $id)->delete();
		Comments::where('match_id', $id)->delete();

		return redirect()->route('front.league.match', ['id' => $match->leagues_id])->with('msg', '試合結果を削除しました');
	}
}
