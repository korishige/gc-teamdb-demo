<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Players;
use App\Teams;
use Input;
use App\Cards;
use DB;
// use App\Organizations;

class FormationController extends Controller
{
  public function __construct(){
    $this->middleware('auth.team');
  }

  public function index(Request $req){
    $team = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy',config('app.nendo'))->findOrFail(\Session::get('team_id'));
    $orgs = Teams::where('organizations_id',$team->organizations_id)->get();	// join不要
    $players = Players::where('organizations_id',$team->organizations_id)->where('school_year','<',2000)->orderBy('team_id','asc')->orderBy('is_block','desc')->orderBy('school_year','desc')->get();
    return view('team.formation.index')->with(compact('players','team', 'orgs'));
  }

  // public function editConfirm(Request $req){
  //   $team = Teams::find(\Session::get('team_id'));
  //   $input = $req->except('_token','img','del');
  //   $player = (object)$req->except('_token','img','del');
  //   $id = $req->get('id');

  //   $_player = Players::find($id);

  //   $rules=array(
  //     'name'=>'required',
  //     'birthplace'=>'required',
  //   );

  //   $messages = array(
  //     'name.required'=>'選手名を入力してください',
  //     'birthplace.required'=>'誕生日を入力してください',
  //   );

  //   // 選手名のスペース削除
  //   $player->name = str_replace(array(" ", "　"), "", $player->name);
    
  //   //バリデーション処理
  //   $val=\Validator::make($input,$rules,$messages);
  //   //バリデーションNGなら
  //   if($val->fails()){
  //     return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
  //   }

  //   $image = \Input::file('img');
  //   $del = $req->has('img_delete')?$req->get('img_delete'):0;

  //   if($image!=''){
  //     $sInfoFile = uploadFile($image);
  //     $player->img = $sInfoFile['name_file'];
  //   }elseif($del==1){
  //     $player->img = '';
  //   }else{
  //     $player->img = $_player->img;
  //   }

  //   $req->session()->put('post_data.player',$player);

  //   // dd($player);

  //   return view('team.player.edit_confirm')->with(compact('player','team'));
  // }

  public function update(Request $req){
    $input = $req->except('_token');
    // dd($input);

    foreach($input as $row){
      foreach($row as $player_id => $team_id){
        Players::where('id',$player_id)->update(['team_id'=>$team_id]);
      }
    }

    // return "hoge";
    return redirect()->route('team.formation.index')->with('msg','保存しました');
  }

  public function delete(Request $req){
    // if(\Session::get('role')!='admin') return 'error';
    // Players::where('id',$id)->delete();
    // return redirect()->route('admin.team.index')->with('msg','削除しました');
  }

}
