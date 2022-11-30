<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Teams;

use Input;
use Cookie;
use Config;
use Session;

class AuthController extends Controller
{
  public function authorized(Request $request)
  {

    $input = $request->all();
    // dd($input);
    $user = User::where('email', $input['email'])->where('token', $input['token'])->where('is_active', 0)->first();
    if (isset($user)) {
      $update = ['is_active' => 1, 'token' => NULL];
      User::where('email', $input['email'])->where('token', $input['token'])->where('is_active', 0)->update($update);
      return view('auth/activated');
    } else {
      // $msg['title']='アカウント登録エラー';
      // $msg['desc']='アカウント登録エラーが発生しました。';
      return view('auth/activateError')->with(compact('msg'));
    }
  }

  public function email_update(Request $request)
  {
    $input = $request->all();
    // dd($input);
    $user = User::where('token', $input['token'])->where('is_active', 1)->first();
    if (isset($user)) {
      $update = ['email' => $user->email_new, 'token' => NULL, 'email_new' => NULL];
      User::where('id', $user->id)->update($update);
      return view('auth/emailUpdated');
    } else {
      // $msg['title']='アカウント登録エラー';
      // $msg['desc']='アカウント登録エラーが発生しました。';
      return view('auth/emailUpdateError')->with(compact('msg'));
    }
  }

  public function getLogin()
  {
    $cookie = json_decode(Cookie::get(Config::get('app.aspname')), true);
    return view('auth/login', compact("cookie"));
  }

  public function postLogin(Request $request)
  {
    //フロントにてflagに値を入れて通常のログインかログイン後のサブチームへの切り替えかを判定
    //flag == 1のときはサブチームにアカウント切り替え
    if ($request->flag == 1) {
      $res = User::where('id', $request->user_id)->first();
      // dd($res);
      if ($res->is_active == 0) {
        return \Redirect::to('/cp/team');
      } else {
        if ($res->role == 'admin') {
          Session::put('userid', $res->id);
          Session::put('role', $res->role);
          Session::put('authType', $res->authType);
          Session::put('avatar', $res->avatar);
          Session::put('email', $res->email);
          return \Redirect::to('/admin');
        } elseif ($res->email == 'admin_team') {
          $team = \App\Teams::first();
          Session::put('userid', $res->id);
          Session::put('role', $res->role);
          Session::put('authType', $res->authType);
          Session::put('avatar', $res->avatar);
          Session::put('email', $res->email);
          Session::put('org_id', $team->organizations_id);
          Session::put('team_id', $team->id);
          Session::put('admin', true);
          return \Redirect::to('/cp/team');
        } else {
          $team = Teams::where('user_id', $res->id)->first();  // join不要
          Session::put('userid', $res->id);
          Session::put('role', $res->role);
          Session::put('authType', $res->authType);
          Session::put('avatar', $res->avatar);
          Session::put('email', $res->email);
          $team = \App\Teams::where('user_id', $res->id)->first();
          Session::put('org_id', $team->organizations_id);
          Session::put('team_id', $team->id);
          return \Redirect::to('/cp/team');
        }
      }
    } else {

      //$cookie = array('email'=>$request->get('email'),'password'=>$request->get('password'),'remember'=>$request->get('remember'));
      $cookie = $request->all();
      $cookie = json_encode($cookie);

      if ($request->get('remember')) {
        Cookie::queue(Config::get('app.aspname'), $cookie, 60 * 60 * 24 * 7);
      }

      // $res = User::where('is_active',1)->where('email',$request->get('email'))->where('password',$request->get('password'))->first();
      $res = User::where('is_active', 1)->where('email', $request->get('email'))->first();

      if ($res && password_verify($request->get('password'), $res->password)) {
        $team = Teams::where('user_id', $res->id)->first();  // join不要
        Session::put('userid', $res->id);
        Session::put('role', $res->role);
        Session::put('authType', $res->authType);
        Session::put('avatar', $res->avatar);
        Session::put('email', $res->email);
        if ($res->role == 'team') {
          //全権限アカウントかどうか
          if ($res->email == 'admin_team') {
            $team = \App\Teams::first();
            Session::put('org_id', $team->organizations_id);
            Session::put('team_id', $team->id);
            Session::put('admin', true);
          } else {
            $team = \App\Teams::where('user_id', $res->id)->first();
            Session::put('org_id', $team->organizations_id);
            Session::put('team_id', $team->id);
          }
          return \Redirect::to('/cp/team');
        } else {
          Session::put('admin', true);
          return \Redirect::to('/admin');
        }
      } else {
        return \Redirect::back()->withInput()->with('error-msg', 'メールアドレス又はパスワードが異なります');
      }
    }
  }

  public function getLogout()
  {
    if (session('role') == 'team') {
      Session::flush();
      //return view('team/logout');
      return \Redirect::route('login');
    } else {
      Session::flush();
      return \Redirect::route('login');
    }
  }

  public function getReminder()
  {
    return view('reminder.index');
  }

  public function postReminder()
  {
    $user = User::where('email', Input::get('email'))->first();

    if (!isset($user)) {
      return "error";
    }

    $data = array();
    $data['plain_password'] = str_random(10);
    $data['password'] = password_hash($data['plain_password'], PASSWORD_DEFAULT);
    $data['email'] = $user->email;
    \Mail::send(['text' => 'emails.reminder'], $data, function ($m) use ($user) {
      //$user = User::where('email',Input::get('email'))->first();
      $m->to($user->email)->subject('パスワードリセットのお知らせ');
    });

    User::where('email', Input::get('email'))->update(['password' => $data['password']]);

    return view('reminder.finish');
  }

