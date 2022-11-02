<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cfg;
use App\User;
use App\Offer;
use App\Goals;
use App\Leagues;

class ConfigController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth.admin');
  }

  public function getIndex()
  {
    if (\Session::get('role') == 'admin') {
    } else {
    }

    // $kyushu = Leagues::where('year', config('app.nendo'))->where('group_id', 1)->lists('id');
    // $kansai = Leagues::where('year', config('app.nendo'))->where('group_id', 3)->lists('id');

    // $kyushu_goal_ranking = Goals::selectRaw('team_id,goal_player_id as id, count(*) cnt')->where('team_id', '<>', 21)->whereIn('league_id', $kyushu)->groupBy('goal_player_id')->orderBy('cnt', 'desc')->get();
    // $kansai_goal_ranking = Goals::selectRaw('team_id,goal_player_id as id, count(*) cnt')->where('team_id', '<>', 21)->whereIn('league_id', $kansai)->groupBy('goal_player_id')->orderBy('cnt', 'desc')->get();

    return view('admin.top');
  }

  public function memoStore(Request $req)
  {
    $input = $req->except('_token');
    Cfg::where('id', 1)->update($input);

    return redirect()->back()->with('msg', '保存しました');
  }

  public function getConfig()
  {
    $user = User::where('id', \Session::get('userid'))->firstOrFail();
    $cfg = Cfg::where('id', 1)->firstOrFail();
    return view('admin.config')->with(compact('user', 'cfg'));
  }

  public function postConfig(Request $request)
  {
    $input = $request->except('_token', 'email', 'password');
    Cfg::where('id', 1)->update($input);
    $input = $request->only('email', 'password');
    User::where('id', \Session::get('userid'))->update($input);
    return redirect()->to('admin/config')->with('msg', '保存しました');
  }
}
