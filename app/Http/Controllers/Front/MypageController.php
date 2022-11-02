<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

use App\Cfg;
use App\Wanted;
use App\Pref;
use App\Branch;
use App\Sports;
use App\User;
use App\Threads;
use App\Boards;

class MypageController extends Controller
{

  public function __construct(){
    //$this->middleware('csrf',['on'=>'post']);
    //$this->middleware('auth.admin');
    $this->middleware('myauth');
    //$this->cfg = Cfg::find(1);
    //$this->aspname = \Config::get('app.aspname');
  }

  public function index(){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::with(['sports','pref'])->where('user_id',$user->id)->get();
    $threads = Threads::where('user_id',$user->id)->get();
    return view('front.mypage.index')->with(compact('user','wanted','threads'));
  }

  public function edit(){
    $user = User::find(session('userid'));
    $wanted = Wanted::where('user_id',$user->id)->get();
    return view('front.mypage.edit')->with(compact('user','wanted'));
  }

  public function update(Request $request){
    $input = $request->except('_token');
    //$input['user_id'] = \Session::get('userid');
    //★validate
    $rules = array(
        'name'=>'required',
        'nickname'=>'required'
    );

    $messages = array(
      'name.required' => '名前を入力してください',
      'nickname.required' => 'ニックネームを入力してください'
    );

    //バリデーション処理
    $val=\Validator::make($input,$rules,$messages);
    //バリデーションNGなら
    if($val->fails()){
      return \Redirect::back()
        ->withErrors($val->errors())
        ->withInput()
        ->with('messages');
    }

    User::where('id',session('userid'))->update($input);

    return redirect()->back()->with('msg','保存しました');
  }

  public function apply($id){
    $user = User::find(session('userid'));
    $wanted = Wanted::find($id);
    return view('front.mypage.apply')->with(compact('user','wanted'));
  }

  public function apply_store(Request $req){
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $input = $req->except('_token');
    $input['type'] = 'apply';
    $input['user_id'] = session('userid');
    $input['is_open'] = 0;
    Threads::create($input);
    return redirect()->route('front.mypage.index')->with('msg','募集しました');
  }

  public function question($id){
    $user = User::find(session('userid'));
    $wanted = Wanted::find($id);
    return view('front.mypage.question')->with(compact('user','wanted'));
  }

  public function question_store(Request $req){
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $input = $req->except('_token');
    $input['type'] = 'question';
    $input['user_id'] = session('userid');
    $input['is_open'] = 0;
    Threads::create($input);
    return redirect()->route('front.mypage.index')->with('msg','質問しました');
  }

  public function board($id){
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $thread = Threads::find($id);
    $user = User::find($thread->user_id);
    $boards = Boards::where('thread_id',$thread->id)->orderBy('created_at','asc')->get();
    return view('front.mypage.board')->with(compact('user','boards','thread'));
  }

  public function board_post(Request $req){
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $user = User::find(session('userid'));

    $input = $req->except('_token');
    $input['user_id'] = session('userid');
    $input['is_open'] = 0;
    Boards::create($input);
    return redirect()->back()->with('msg','送信しました');
  }

  public function thread($id){
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $user = User::find(session('userid'));

    $wanted = Wanted::where('user_id',$user->id)->find($id);
    $threads = Threads::where('wanted_id',$wanted->id)->get();
    return view('front.mypage.thread')->with(compact('user','wanted','threads'));
  }

}