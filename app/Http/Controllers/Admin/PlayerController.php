<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Players;
use App\Teams;
use App\Cards;
use App\Groups;
use Input;
use DB;

class PlayerController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(Request $req){
    if($req->has('id')){
      $team_id = $req->get('id');
      // $players = $players->where('team_id',$team_id);
      // $team = Teams::find($team_id);
    }else{
      $team_id = '';
    }

    $sort = $req->has('sort')?$req->get('sort'):'';

    $team = Teams::find($team_id);	// join不要
    $players = Players::with('point')->where('team_id',$team->id);
    // $sub_query = DB::raw("select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where team_id=1 group by goal_player_id")->toSql();
    // selectRaw('players.id, players.name, players.school_year, ifnull(count("point.goal_player_id"),')

    $orderby = '';
    if($sort=='goals'){
      $players = $players->orderBy('goals','desc');
      $orderby = 'goals desc';
    }elseif($sort=='yellow'){
      $players = $players->orderBy('yellow','desc');
      $orderby = 'yellow desc';
    }elseif($sort=='red'){
      $players = $players->orderBy('red','desc');
      $orderby = 'red desc';
    }elseif($sort=='school_year'){
      $players = $players->orderBy('school_year','desc');
      $orderby = 'p.school_year desc';
    }else{
      $orderby = 'p.updated_at desc';
    }

    $whereConds = [];
    if($req->has('school_year') and $req->get('school_year')!=''){
      // $players = $players->where('school_year',$req->get('school_year'));
      $whereConds[] = "p.school_year = ".$req->get('school_year');
    }

    if($req->has('is_block') and $req->get('is_block')!=''){
      // $players = $players->where('is_block',$req->get('is_block'));
      $whereConds[] = "p.is_block = ".$req->get('is_block');     
    }

    if($req->has('has_cards') && $req->get('has_cards')==1){
      // $players = $players->has('cards','>=',1);
      $whereConds[] = "yellow is not null";
      $orderby = 'yellow desc';
    }elseif($req->has('has_cards') && $req->get('has_cards')==0){
      // $players = $players->doesnthave('cards');
      $whereConds[] = "yellow is null";
    }

    if($req->has('keyword') and $req->get('keyword')!=''){
      // $players = $players->where('is_block',$req->get('is_block'));
      $whereConds[] = "p.name like '%".$req->get('keyword')."%'";     
    }

    // dd($whereConds);
    if(count($whereConds)>0){
      $whereCond = " and ".implode($whereConds,' and ');
      // var_dump($whereCond);
    }else{
      $whereCond = '';
    }

