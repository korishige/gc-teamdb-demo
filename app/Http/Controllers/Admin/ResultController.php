<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Players;
use App\Goals;
use App\Cards;

use Input;
use Cache;

class ResultController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth.admin');
  }

  public function index()
  {
    $matches = Matches::orderBy('match_at', 'desc')->orderBy('is_filled', 'desc')->orderby('is_publish', 'asc')->orderBy('id', 'asc');

    if (Input::has('group_id') && Input::get('group_id') != '')
      $matches = $matches->whereHas('leagueOne', function ($q) {
        return $q->where('group_id', Input::get('group_id'));
      });

    if (Input::has('year') && Input::get('year') != '')
      $matches = $matches->whereHas('leagueOne', function ($q) {
        return $q->where('year', Input::get('year'));
      });

    if (Input::has('season') && Input::get('season') != '')
      $matches = $matches->whereHas('leagueOne', function ($q) {
        return $q->where('season', Input::get('season'));
      });

    if (Input::has('keyword') && Input::get('keyword') != '')
      $matches = $matches->whereHas('leagueOne', function ($q) {
        return $q->where('name', 'like', '%' . Input::get('keyword') . '%');
      });

    $matches = $matches->paginate(50);

    //    dd($matches);
    if (count($matches) == 0) die("まだ試合が登録されていません");

    return view('admin.result.index', ['matches' => $matches]);
  }

  // public function create($league_id){
  //   $league = Leagues::where('id',$league_id)->first();
  //   $teams = LeagueTeams::where('leagues_id',$league_id)->orderBy('id','asc')->lists('name','id');
  //   $matchObj = Matches::where('leagues_id',$league_id)->orderBy('id','asc')->get();
  //   return view('admin.match.create',compact('league','teams','matchObj','league_id'));
  // }

  // public function store(){
  //   // dd(\Input::all());
  //   $input = Input::except('_token');

  //   $rules = array(
  //     'section'=>'required',
  //     'match_date'=>'required',
  //     'match_time'=>'required',
  //   );

  //   $messages = array(
  //     'section.required'=>'節を入力してください',
  //     'match_date.required'=>'試合日を入力してください',
  //     'match_time.required'=>'試合開始時刻を入力してください',
  //   );

  //   $matchCnt = Matches::where('leagues_id',$input['leagues_id'])->where('home_id',$input['home_id'])->where('away_id',$input['away_id'])->count();

  //   if($matchCnt>1){
  //     return redirect()->back()
  //       ->withInput()
  //       ->with('error-msg','すでに登録された対戦です');
  //   }

  //   if($input['home_id']==$input['away_id']){
  //     return redirect()->back()
  //       ->withInput()
  //       ->with('error-msg','同じチームが設定されています');
  //   }

  //   //バリデーション処理
  //   $val=\Validator::make($input,$rules,$messages);
  //   if($val->fails()){
  //     return redirect()->back()
  //       ->withErrors($val->errors())
  //       ->withInput()
  //       ->with('messages');
  //   }

  //   // if($input['home_pk']=='') unset($input['home_pk']);
  //   // if($input['away_pk']=='') unset($input['away_pk']);

  //   // $input['ip'] = $_SERVER['REMOTE_ADDR'];
  //   $match = Matches::create($input);

  //   return redirect()->route('admin.match.index',['leagues_id'=>$input['leagues_id']])->with('msg','保存しました');
  // }

  public function edit($id)
  {
    // $id : match_id

    // $match = Matches::find($id);
    // $league = Leagues::find($match->leagues_id);
    // $teamObj = LeagueTeams::where('leagues_id',$match->leagues_id)->orderBy('id','asc')->lists('name','id');
    // return view('admin.result.edit')->with(compact('match','league','teamObj'));

    $match = Matches::find($id);
    $teams = LeagueTeams::where('leagues_id', $match->leagues_id)->orderBy('id', 'asc')->lists('name', 'team_id');

    $players1 = Players::with('team')->where('team_id', $match->home_id)->get();
    $players2 = Players::with('team')->where('team_id', $match->away_id)->get();

    // 選手が登録されていないと例外が発生する
    $all_players_home['name'] = array();
    $all_players_away['name'] = array();
    $players_home['name'] = array();
    $players_away['name'] = array();

    foreach ($players1 as $player) {
      //      $all_players_home['name'][$player->id] = $player->team->name.' | '.$player->name;
      $players_home['name'][$player->id] = $player->name;
    }

    foreach ($players2 as $player) {
      //      $all_players_home['name'][$player->id] = $player->team->name.' | '.$player->name;
      $players_away['name'][$player->id] = $player->name;
    }

    //    foreach($players2 as $player){
    //      $all_players_away['name'][$player->id] = $player->team->name.' | '.$player->name;
    //    }
    //
    //    foreach($players1 as $player){
    //      $all_players_away['name'][$player->id] = $player->team->name.' | '.$player->name;
    //    }

    return view('admin.result.edit')->with(compact('match', 'teams', 'players_home', 'players_away'));
  }

  public function update(Request $req)
  {
    // dd(\Input::all());
    $input_match = $req->only('is_filled', 'is_publish', 'home_pt', 'away_pt', 'home_pk', 'away_pk', 'note', 'home_comment', 'away_comment');
    $input_goals = $req->only(['home_goals', 'away_goals']);
    $input_cards = $req->only(['home_cards', 'away_cards']);
    $id = Input::get('id');

    // dd($input_match, $input_goals, $input_cards);

    // todo : 本当はここで、home_ptとhome_goals数、away_ptとaway_goals数のチェックをしたい

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
      redirect()->back()->withErrors($val->errors())->withInput()->with('messages');
    }

    // todo: ゴールの必須条件設定難しい
    // $rules = array();
    // $messages = array();
    // for($i=0;$i<20;$i++){
    //   $rules["home_goals.$i.player"] = "required|required_with:home_goals.$i.addtime,home_goals.$i.time";
    //   $rules["away_goals.$i.player"] = "required|required_with:away_goals.$i.addtime,away_goals.$i.time";
    // }

    // // dd($rules);

    // // $val=\Validator::make($input_goals,$rules,$messages);

    // if($val->fails()){
    //   redirect()->back()->withErrors($val->errors())->withInput()->with('messages');
    // }

    // dd($input_match, $input_goals, $input_cards);

    $data = array();
    $match = Matches::find($id);

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
          if ($goal['time'] != '') {
            $data['h_or_a'] = $type;
            $data['time'] = ($goal['time'] != '') ? $goal['time'] : NULL;
            // $data['addtime'] = ($goal['addtime']!='')?$goal['addtime']:NULL;
            $data['goal_player_id'] = $goal['player'];
            // $data['ass_player_id'] = $goal['assist'];

            Goals::create($data);
          }
        }
      }
    }

    $data = array();
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
          if ($card['time'] != '') {
            $data['h_or_a'] = $type;
            $data['time'] = ($card['time'] != '') ? $card['time'] : NULL;
            // $data['addtime'] = ($card['addtime']!='')?$card['addtime']:NULL;
            $data['player_id'] = $card['player'];
            $data['color'] = $card['type'];

            Cards::create($data);
          }
        }
      }
    }
    //dd($input_match);
    Matches::where('id', $id)->update($input_match);

    return redirect()->route('admin.result.index')->with('msg', '保存しました');
  }

  // public function delete($league_id, $id){
  //   Matches::where('id',$id)->delete();
  //   Comments::where('match_id',$id)->delete();
  //   return redirect()->route('admin.match.index')->with('msg','削除しました');
  // }

}
