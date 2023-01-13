<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\User;
use App\News;
use App\Teams;
use App\Matches;
use App\Cfg;
use App\Players;
use App\StartingMembers;

class Main2Controller extends Controller
{

	public function __construct()
	{
		$this->middleware('auth.team');
	}

	public function top(Request $req)
	{
		$newsObj = News::where('is_publish', 1)->take(5)->orderBy('dis_dt', 'desc')->get();

		// $a = \App\Matches::where(function($q){
		//     $q->where('home_id',\Session::get('team_id'))->orWhere('away_id',\Session::get('team_id'));
		// })->whereRaw("DATE_FORMAT(match_date, '%Y%m') = '201905'")->get();

		$matches = Matches::with('leagueOne', 'home0', 'away0', 'place')->where('is_filled', 0)->where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		});

		if ($req->has('y'))
			$matches = $matches->whereRaw('(DATE_FORMAT(match_date, "%Y") = ' . $req->get('y') . ')');

		if ($req->has('m'))
			$matches = $matches->whereRaw('(DATE_FORMAT(match_date, "%m") = ' . $req->get('m') . ')');

		$matches = $matches->orderBy('match_at', 'asc')->paginate(10);

		$matches0 = Matches::with('leagueOne', 'home0', 'away0', 'place')->where('is_filled', 1)->where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		});
		$matches0 = $matches0->orderBy('match_at', 'desc')->get();

		$team = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo'))->find(\Session::get('team_id'));

		return view('team.top')->with(compact('newsObj', 'matches', 'team', 'matches0'));
	}

	public function check($id)
	{
		$match = Matches::findOrFail($id);
		$home_players = DB::select("select p.id, p.name, p.school_year, p.is_block,ifnull(g.g_cnt,0) as goals, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red, suspension_at from players as p
 left join (select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where deleted_at is null and created_at >= '" . config('app.nendo') . "-03-01' and team_id=" . $match->home_id . " group by goal_player_id) as g on g.goal_player_id=p.id
 left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and created_at >= '" . config('app.nendo') . "-03-01' and team_id=" . $match->home_id . " and color='yellow' and is_cleared=0 group by player_id) as y_card on y_card.player_id=p.id 
 left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and created_at >= '" . config('app.nendo') . "-03-01' and team_id=" . $match->home_id . " and color='red' and is_cleared=0 group by player_id) as r_card on r_card.player_id=p.id 
  where p.deleted_at is null and p.team_id=" . $match->home_id);
		$away_players = DB::select("select p.id, p.name, p.school_year, p.is_block,ifnull(g.g_cnt,0) as goals, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red, suspension_at from players as p
 left join (select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where deleted_at is null and created_at >= '" . config('app.nendo') . "-03-01' and team_id=" . $match->away_id . " group by goal_player_id) as g on g.goal_player_id=p.id
 left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and created_at >= '" . config('app.nendo') . "-03-01' and team_id=" . $match->away_id . " and color='yellow' and is_cleared=0 group by player_id) as y_card on y_card.player_id=p.id 
 left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and created_at >= '" . config('app.nendo') . "-03-01' and team_id=" . $match->away_id . " and color='red' and is_cleared=0 group by player_id) as r_card on r_card.player_id=p.id 
  where p.deleted_at is null and p.team_id=" . $match->away_id);

		return view('team.check')->with(compact('match', 'home_players', 'away_players'));
	}

	public function starter_edit($id, $starting_member_id = '')
	{
		$starting_member_id = \Input::has('starting_member_id') ? \Input::get('starting_member_id') : '';
		$match_id = $id;
		if (session('role') != 'team') return "権限がありません";

		// 過去のスタメン情報を引っ張ってきておく
		$match_histories = [];
		foreach (StartingMembers::where('team_id', \Session::get('team_id'))->where('match_id', '<>', $match_id)->orderby('match_at', 'desc')->get() as $row) {
			$_tmp = Matches::find($row->match_id);
			if ($_tmp->home_id == \Session::get('team_id')) {
				$vs_team = Teams::find($_tmp->away_id);
			} else {
				$vs_team = Teams::find($_tmp->home_id);
			}
			$match_histories[$row->match_id] = $row->match_at . ' vs ' . $vs_team->name;
		}
		//			$match_histories = StartingMembers::where('team_id',\Session::get('team_id'))->orderby('match_at','desc')->lists('match_at','id');

		if ($starting_member_id != '') {
			// 過去のスタメン情報を利用する場合
			$stm = StartingMembers::where('match_id', $starting_member_id)->where('team_id', \Session::get('team_id'))->first();
			$data = preg_replace_callback('!s:(\d+):"([\s\S]*?)";!', function ($m) {
				return 's:' . strlen($m[2]) . ':"' . $m[2] . '";';
			}, $stm->body);
			$pop = unserialize($data);
		} else {
			// 該当試合のスタメンを持ってくる。ないときは一旦空としておき、必要に応じてスタメン情報を引っ張ってもらって、保存してもらう
			$stm = StartingMembers::where('match_id', $id)->where('team_id', \Session::get('team_id'))->first();
			if ($stm == null) {
				$pop = unserialize(serialize(null));
				// ここは一旦やめておく（過去データを勝手に引っ張ると、保存したかどうか判断できなさそうなので）
				if (0) {
					// 前回の試合を引っ張る
					$stm = StartingMembers::where('team_id', \Session::get('team_id'))->orderby('match_at', 'desc')->first();
					if ($stm == null) {
						// それでもなければ空で読み込み
						$pop = unserialize(serialize(null));
					} else {
						$data = preg_replace_callback('!s:(\d+):"([\s\S]*?)";!', function ($m) {
							return 's:' . strlen($m[2]) . ':"' . $m[2] . '";';
						}, $stm->body);
						$pop = unserialize($data);
					}
				}
			} else {
				//正規表現を用いて再計算
				$data = preg_replace_callback('!s:(\d+):"([\s\S]*?)";!', function ($m) {
					return 's:' . strlen($m[2]) . ':"' . $m[2] . '";';
				}, $stm->body);
				$pop = unserialize($data);
			}
		}

		$team = Teams::findOrFail(\Session::get('team_id'));
		$match = Matches::where(function ($q) {
			$q->where('home_id', \Session::get('team_id'))->orWhere('away_id', \Session::get('team_id'));
		})->findOrFail($id);
		if (0) {
			$players = Players::where('team_id', \Session::get('team_id'))->whereNull('suspension_at')->get()->lists('name_year', 'id');
		} else {
			$players = [];
			$playerObj = \DB::select("select players.id,players.name,players.school_year from players 
    left join player_suspend on player_suspend.player_id = players.id and player_suspend.team_id = " . \Session::get('team_id') . " 
    where players.deleted_at is null and players.team_id = " . \Session::get('team_id') . " and player_suspend.suspension is null");
			//			$players = Players::where('players.team_id',\Session::get('team_id'))->leftjoin('player_suspend',function($join) {
			//				$join->on('player_suspend.player_id', '=', 'players.id')->where('player_suspend.team_id', '=', \Session::get('team_id'));
			//			})->whereNull('player_suspend.suspension')->get()->lists('name_year','players.id');
			foreach ($playerObj as $p) {
				$players[$p->id] = sprintf("%s(%s)", $p->name, array_get(config('app.schoolYearAry'), $p->school_year));
			}
		}
		return view('team.starter.edit')->with(compact('match', 'players', 'team', 'pop', 'match_id', 'match_histories'));
	}

	public function starter_update(Request $req)
	{
		if (session('role') != 'team') return "権限がありません";
		//		dd(serialize($req->except('_token')));

		$input = $req->only('cap');
		$match_id = $req->get('match_id');
		$input['team_id'] = \Session::get('team_id');
		$matchObj = Matches::where('id', $match_id)->first();
		$input['match_at'] = $matchObj->match_date;
		$input['match_id'] = $match_id;
		$input['body'] = serialize($req->except('_token'));

		// 2020-07-26
		// memo : 必要に応じて、player_idが全て現在のチームに属するかチェックしたほうがよいかも。

		$rules = array(
			'cap' => 'required',
		);

		$messages = array(
			'cap.required' => 'キャプテンを設定してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		unset($input['cap']);

		//		Teams::where('id',\Session::get('team_id'))->update($input);
		if (StartingMembers::where('team_id', \Session::get('team_id'))->where('match_id', $match_id)->count() != 1) {
			StartingMembers::create($input);
		} else {
			unset($input['team_id']);
			unset($input['match_at']);
			unset($input['match_id']);
			StartingMembers::where('team_id', \Session::get('team_id'))->where('match_id', $match_id)->update($input);
		}
		return redirect()->back()->with('msg', '保存しました');
	}

	public function starter_print($id)
	{
		if (session('role') != 'team') return "権限がありません";
		$stm = StartingMembers::where('match_id', $id)->where('team_id', \Session::get('team_id'))->first();
		if ($stm == null) {
			$pop = unserialize(serialize(null));
		} else {
			$data = preg_replace_callback('!s:(\d+):"([\s\S]*?)";!', function ($m) {
				return 's:' . strlen($m[2]) . ':"' . $m[2] . '";';
			}, $stm->body);
			$pop = unserialize($data);
		}

		$team = Teams::findOrFail(\Session::get('team_id'));
		//		$pop = unserialize($team->starter_data);

		$match = Matches::find($id);
		$players = Players::where('team_id', \Session::get('team_id'))->get()->lists('name', 'id');
		return view('team.starter.print')->with(compact('match', 'players', 'team', 'pop'));
	}

	public function edit()
	{
		$team = Teams::findOrFail(session('team_id'));
		return view('team.info.edit')->with(compact('team'));
	}

	public function confirm(Request $req)
	{
		// dd($req->all());
		$input = $req->except('_token', 'files', 'zip');
		$team = (object)$req->except('_token', 'files', 'zip');

		$rules = array(
			'name' => 'required',
			'add1' => 'required',
			'add2' => 'required',
			'url_school' => 'sometimes|url',
			'url_team' => 'sometimes|url',
			'url_blog' => 'sometimes|url',
			'url_facebook' => 'sometimes|url',
			'url_twitter' => 'sometimes|url',
			'url_instagram' => 'sometimes|url',
		);

		$messages = array(
			'name.required' => '学校名を入力してください',
			'add1.required' => '市区町村を入力してください',
			'add2.required' => '以降の住所を入力してください',
			'url_school.url' => '学校HP URLの形式を確認してください',
			'url_team.url' => 'チームHP URLの形式を確認してください',
			'url_blog.url' => 'ブログURLの形式を確認してください',
			'url_facebook.url' => 'Facebook URLの形式を確認してください',
			'url_twitter.url' => 'Twitter URLの形式を確認してください',
			'url_instagram.url' => 'Instagram URLの形式を確認してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		// 画像が入力されていないときは、DBからデータを持ってくる
		$_team = Teams::find($team->id);	// join不要

		$image = \Input::file('emblem_img');
		$del = \Input::get('emblem_img_delete');

		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$team->emblem_img = $sInfoFile['name_file'];
		} elseif ($del == 1) {
			$team->emblem_img = '';
		} else {
			$team->emblem_img = $_team->emblem_img;
		}

		$image = \Input::file('group_img');
		$del = \Input::get('group_img_delete');
		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$team->group_img = $sInfoFile['name_file'];
		} elseif ($del == 1) {
			$team->group_img = '';
		} else {
			$team->group_img = $_team->group_img;
		}

		$req->session()->put('post_data', $team);
		return view('team.info.confirm')->with(compact('team'));
	}

	public function update(Request $req)
	{
		// dd($req->all());
		// dd(\Session::get('post_data'),$req->all());

		$input = $req->except('id', '_token', 'emblem_img', 'group_img', 'manager_mov', 'captain_mov', 'zip');
		// $team = (object)$req->except('_token', 'files', 'zip');
		$id = \Session::get('team_id');

		$rules = array(
			'name' => 'required',
			'add1' => 'required',
			'add2' => 'required',
			'url_school' => 'sometimes|url',
			'url_team' => 'sometimes|url',
			'url_blog' => 'sometimes|url',
			'url_facebook' => 'sometimes|url',
			'url_twitter' => 'sometimes|url',
			'url_instagram' => 'sometimes|url',
		);

		$messages = array(
			'name.required' => '学校名を入力してください',
			'add1.required' => '市区町村を入力してください',
			'add2.required' => '以降の住所を入力してください',
			'url_school.url' => '学校HP URLの形式を確認してください',
			'url_team.url' => 'チームHP URLの形式を確認してください',
			'url_blog.url' => 'ブログURLの形式を確認してください',
			'url_facebook.url' => 'Facebook URLの形式を確認してください',
			'url_twitter.url' => 'Twitter URLの形式を確認してください',
			'url_instagram.url' => 'Instagram URLの形式を確認してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$team = Teams::find($id);	// join不要

		// ファイルアップロード
		$image = \Input::file('emblem_img');
		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$input['emblem_img'] = $sInfoFile['name_file'];
		}

		$image = \Input::file('group_img');
		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$input['group_img'] = $sInfoFile['name_file'];
		}

		$image = \Input::file('manager_mov');
		if ($image != '') {
			$sInfoFile = uploadMovie($image);
			$input['manager_mov'] = $sInfoFile['name_file'];
		}

		$image = \Input::file('captain_mov');
		if ($image != '') {
			$sInfoFile = uploadMovie($image);
			$input['captain_mov'] = $sInfoFile['name_file'];
		}

		// 実ファイル削除＆フォーム内容削除
		$del = \Input::has('emblem_img_delete') ? \Input::get('emblem_img_delete') : 0;
		if ($del == 1) {
			upfileDelete($team->emblem_img);
			$input['emblem_img'] = '';
		}
		if (isset($input['group_img_delete'])) unset($input['group_img_delete']);

		$del = \Input::has('group_img_delete') ? \Input::get('group_img_delete') : 0;
		if ($del == 1) {
			upfileDelete($team->group_img);
			$input['group_img'] = '';
		}
		if (isset($input['emblem_img_delete'])) unset($input['emblem_img_delete']);

		$del = \Input::has('manager_mov_delete') ? \Input::get('manager_mov_delete') : 0;
		if ($del == 1) {
			upmovieDelete($team->manager_mov);
			$input['manager_mov'] = '';
		}
		if (isset($input['manager_mov_delete'])) unset($input['manager_mov_delete']);

		$del = \Input::has('captain_mov_delete') ? \Input::get('captain_mov_delete') : 0;
		if ($del == 1) {
			upmovieDelete($team->captain_mov);
			$input['captain_mov'] = '';
		}
		if (isset($input['captain_mov_delete'])) unset($input['captain_mov_delete']);

		Teams::where('id', $id)->update($input);
		return redirect()->route('team.info.edit')->with('msg', '保存しました');
	}

	public function account()
	{
		$user = User::find(\Session::get('userid'));
		$team = Teams::find(\Session::get('team_id'));	// join不要
		return view('team.info.account')->with(compact('user', 'team'));
	}

	public function email_update(Request $req)
	{
		$user = User::find($req->session()->get('userid'));

		$data = $req->except('_token');

		$rules = array(
			// 'email' => 'unique:users,email_address,'.$user->id
			// 'email' => 'unique:users,email_address,'.$user->id.',user_id'
			'email_new' => 'required|email|unique:users,email,' . $user->id,
		);

		$messages = array(
			'email_new.required' => '新メールアドレスを入力してください',
			'email_new.email' => 'メールアドレスの形式が正しくないようです',
			'email_new.unique' => '新メールアドレスはすでに登録済みのメールアドレスです。他のメールアドレスをご利用ください。',
		);

		//バリデーション処理
		$val = \Validator::make($data, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$data['token'] = str_random(40);

		// dd($data);

		\Mail::send(['text' => 'emails.check'], $data, function ($m) use ($data) {
			$m->to($data['email_new'])->subject('メールアドレス変更のご確認');
		});

		// return view('dummy')->with(compact('data'));
		User::where('id', \Session::get('userid'))->update($data);

		return redirect()->route('logout');

		// return redirect()->route('team.account.edit')->with('msg','新メールアドレスに確認メールをお送りしています。メールを確認して、問題なければ承認してください');
	}

	public function password_update(Request $req)
	{
		$input = $req->all();
		$data = array();
		$msg = '';

		$rules = array(
			'password' => 'sometimes|required|min:6|max:15',
			'password_new' => 'required_with:password|required|min:6|max:15',
			'password_new2' => 'required_with:password_new|required_with:password|required|min:6|max:15|same:password_new',
		);

		$messages = array(
			'password.required' => 'パスワードを入力してください',
			'password.min' => 'パスワードを６文字〜１５文字で指定してください',
			'password.max' => 'パスワードを６文字〜１５文字で指定してください',
			'password_new.required' => '新パスワードを入力してください',
			'password_new.required_with' => 'パスワード変更の際は、新パスワードが必須です',
			'password_new.min' => 'パスワードを６文字〜１５文字で指定してください',
			'password_new.max' => 'パスワードを６文字〜１５文字で指定してください',
			'password_new2.required' => '新パスワード確認用を入力してください',
			'password_new2.required_with' => 'パスワード変更の際は、新パスワード確認用が必須です',
			'password_new2.same' => '新パスワードと新パスワード確認用が異なります',
			'password_new2.min' => '新パスワード確認用を６文字〜１５文字で指定してください',
			'password_new2.max' => '新パスワード確認用を６文字〜１５文字で指定してください'
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$user = User::find(\Session::get('userid'));
		if (password_verify($input['password'], $user->password)) {
			// $msg = "パスワード変更に成功しました";
			$data['password'] = password_hash($req->get('password_new'), PASSWORD_DEFAULT);
			User::where('id', \Session::get('userid'))->update($data);
		} else {
			$msg = "現在のパスワードが違います";
		}

		if ($msg != '') {
			return redirect()->back()->withInput()->with('error-msg', $msg);
		} else {
			return redirect()->route('team.account.edit')->with('msg', '保存しました');
		}
	}
}