    $players = DB::select("select p.id, p.name, p.school_year, p.is_block,ifnull(g.g_cnt,0) as goals, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red from players as p
 left join (select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where deleted_at is null and team_id=".$team->id." group by goal_player_id) as g on g.goal_player_id=p.id
 left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and team_id=".$team->id." and color='yellow' and is_cleared=0 group by player_id) as y_card on y_card.player_id=p.id 
 left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and team_id=".$team->id." and color='red' and is_cleared=0 group by player_id) as r_card on r_card.player_id=p.id 
  where p.deleted_at is null and p.team_id=".$team->id.$whereCond." order by ".$orderby);

    // $per_page = 25;
    // // ページ番号が指定されていなかったら１ページ目
    // $page_num = isset($req->page) ? $req->page : 1;
    // // ページ番号に従い、表示するレコードを切り出す
    // $disp_rec = array_slice($players, ($page_num-1) * $per_page, $per_page);
    // // ページャーオブジェクトを生成
    // $pager= new \Illuminate\Pagination\LengthAwarePaginator(
    //     $disp_rec, // ページ番号で指定された表示するレコード配列
    //     count($players), // 検索結果の全レコード総数
    //     $per_page, // 1ページ当りの表示数
    //     $page_num, // 表示するページ
    //     ['path' => $req->url()] // ページャーのリンク先のURLを指定
    // );

    // $players = $pager;

    return view('admin.player.index')->with(compact('players','team'));





    // $players = Players::orderBy('updated_at','desc');

    // if(\Input::has('keyword'))
    //   $players = $players->where('name','like','%'.\Input::get('keyword').'%');

    // if(\Input::has('id')){
    //   $team_id = \Input::get('id');
    //   $players = $players->where('team_id',$team_id);
    //   $team = Teams::find($team_id);
    // }else{
    //   $team_id = '';
    // }


    // $players = $players->get();
    // return view('admin.player.index')->with(compact('players','team'));
  }

  // public function create(){
  //   $obj = Teams::get();
  //   return view('admin.news.create')->with(compact('obj'));
  // }

  // public function store(Request $req){
  //   $input = $req->except('_token');
  //   Teams::create($input);
  //   return redirect()->route('admin.news.index')->with('msg','保存しました');
  // }

  public function edit($id){
    $player = Players::find($id);
    return view('admin.player.edit')->with(compact('player'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id','img','img_delete');
    $id = $req->get('id');

    $rules=array(
      'name'=>'required',
      'birthplace'=>'required',
    );

    $messages = array(
      'name.required'=>'選手名を入力してください',
      'birthplace.required'=>'誕生日を入力してください',
    );

    // 出場停止期間 suspension_atが空の場合
    $input['suspension_at'] = ($input['suspension_at']=='')?NULL:$input['suspension_at'];

    // 選手名のスペース削除
    $input['name'] = str_replace(array(" ", "　"), "", $input['name']);
    
    //バリデーション処理
    $val=\Validator::make($input,$rules,$messages);
    //バリデーションNGなら
    if($val->fails()){
      return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
    }

    $image = Input::file('img');
    $del = Input::get('img_delete');
    if($del==1){
      $input['img'] = '';
      upfileDelete($obj->img);
    }
    if($image!=''){
      $sInfoFile = uploadFile($image);
      $input['img'] = $sInfoFile['name_file'];
    }

    Players::where('id',$id)->update($input);
    $player = Players::find($id);
    return redirect()->route('admin.team.player.index',['id'=>$player->team_id])->with('msg','保存しました');
  }

//  public function delete($id){
//    if(\Session::get('role')!='admin') return 'error';
//    Teams::where('id',$id)->delete();
//    return redirect()->route('admin.team.index')->with('msg','削除しました');
//  }

  public function getBlock(Request $req)
  {
    //$players = Players::where('is_block', 1)->orderBy('team_id')->get();
    $sort = $req->has('sort') ? $req->get('sort') : '';

    $orderby = '';
    if ($sort == 'school_year') {
      $orderby = 'p.school_year desc';
    } elseif ($sort == 'group') {
      $orderby = 'group_name desc';
    } elseif ($sort == 'team' || $sort == '') {
      $orderby = 'team_name desc';
    }

    $whereConds = [];
    if ($req->has('group_id') and $req->get('group_id') != '') {
      $whereConds[] = "g.id = " . $req->get('group_id');
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

    $players = DB::select("select g.name as group_name, ifnull(t.name, '') as team_name, ifnull(p.name, '') as player_name, ifnull(p.school_year, '') as school_year from teams as t
    left join (select team_yearly_group.group_id, team_yearly_group.team_id from team_yearly_group where yyyy = " . config('app.nendo_backend') . ") as tyg on tyg.team_id = t.id
    left join (select groups.id, groups.name from groups) as g on g.id = tyg.group_id
    left join (select players.id, players.team_id, players.name, players.school_year, players.is_block from players where deleted_at is null) as p on p.team_id = t.id
		where deleted_at is null and p.is_block = 1" . $whereCond . " order by " . $orderby);

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

    return view('admin.block.index')->with(compact('players'));
  }

  public function getWarning(Request $req)
  {
    $sort = $req->has('sort') ? $req->get('sort') : '';

    $orderby = 'g.id desc';
    if ($sort == 'goals') {
      $orderby = 'goals desc';
    } elseif ($sort == 'yellow') {
      $orderby = 'yellow desc';
    } elseif ($sort == 'red') {
      $orderby = 'red desc';
    } elseif ($sort == 'school_year') {
      $orderby = 'p.school_year desc';
    } elseif ($sort == 'group') {
      $orderby = 'group_name desc';
    } elseif ($sort == 'team' || $sort == '') {
      $orderby = 'team_name desc';
    } elseif ($sort == 'suspension_at' || $sort == '') {
      $orderby = 'p.suspension_at desc';
    }

    $whereConds = [];
    if ($req->has('group_id') and $req->get('group_id') != '') {
      $whereConds[] = "g.id = " . $req->get('group_id');
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

    $players = DB::select("select p.id as id, g.name as group_name, ifnull(t.name, '') as team_name, ifnull(p.name, '') as player_name, ifnull(p.school_year, '') as school_year, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red, ifnull(p.suspension_at, '') as suspension_at from teams as t
    left join (select team_yearly_group.group_id, team_yearly_group.team_id from team_yearly_group where yyyy = " . config('app.nendo_backend') . ") as tyg on tyg.team_id = t.id
    left join (select groups.id, groups.name from groups) as g on g.id = tyg.group_id
    left join (select players.id, players.team_id, players.name, players.school_year, players.is_block, players.suspension_at from players where deleted_at is null) as p on p.team_id = t.id
    left join (select cards.player_id, count(player_id) as y_cnt from cards where deleted_at is null and color='yellow' and is_cleared=0 group by player_id) as y_card on y_card.player_id=p.id 
    left join (select cards.player_id, count(player_id) as r_cnt from cards where deleted_at is null and color='red' and is_cleared=0 group by player_id) as r_card on r_card.player_id=p.id 
    where (y_card.y_cnt != 0 or r_card.r_cnt != 0) " . $whereCond . " order by " . $orderby);

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

    return view('admin.warning.index')->with(compact('players'));
  }

	public function getYearWarning($nendo)
	{
		if (\Input::has('nendo'))
			$nendo = \Input::get('nendo');

		$teams = Teams::select(['teams.*', 'team_yearly_group.group_id'])->with('user', 'group', 'players')->leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', $nendo)->orderBy('group_id', 'asc');

		if (\Input::has('keyword'))
			$teams = $teams->where('name', 'like', '%' . \Input::get('keyword') . '%');
		// $teams = $teams->whereHas('user',function($q){
		//   $q->where('name','like','%'.Input::get('keyword').'%');
		// });

		$teams = $teams->paginate(50);

		return view('admin.warning.year')->with(compact('teams', 'nendo'));
	}

	public function getYearPlayerWarning(Request $req, $id, $nendo)
	{
		$sort = $req->has('sort') ? $req->get('sort') : '';

		$team = Teams::find($id);  // join不要
		$players = Players::with('point')->where('team_id', $team->id);
		// $sub_query = DB::raw("select goals.goal_player_id, count(goal_player_id) as g_cnt from goals where team_id=1 group by goal_player_id")->toSql();
		// selectRaw('players.id, players.name, players.school_year, ifnull(count("point.goal_player_id"),')

		$orderby = '';
		if ($sort == 'all') {
			$players = $players->orderBy('yellow', 'desc')->orderBy('red', 'desc');
			$orderby = 'yellow desc, red desc';
		} elseif ($sort == 'yellow') {
			$players = $players->orderBy('yellow', 'desc');
			$orderby = 'yellow desc';
		} elseif ($sort == 'red') {
			$players = $players->orderBy('red', 'desc');
			$orderby = 'red desc';
		} elseif ($sort == 'school_year') {
			$players = $players->orderBy('school_year', 'desc');
			$orderby = 'p.school_year desc';
		} else {
			$orderby = 'p.updated_at desc';
		}

		$whereConds = [];
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

		$players = DB::select("select p.id, p.name, p.school_year, p.is_block, ifnull(y_card.y_cnt,0) as yellow, ifnull(r_card.r_cnt,0) as red from players as p
 left join (select cards.player_id, count(player_id) as y_cnt from cards where team_id=" . $team->id . " and color='yellow' and nendo=" . $nendo . " group by player_id) as y_card on y_card.player_id=p.id 
 left join (select cards.player_id, count(player_id) as r_cnt from cards where team_id=" . $team->id . " and color='red' and nendo=" . $nendo . " group by player_id) as r_card on r_card.player_id=p.id 
  where p.deleted_at is null and p.team_id=" . $team->id . $whereCond . " order by " . $orderby);

		// $per_page = 25;
		// // ページ番号が指定されていなかったら１ページ目
		// $page_num = isset($req->page) ? $req->page : 1;
		// // ページ番号に従い、表示するレコードを切り出す
		// $disp_rec = array_slice($players, ($page_num-1) * $per_page, $per_page);
		// // ページャーオブジェクトを生成
		// $pager= new \Illuminate\Pagination\LengthAwarePaginator(
		//     $disp_rec, // ページ番号で指定された表示するレコード配列
		//     count($players), // 検索結果の全レコード総数
		//     $per_page, // 1ページ当りの表示数
		//     $page_num, // 表示するページ
		//     ['path' => $req->url()] // ページャーのリンク先のURLを指定
		// );

		// $players = $pager;

		//チームの累計
		$reds = \App\Cards::where('team_id', $team->id)->where('color', 'red')->where('nendo', $nendo)->get();
		$yellows = \App\Cards::where('team_id', $team->id)->where('color', 'yellow')->where('nendo', $nendo)->get();

		//カードの中にサブチームに移籍した選手がいるかどうか
		$ys = array();
		foreach ($yellows as $yellow) {
			$player_id = $yellow->player_id;
			if (array_key_exists($player_id, $ys)) {
				$ys[$player_id]++;
			} else {
				$ys[$player_id] = 1;
			}
		}

		$another_players = array();
		foreach ($ys as $key => $y) {
			$another_player = \App\Players::find($key);
			if ($another_player->team_id != $id) {
				$another_player->yellow = $y;
				$another_players[] = $another_player;
			}
		}

		$rs = array();
		foreach ($reds as $red) {
			$player_id = $red->player_id;
			if (array_key_exists($player_id, $rs)) {
				$rs[$player_id]++;
			} else {
				$rs[$player_id] = 1;
			}
		}

		foreach ($rs as $key => $r) {
			$another_player = \App\Players::find($key);
			if ($another_player->team_id != $id) {
				$another_player->red = $r;
				$another_players[] = $another_player;
			}
		}

		return view('admin.warning.player')->with(compact('players', 'team', 'nendo', 'reds', 'yellows', 'another_players'));
	}

  public function editWarning($id)
  {
    $player = Players::where('id', $id)->first();

    return view('admin.warning.edit')->with(compact('player'));
  }

  public function updateWarning(Request $request)
  {
    $player = Players::where('id', $request->id)->first();

    $suspension_at = date('Y-m-d H:i', strtotime($request->suspension_at));

    $player->suspension_at = $suspension_at;

    $player->save();

    return redirect()->route('admin.warning.edit', ['id' => $player->id])->with('msg', '保存しました');
  }
}
