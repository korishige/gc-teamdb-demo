<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Teams;
use App\User;
use App\Organizations;
use App\TeamYearlyGroup;
use Input;
use DB;

class TeamController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth.admin');
  }

  public function index()
  {
    $teams = Teams::select(['teams.*', 'team_yearly_group.group_id'])->with('user', 'group', 'players')->leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo_backend'))
      ->where(function ($q) {
        $q->whereNull('period')->orWhere('period', config('app.period'));
      })->orderBy('group_id', 'asc');

    if (\Input::has('keyword'))
      $teams = $teams->where('name', 'like', '%' . \Input::get('keyword') . '%');
    // $teams = $teams->whereHas('user',function($q){
    //   $q->where('name','like','%'.Input::get('keyword').'%');
    // });

    $teams = $teams->paginate(50);
    return view('admin.team.index')->with(compact('teams'));
  }

  //  public function create(){
  //    $obj = Teams::get();
  //    return view('admin.team.create')->with(compact('obj'));
  //  }
  //
  //  public function store(Request $req){
  //    $input = $req->except('_token');
  //
  //    $image = Input::file('emblem_img');
  //    if($image!=''){
  //      $sInfoFile = uploadFile($image);
  //      $input['emblem_img'] = $sInfoFile['name_file'];
  //    }
  //
  //    $image = Input::file('group_img');
  //    if($image!=''){
  //      $sInfoFile = uploadFile($image);
  //      $input['group_img'] = $sInfoFile['name_file'];
  //    }
  //
  //    Teams::create($input);
  //    return redirect()->route('admin.team.index')->with('msg','保存しました');
  //  }

  public function create()
  {
    $obj = Teams::get();
    return view('admin.team.create')->with(compact('obj'));
  }

  public function store(Request $req)
  {
    $input = $req->except('_token');

    $rules = array(
      'email' => 'required|unique:users,email',
      'password' => 'required|min:6|max:15|confirmed'
    );

    $messages = array(
      'email.required' => 'メールアドレスを入力してください',
      'email.email' => 'メールアドレスを確認してください',
      'email.unique' => 'ご登録頂いたメールアドレスはすでに利用されています',
      'password.required' => 'パスワードを入力してください',
      'password.confirmed' => 'パスワードが一致していません',
      'password.min' => 'パスワードを６文字〜１５文字で指定してください',
      'password.max' => 'パスワードを６文字〜１５文字で指定してください'
    );

    //バリデーション処理
    $val = \Validator::make($input, $rules, $messages);
    //バリデーションNGなら
    if ($val->fails()) {
      return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
    }

    $user_input['email'] = $req->get('email');
    $user_input['role'] = 'team';
    $user_input['password'] = password_hash($req->get('password'), PASSWORD_DEFAULT);
    $user_input['token'] = str_random(40);
    $user_input['is_active'] = 1;

    $this->registUser($user_input);

    $organization_input['name'] = $req->name;

    $this->registOrganization($organization_input);

    $user = User::where('email', $req->email)->first();
    $organization = Organizations::where('name', $req->name)->first();

    $team_input['name'] = $req->name;
    $team_input['organizations_id'] = $organization->id;
    $team_input['user_id'] = $user->id;
    $team_input['group_id0'] = $req->group_id;

    $this->registTeam($team_input);

    $team = Teams::where('name', $req->name)->first();

    $yearly_input['team_id'] = $team->id;
    $yearly_input['yyyy'] = config('app.nendo');
    $yearly_input['group_id'] = $req->group_id;
    $yearly_input['period'] = config('app.period');

    TeamYearlyGroup::create($yearly_input);

    return redirect()->route('admin.team.index')->with('msg', '保存しました');
  }

  public function registUser($user_input)
  {
    User::create($user_input);
  }

  public function registOrganization($organization_input)
  {
    Organizations::create($organization_input);
  }

  public function registTeam($team_input)
  {
    Teams::create($team_input);
  }

  public function edit($id)
  {
    $team = Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy', config('app.nendo_backend'))->find($id);;
    return view('admin.team.edit')->with(compact('team'));
  }

  public function update(Request $req)
  {
    $input = $req->except('_token', 'id', 'emblem_img', 'emblem_img_delete', 'group_img', 'group_img_delete', 'files', 'group_id');
    $id = $req->get('id');

    $obj = Teams::find($id);  // join不要
    $image = Input::file('emblem_img');
    $del = Input::get('emblem_img_delete');
    if ($del == 1) {
      $input['emblem_img'] = '';
      upfileDelete($obj->emblem_img);
    }
    if ($image != '') {
      $sInfoFile = uploadFile($image);
      $input['emblem_img'] = $sInfoFile['name_file'];
    }

    $image = Input::file('group_img');
    $del = Input::get('group_img_delete');
    if ($del == 1) {
      $input['group_img'] = '';
      upfileDelete($obj->group_img);
    }
    if ($image != '') {
      $sInfoFile = uploadFile($image);
      $input['group_img'] = $sInfoFile['name_file'];
    }

    // team_yearly_groupを変更する
    // TODO: ここは所属グループが変更があるときだけ有効にする。
    DB::table('team_yearly_group')->where('team_id', $id)->where('yyyy', config('app.nendo_backend'))->update(['yyyy' => config('app.nendo'), 'group_id' => $req->get('group_id')]);

    Teams::where('id', $id)->update($input);  // 上の処理で、team_yearly_groupにupdateしている
    return redirect()->route('admin.team.index')->with('msg', '保存しました');
  }

  public function delete($id)
  {
    if (\Session::get('role') != 'admin') return 'error';
    Teams::where('id', $id)->delete();
    DB::table('team_yearly_group')->where('team_id', $id)->where('yyyy', config('app.nendo_backend'))->delete();
    return redirect()->route('admin.team.index')->with('msg', '削除しました');
  }
}