  public function getRegister()
  {
    return view('auth/regist');
  }

  public function registConfirm(Request $req)
  {

    // dd($req->all());
    $input = $req->except('_token', 'files');

    $rules = array(
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'tel' => 'required',
      'add1' => 'required',
      'add2' => 'required',
      'password' => 'required|min:6|max:15',
      'group_id' => 'required'
    );

    $messages = array(
      'name.required' => 'チーム名を入力してください',
      'email.required' => 'メールアドレスを入力してください',
      'email.email' => 'メールアドレスを確認してください',
      'email.unique' => 'ご登録頂いたメールアドレスはすでに利用されています',
      'tel.required' => 'TELを入力してください',
      'add1.required' => '市区町村を入力してください',
      'add2.required' => '以降の住所を入力してください',
      'password.required' => 'パスワードを入力してください',
      'password.min' => 'パスワードを６文字〜１５文字で指定してください',
      'password.max' => 'パスワードを６文字〜１５文字で指定してください',
      'group_id.required' => '所属リーグを入力してください',
    );

    $user_input['email'] = $req->get('email');
    $user_input['role'] = 'team';
    // $pre_password = str_random(10); // メール送信時に利用
    $user_input['password'] = password_hash($req->get('password'), PASSWORD_DEFAULT);
    $user_input['token'] = str_random(40);
    $user_input['is_active'] = 0; // 登録時は未承認

    // dd($user_input, $input);

    //バリデーション処理
    $val = \Validator::make($input, $rules, $messages);
    //バリデーションNGなら
    if ($val->fails()) {
      return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
    }

    // if(User::where('email',$input['email'])->count()==1){
    //   return "すでにそのメールアドレスは登録されています";
    // }else{
    //   User::create($user_input);
    // }

    // dd($user_input, $input);

    $team = (object)$req->except('_token', 'files', 'zip', 'email', 'password');

    $image = \Input::file('emblem_img');
    if ($image != '') {
      $sInfoFile = uploadFile($image);
      $team->emblem_img = $sInfoFile['name_file'];
    }

    $image = \Input::file('group_img');
    if ($image != '') {
      $sInfoFile = uploadFile($image);
      $team->group_img = $sInfoFile['name_file'];
    }

    $req->session()->put('regist.team', $team);
    $req->session()->put('regist.user', $user_input);
    // $req->session()->put('regist.pre_password',$pre_password);

    return view('auth/registConfirm')->with(compact('team', 'user_input'));
  }

  public function registCompleted(Request $req)
  {
    // dd(\Session::get('regist.team'),$req->all());

    $input = $req->except('_token', 'files');

    $rules = array(
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'tel' => 'required',
      'add1' => 'required',
      'add2' => 'required',
      'password' => 'required|min:6|max:15'
    );

    $messages = array(
      'name.required' => 'チーム名を入力してください',
      'email.required' => 'メールアドレスを入力してください',
      'email.email' => 'メールアドレスを確認してください',
      'email.unique' => 'ご登録頂いたメールアドレスはすでに利用されています',
      'tel.required' => 'TELを入力してください',
      'add1.required' => '市区町村を入力してください',
      'add2.required' => '以降の住所を入力してください',
      'password.required' => 'パスワードを入力してください',
      'password.min' => 'パスワードを６文字〜１５文字で指定してください',
      'password.max' => 'パスワードを６文字〜１５文字で指定してください'
    );

    $user = [];
    $user['email'] = $req->get('email');
    $user['role'] = 'team';
    // $pre_password = str_random(10); // メール送信時に利用
    $user['password'] = password_hash($req->get('password'), PASSWORD_DEFAULT);
    $user['token'] = str_random(40);
    $user['is_active'] = 0; // 登録時は未承認

    // dd($user, $input);

    //バリデーション処理
    $val = \Validator::make($input, $rules, $messages);
    //バリデーションNGなら
    if ($val->fails()) {
      return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
    }


    // team情報
    $team = $req->except('_token', 'files', 'email', 'password', 'group_id');

    $image = \Input::file('emblem_img');
    if ($image != '') {
      $sInfoFile = uploadFile($image);
      $team['emblem_img'] = $sInfoFile['name_file'];
    }

    $image = \Input::file('group_img');
    if ($image != '') {
      $sInfoFile = uploadFile($image);
      $team['group_img'] = $sInfoFile['name_file'];
    }

    // $team = (array)$req->session()->get('regist.team');
    // $user = (array)$req->session()->get('regist.user');

    // \Session::forget('regist.team');
    // \Session::forget('regist.user');

    if (isset($user) and isset($team)) {
      $_user = User::create($user);
      $team['user_id'] = $_user->id;
      $res_obj = Teams::create($team);
      // team_yearly_groupに追加する
      \DB::table('team_yearly_group')->insert(
        [
          'team_id' => $res_obj['id'],
          'yyyy' => config('app.user_reg_nendo'),
          'group_id' => $req->get('group_id')
        ]
      );
    }

    // メール送信
    \Mail::send(['text' => 'emails.regist'], $user, function ($m) use ($user) {
      $m->to($user['email'])->subject('２段階認証のお知らせ');
    });

    // return view('auth/registCompleted');
    return redirect()->route('regist.finished');
  }

  public function getRegistCompleted()
  {
    return view('auth/registCompleted');
  }
}
