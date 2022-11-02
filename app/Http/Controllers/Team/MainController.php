<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\News;
use App\Teams;
use App\Matches;
use App\Cfg;

class MainController extends Controller
{

	public function __construct(){
		$this->middleware('auth.team');
	}

	public function top(Request $req){
		$newsObj = News::where('is_publish',1)->take(5)->orderBy('updated_at','desc')->get();

        // $a = \App\Matches::where(function($q){
        //     $q->where('home_id',\Session::get('team_id'))->orWhere('away_id',\Session::get('team_id'));
        // })->whereRaw("DATE_FORMAT(match_date, '%Y%m') = '201905'")->get();

		$matches = Matches::with('leagueOne','home0','away0','place')->where(function($q){
			$q->where('home_id',\Session::get('team_id'))->orWhere('away_id',\Session::get('team_id'));
		});

		if($req->has('y'))
			$matches = $matches->whereRaw('(DATE_FORMAT(match_date, "%Y") = '.$req->get('y').')');

		if($req->has('m'))
			$matches = $matches->whereRaw('(DATE_FORMAT(match_date, "%m") = '.$req->get('m').')');

		$matches = $matches->orderBy('is_filled','asc')->orderBy('updated_at','desc')->paginate(50);
		return view('team.top')->with(compact('newsObj','matches'));
	}

	public function edit(){
		$team = Teams::find(session('team_id'));
		return view('team.info.edit')->with(compact('team'));
	}

	public function confirm(Request $req){
		// dd($req->all());
		$team = (object)$req->except('_token', 'files', 'zip');

		// 画像が入力されていないときは、DBからデータを持ってくる
		$_team = Teams::find($team->id);	// join不要

		$image = \Input::file('emblem_img');
		$del = \Input::get('emblem_img_delete');
		if($del==1){
			$team->emblem_img = '';
			upfileDelete($team->emblem_img);
		}
		if($image!=''){
			$sInfoFile = uploadFile($image);
			$team->emblem_img = $sInfoFile['name_file'];
		}else{
			$team->emblem_img = $_team->emblem_img;
		}

		$image = \Input::file('group_img');
		$del = \Input::get('group_img_delete');
		if($del==1){
			$team->group_img = '';
			upfileDelete($team->group_img);
		}
		if($image!=''){
			$sInfoFile = uploadFile($image);
			$team->group_img = $sInfoFile['name_file'];
		}else{
			$team->group_img = $_team->group_img;
		}

		$req->session()->put('post_data',$team);
		return view('team.info.confirm')->with(compact('team'));

	}

	public function update(Request $req){
		// dd(\Session::get('post_data'),$req->all());
		$input = (array)$req->session()->get('post_data');
		\Session::forget('post_data');
		$id = $input['id'];
		unset($input['id']);

		Teams::where('id',$id)->update($input);
		return redirect()->route('team.info.edit')->with('msg','保存しました');
	}

	public function account(){
		$user = User::find(\Session::get('userid'));
		return view('team.info.account')->with(compact('user'));
	}

	public function email_update(Request $req){
		$user = User::find($req->session()->get('userid'));

		$data = $req->except('_token');

		$rules=array(
			// 'email' => 'unique:users,email_address,'.$user->id
			// 'email' => 'unique:users,email_address,'.$user->id.',user_id'
			'email_new'=>'required|email|unique:users,email,'.$user->id,
		);

		$messages = array(
			'email_new.required'=>'新メールアドレスを入力してください',
			'email_new.email'=>'メールアドレスの形式が正しくないようです',
			'email_new.unique'=>'新メールアドレスはすでに登録済みのメールアドレスです。他のメールアドレスをご利用ください。',
		);
		
		//バリデーション処理
		$val=\Validator::make($data,$rules,$messages);
		//バリデーションNGなら
		if($val->fails()){
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$data['token'] = str_random(40);

		// dd($data);

		\Mail::send(['text'=>'emails.check'],$data,function($m) use ($data){
			$m->to($data['email_new'])->subject('メールアドレス変更のご確認');
		});

		// return view('dummy')->with(compact('data'));
		User::where('id',\Session::get('userid'))->update($data);
		
		return redirect()->route('team.account.edit')->with('msg','保存しました');
	}

	public function password_update(Request $req){
		$input = $req->all();
		$data = array();
		$msg = '';

		$rules=array(
			'password'=>'sometimes|required|min:6|max:15',
			'password_new'=>'required_with:password|required|min:6|max:15',
			'password_new2'=>'required_with:password_new|required_with:password|required|min:6|max:15|same:password_new',
		);

		$messages = array(
			'password.required'=>'パスワードを入力してください',
			'password.min'=>'パスワードを６文字〜１５文字で指定してください',
			'password.max'=>'パスワードを６文字〜１５文字で指定してください',
			'password_new.required'=>'新パスワードを入力してください',
			'password_new.required_with'=>'パスワード変更の際は、新パスワードが必須です',
			'password_new.min'=>'パスワードを６文字〜１５文字で指定してください',
			'password_new.max'=>'パスワードを６文字〜１５文字で指定してください',
			'password_new2.required'=>'新パスワード確認用を入力してください',
			'password_new2.required_with'=>'パスワード変更の際は、新パスワード確認用が必須です',
			'password_new2.same'=>'新パスワードと新パスワード確認用が異なります',
			'password_new2.min'=>'新パスワード確認用を６文字〜１５文字で指定してください',
			'password_new2.max'=>'新パスワード確認用を６文字〜１５文字で指定してください'
		);

		//バリデーション処理
		$val=\Validator::make($input,$rules,$messages);
		//バリデーションNGなら
		if($val->fails()){
			return \Redirect::back()->withErrors($val->errors())->withInput()->with('messages');
		}

		$user = User::find(\Session::get('userid'));
		if(password_verify($input['password'],$user->password)){
			// $msg = "パスワード変更に成功しました";
			$data['password'] = password_hash($req->get('password_new'),PASSWORD_DEFAULT);
			User::where('id',\Session::get('userid'))->update($data);
		}else{
			$msg = "現在のパスワードが違います";
		}

		if($msg!=''){
			return redirect()->back()->withInput()->with('error-msg',$msg);
		}else{
			return redirect()->route('team.account.edit')->with('msg','保存しました');
		}
	}

	// public function getConfig(){
	// 	$user = User::where('id',\Session::get('userid'))->firstOrFail();
	// 	$cfg = Cfg::where('id',1)->firstOrFail();
	// 	return view('team.config')->with(compact('user','cfg'));
	// }

	// public function postConfig(Request $request){
	// 	$input = $request->except('_token','email','password');
	// 	Cfg::where('id',1)->update($input);
	// 	$input = $request->only('email','password');
	// 	User::where('id',\Session::get('userid'))->update($input);
	// 	return redirect()->to('team/config')->with('msg','保存しました');
	// }

}
