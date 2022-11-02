<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Players;
use App\Teams;
use App\Options;
use Input;
use App\Cards;
use DB;

use Carbon\Carbon;

class PlayerController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth.team');
	}

	public function index(Request $req)
	{
		$sort = $req->has('sort') ? $req->get('sort') : '';

		$team = Teams::find(\Session::get('team_id'));
		$school_years = [];
		foreach (Players::where('team_id', \Session::get('team_id'))->whereIn('school_year', [1, 2, 3, 11, 12, 13])->groupBy('school_year')->orderBy('school_year', 'desc')->get(['school_year']) as $v) {
			$school_years[$v['school_year']] = $v['school_year'] . '年生';
		}
		foreach (Players::where('team_id', \Session::get('team_id'))->whereNotIn('school_year', [1, 2, 3, 11, 12, 13])->groupBy('school_year')->orderBy('school_year', 'asc')->get(['school_year']) as $v) {
			$school_years[$v['school_year']] = $v['school_year'] . '年OB';
		}

		$players = Players::with('point')->where('team_id', $req->session()->get('team_id'));
		// $sub_query = DB::raw("select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where team_id=1 group by goal_player_id")->toSql();
		// selectRaw('players.id, players.name, players.school_year, ifnull(count("point.goal_player_id"),')

		$orderby = 't.id asc';
		if ($sort == 'goals') {
			$players = $players->orderBy('goals', 'desc');
			$orderby = 'goals desc';
		} elseif ($sort == 'yellow') {
			$players = $players->orderBy('yellow', 'desc');
			$orderby = 'yellow desc';
		} elseif ($sort == 'red') {
			$players = $players->orderBy('red', 'desc');
			$orderby = 'red desc';
		} elseif ($sort == 'school_year') {
			$players = $players->orderBy('school_year', 'desc');
			$orderby = 'p.school_year desc';
		} elseif ($sort == 'team_id') {
			$orderby = 't.id asc';
		}

		$whereConds = [];
		if ($req->has('team_id') and $req->get('team_id') != '') {
			// $players = $players->where('school_year',$req->get('school_year'));
			$whereConds[] = "p.team_id = " . $req->get('team_id');
		}

		if ($req->has('school_year') and $req->get('school_year') != '') {
			// $players = $players->where('school_year',$req->get('school_year'));
			$whereConds[] = "p.school_year = " . $req->get('school_year');
		}

		if ($req->has('is_block') and $req->get('is_block') != '') {
			// $players = $players->where('is_block',$req->get('is_block'));
			$whereConds[] = "p.is_block = " . $req->get('is_block');
		}

		if ($req->has('has_cards') && $req->get('has_cards') == 1) {
			// $players = $players->has('cards','>=',1);
			$whereConds[] = "yellow is not null";
			$orderby = 'yellow desc';
		} elseif ($req->has('has_cards') && $req->get('has_cards') == 0) {
			// $players = $players->doesnthave('cards');
			$whereConds[] = "yellow is null";
		}

		if ($req->has('keyword') and $req->get('keyword') != '') {
			// $players = $players->where('is_block',$req->get('is_block'));
			$whereConds[] = "p.name like '%" . $req->get('keyword') . "%'";
		}

		// dd($whereConds);
		if (count($whereConds) > 0) {
			$whereCond = " and " . implode($whereConds, ' and ');
			// var_dump($whereCond);
		} else {
			$whereCond = '';
		}

		$players = DB::select("select p.id, p.team_id, p.name, p.school_year, p.is_block, t.id as team_id, t.name as team_name, ifnull(g.g_cnt,0) as goals, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red, suspension_at from players as p
		left join (select teams.id, teams.name from teams where deleted_at is null) as t on t.id=p.team_id
 left join (select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where deleted_at is null and created_at >= '2021-03-01' and team_id=" . $team->id . " group by goal_player_id) as g on g.goal_player_id=p.id
 left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and created_at >= '2021-03-01' and team_id=" . $team->id . " and color='yellow' and is_cleared=0 group by player_id) as y_card on y_card.player_id=p.id 
 left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and created_at >= '2021-03-01' and team_id=" . $team->id . " and color='red' and is_cleared=0 group by player_id) as r_card on r_card.player_id=p.id 
  where p.deleted_at is null and p.organizations_id=" . $team->organizations_id . $whereCond . " order by " . $orderby);


		$per_page = 25;
		// ページ番号が指定されていなかったら１ページ目
		$page_num = isset($req->page) ? $req->page : 1;
		// ページ番号に従い、表示するレコードを切り出す
		$disp_rec = array_slice($players, ($page_num - 1) * $per_page, $per_page);
		// ページャーオブジェクトを生成
		$pager = new \Illuminate\Pagination\LengthAwarePaginator(
			$disp_rec, // ページ番号で指定された表示するレコード配列
			count($players), // 検索結果の全レコード総数
			$per_page, // 1ページ当りの表示数
			$page_num, // 表示するページ
			['path' => $req->url()] // ページャーのリンク先のURLを指定
		);

		$players = $pager;
		// $players = $players->paginate(50);

		//$terms = Options::where('option_number', 0)->get();

		return view('team.player.index')->with(compact('players', 'team', 'school_years'));
	}

	public function create()
	{
		$team = Teams::find(\Session::get('team_id'));
		return view('team.player.create')->with(compact('team'));
	}

	public function confirm(Request $req)
	{
		// dd($req->all());
		$team = Teams::find(\Session::get('team_id'));

		$input = $req->except('_token', 'img');
		$player = (object)$req->except('_token', 'img');
		$player->team_id = $team->id;

		$rules = array(
			'name' => 'required',
			'birthplace' => 'required',
		);

		$messages = array(
			'name.required' => '選手名を入力してください',
			'birthplace.required' => '誕生日を入力してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		// dd($player);

		// 選手名のスペース削除
		$player->name = str_replace(array(" ", "　"), "", $player->name);

		// TODO : 選手登録のときは、team_idを入れてあげる
		$player->team_id = \Session::get('team_id');
		$player->organizations_id = \Session::get('org_id');

		$image = Input::file('img');
		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$player->img = $sInfoFile['name_file'];
		}

		$req->session()->put('post_data.player', $player);

		return view('team.player.confirm')->with(compact('player', 'team'));
	}

	public function store(Request $req)
	{
		$team = Teams::find(\Session::get('team_id'));
		$input = $req->except('_token', 'img');

		$rules = array(
			'name' => 'required',
			'birthplace' => 'required',
		);

		$messages = array(
			'name.required' => '選手名を入力してください',
			'birthplace.required' => '誕生日を入力してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		// 選手名のスペース削除
		$input['name'] = str_replace(array(" ", "　"), "", $input['name']);

		// TODO : 選手登録のときは、team_idを入れてあげる
		$input['team_id'] = \Session::get('team_id');
		$input['organizations_id'] = \Session::get('org_id');

		$image = Input::file('img');
		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$input['img'] = $sInfoFile['name_file'];
		}

		Players::create($input);
		return redirect()->route('team.player.index')->with('msg', '保存しました');
	}

	public function edit(Request $req, $id)
	{
		$player = Players::where('team_id', $req->session()->get('team_id'))->find($id);

		//オプションで設定した登録期間内かどうかの判定
		$terms = Options::where('option_number', 0)->get();
		$block_term = 0;
		foreach ($terms as $i => $term) {
			$blocks = preg_split("[~]", $term->value);

			$start = new Carbon($blocks[0]);
			$end = new Carbon($blocks[1]);

			$end->addDay();

			$today = new Carbon();

			if (Carbon::parse($today)->between($start, $end)) {
				$block_term = 1;
			}
		}

		return view('team.player.edit')->with(compact('player', 'block_term'));
	}

	public function editConfirm(Request $req)
	{
		$team = Teams::find(\Session::get('team_id'));
		$input = $req->except('_token', 'img', 'del');
		$player = (object)$req->except('_token', 'img', 'del');
		$id = $req->get('id');

		$_player = Players::find($id);

		$rules = array(
			'name' => 'required',
			'birthplace' => 'required',
		);

		$messages = array(
			'name.required' => '選手名を入力してください',
			'birthplace.required' => '誕生日を入力してください',
		);

		// 選手名のスペース削除
		$player->name = str_replace(array(" ", "　"), "", $player->name);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$image = \Input::file('img');
		$del = $req->has('img_delete') ? $req->get('img_delete') : 0;

		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$player->img = $sInfoFile['name_file'];
		} elseif ($del == 1) {
			$player->img = '';
		} else {
			$player->img = $_player->img;
		}

		$req->session()->put('post_data.player', $player);

		// dd($player);

		return view('team.player.edit_confirm')->with(compact('player', 'team'));
	}

	public function update(Request $req)
	{
		$team = Teams::find(\Session::get('team_id'));
		$input = $req->except('_token', 'img', 'del', 'id');
		// $player = (object)$req->except('_token','img','del');
		$id = $req->get('id');

		$_player = Players::find($id);

		$rules = array(
			'name' => 'required',
			'birthplace' => 'required',
		);

		$messages = array(
			'name.required' => '選手名を入力してください',
			'birthplace.required' => '誕生日を入力してください',
		);

		// 選手名のスペース削除
		$input['name'] = str_replace(array(" ", "　"), "", $input['name']);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		//バリデーションNGなら
		if ($val->fails()) {
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$image = \Input::file('img');
		$del = $req->has('img_delete') ? $req->get('img_delete') : 0;

		if ($image != '') {
			$sInfoFile = uploadFile($image);
			$input['img'] = $sInfoFile['name_file'];
		} elseif ($del == 1) {
			$input['img'] = '';
		} else {
			$input['img'] = $_player->img;
		}

		$del = \Input::has('img_delete') ? \Input::get('img_delete') : 0;
		if ($del == 1) {
			upfileDelete($_player->img);
		}

		if (isset($input['img_delete'])) unset($input['img_delete']);

		// dd($input);

		Players::where('id', $id)->where('team_id', \Session::get('team_id'))->update($input);
		return redirect()->route('team.player.index')->with('msg', '保存しました');
	}

	public function selected_delete(Request $req)
	{
		$ids = $req->get('id');
		//		dd($ids);

		// todo : goals, cardsのデータ削除？
		if (!$ids) {
			return redirect()->back()->with('msg', '選手が選択されていません');
			//			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
			//			return \Redirect::back()->with(['messages'=>'選手が選択されていません']);
		} else {
			foreach ($ids as $id) {
				Players::where('team_id', \Session::get('team_id'))->where('id', $id)->delete();
			}
			return redirect()->route('team.player.index')->with('msg', '削除しました');
		}
	}

	public function delete(Request $req)
	{
		// if(\Session::get('role')!='admin') return 'error';
		// Players::where('id',$id)->delete();
		// return redirect()->route('admin.team.index')->with('msg','削除しました');
	}

	public function import(Request $req)
	{
		// dd($req->all());

		if (Input::hasFile('csv')) {

			// $file = \Input::file('csv');
			$file = $req->file('csv');
			// dd($file);

			$fileName = $file->getClientOriginalName() . '_' . time();
			$move = $file->move(storage_path('uploads/'), $fileName);

			// utf8に
			$d = file_get_contents($move);
			//$d = mb_convert_encoding($d, 'UTF-8', 'SJIS-win');

			$temp = tmpfile();
			$meta = stream_get_meta_data($temp);
			fwrite($temp, $d);
			rewind($temp);
			$csv_for_check = new \SplFileObject($meta['uri'], 'rb');

			while (!$csv_for_check->eof()) {
				$_data = $csv_for_check->fgetcsv();
				if ($_data[0] === NULL) break;
				if ($_data[1] == '' || $_data[2] == '' || $_data[6] == '') {
					dd("データの不備があります");
				}
			}

			// $fileName = $file->getClientOriginalName(). '_'. time();
			// $move = $file->move(storage_path('uploads/'),$fileName);
			// $d = file_get_contents($move);
			//$d = mb_convert_encoding($d, 'UTF-8', 'SJIS-win');
			// $temp = tmpfile();
			// $meta = stream_get_meta_data($temp);
			// fwrite($temp, $d);
			// rewind($temp);
			$csv = new \SplFileObject($meta['uri'], 'rb');

			$row0_check = 0;
			while (!$csv->eof()) {
				$_data = $csv->fgetcsv();
				if ($row0_check == 0) {
					$row0_check++;
					continue;
				}

				// 空だったら強制終了
				if ($_data[0] === NULL) break;
				// 選手名と学年は必須
				if ($_data[1] == '' || $_data[2] == '' || $_data[6] == '') continue;

				// dd(config('app.positionAry'));
				// 選手名のスペース削除
				$__data['name'] = str_replace(array(" ", "　"), "", $_data[1]);

				$__data['school_year'] = ($_data[2] != '') ? $_data[2] : NULL;
				if ($_data[3] != '') {
					$__data['position'] = array_search($_data[3], config('app.positionAry'));
				}

				// $__data['position'] = array_search($_data[3],config('app.positionAry'),);
				$__data['related_team'] = ($_data[4] != '') ? $_data[4] : NULL;

				// 都道府県IDを入力してもらう
				$__data['birthplace'] = ($_data[5] != '') ? $_data[5] : NULL;
				$__data['birthday'] = ($_data[6] != '') ? $_data[6] : NULL;
				if ($_data[7] != '') {
					$__data['pivot'] = array_search($_data[7], config('app.pivotAlphabetAry'));
				}
				// $__data['pivot'] = ($_data[7])?array_get(config('app.pivotAlphabetAry'),$_data[7]):NULL;
				$__data['height'] = ($_data[8] != '') ? $_data[8] : NULL;
				$__data['weight'] = ($_data[9] != '') ? $_data[9] : NULL;
				$__data['goal'] = ($_data[10] != '') ? $_data[10] : NULL;
				if ($_data[11] != '') {
					if ($_data[11] == '1') {
						$__data['is_block'] = 1;
					} else {
						$__data['is_block'] = 0;
					}
				} else {
					$__data['is_block'] = 0;
				}
				$__data['created_at'] = date('Y-m-d H:i:s');
				$__data['updated_at'] = date('Y-m-d H:i:s');
				$__data['team_id'] = \Session::get('team_id');
				$__data['organizations_id'] = \Session::get('org_id');

				$data[] = $__data;
				//if(count($data)>5) break;
			}

			// dd($data);

			// Players::where('team_id',\Session::get('team_id'))->delete();
			Players::insert($data);

			return redirect()->route('team.player.index')->with('msg', '保存しました');
		}
		// $input = (array)$req->session()->get('post_data.player');
		// $req->session()->forget('post_data.player');
		// Players::create($input);
		// return redirect()->route('team.player.index')->with('msg','保存しました');
	}
}
