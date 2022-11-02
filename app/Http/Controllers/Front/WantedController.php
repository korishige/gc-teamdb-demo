<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Cfg;
use App\Wanted;
use App\Pref;
use App\Branch;
use App\Sports;
use App\User;
use App\WantedNext;

use Session;
use Input;

class WantedController extends Controller
{

  public function __construct(){
    //$this->middleware('csrf',['on'=>'post']);
    //$this->middleware('auth.admin');
    $this->middleware('myauth');
    //$this->cfg = Cfg::find(1);
    //$this->aspname = \Config::get('app.aspname');
  }

  public function start($id){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::where('user_id',$user->id)->where('id',$id)->firstOrFail();
    $wanted->where('id',$id)->update(['status'=>1]);
    return redirect()->back()->with('msg','保存しました');
  }

  public function stop($id){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::where('user_id',$user->id)->where('id',$id)->firstOrFail();
    $wanted->where('id',$id)->update(['status'=>0]);
    return redirect()->back()->with('msg','保存しました');
  }

  public function copy($id){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::where('user_id',$user->id)->where('id',$id)->firstOrFail()->toArray();
    unset($wanted['id']);
    unset($wanted['total_view']);
    $wanted['status'] = 0;
    Wanted::create($wanted);
    return redirect()->back()->with('msg','募集内容をコピーしました');
  }

  public function delete($id){
    $user = User::findOrFail(session('userid'));
    Wanted::where('user_id',$user->id)->where('id',$id)->delete();
    return redirect()->back()->with('msg','募集を削除しました');
  }

  public function refresh($id){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::where('user_id',$user->id)->where('id',$id)->firstOrFail();
    $wanted->where('id',$id)->update(['updated_at'=>date('Y-m-d H:i:s')]);
    return redirect()->back()->with('msg','更新日を反映しました');
  }

  public function index(){
    return "wanted.index";
    $user = User::findOrFail(session('userid'));
    return view('front.wanted.index')->with(compact('user'));
  }

  public function create(){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::where('user_id',$user->id);
    return view('front.wanted.create')->with(compact('user','wanted'));
  }

  public function store(Request $req){
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $input = $req->except('_token','img','nextday');
    $nextdays = $req->only('nextday');

    $input['user_id'] = session('userid');

    $rules=array(
      'title'=>'required'
    );

    $messages = array(
      'title.required' => 'タイトルを入力してください'
    );

    //バリデーション処理
    $val=\Validator::make($input,$rules,$messages);
    if($val->fails()){
      return redirect()->back()
        ->withErrors($val->errors())
        ->withInput()
        ->with('messages')
        ->with('error-msg','記入項目に漏れ等がございます。');
    }

    $image = Input::file('img');
    if($image!=''){
      $sInfoFile = uploadFile($image);
      $input['img'] = $sInfoFile['name_file'];
    }

    $wanted = Wanted::create($input);

    foreach($nextdays as $day){
      WantedNext::create(['wanted_id'=>$wanted->id,'nextday'=>$day]);
    }
    return redirect()->route('front.mypage.index')->with('msg','保存しました');
  }

  public function edit($id){
    $user = User::findOrFail(session('userid'));
    $wanted = Wanted::where('user_id',$user->id)->where('id',$id)->first();
    return view('front.wanted.edit')->with(compact('user','wanted'));
  }

  public function update(Request $request){
    //dd($request->all());
    if(!Session::has('userid') && session('userid')==''){
      return "error";
    }
    $input = $request->except('_token','id','img','nextday');
    $id = $request->get('id');
    $input2 = $request->only('nextday');

    $obj = Wanted::find($id);

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

    $rules=array(
        'title'=>'required'
    );

    $messages = array(
      'title.required' => 'タイトルを入力してください'
    );

    //バリデーション処理
    $val=\Validator::make($input,$rules,$messages);
    //バリデーションNGなら
    if($val->fails()){
      return \Redirect::back()
        ->withErrors($val->errors())
        ->withInput()
        ->with('messages')
        ->with('error-msg','記入項目に漏れ等がございます。');
    }
    Wanted::where('user_id',session('userid'))->where('id',$id)->update($input);

    // 全部削除してから入れなおす
    WantedNext::where('wanted_id',$id)->delete();
    foreach($input2['nextday'] as $day){
      $data[] = ['wanted_id'=>$id,'nextday'=>$day];
    }
    //dd($data);
    WantedNext::insert($data);

    return redirect()->back()->with('msg','保存しました');
  }

}
