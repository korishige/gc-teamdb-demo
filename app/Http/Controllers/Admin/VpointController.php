<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;
use App\Vpoint;

use Input;
use Cache;

class VpointController extends Controller {

  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $vpointObj = Vpoint::all();
    return view('admin.vpoint.index',compact('vpointObj'));
  }

  public function create(){
    return view('admin.vpoint.create');
  }

  public function store(){
    $input = Input::except('_token');

    $rules = array(
      'name'=>'required',
      'win'=>'required|integer',
      'lose'=>'required|integer',
      'draw'=>'required|integer',
      'pk_win'=>'required|integer',
      'pk_lose'=>'required|integer',
    );

    $messages = array(
      'name.required' => '設定名称を入力してください',
      'win.required' => '勝ちを入力してください',
      'win.integer' => '勝ちは整数を入力してください',
      'lose.required' => '負けを入力してください',
      'lose.integer' => '負けは整数を入力してください',
      'draw.required' => '引き分けを入力してください',
      'draw.integer' => '引き分けは整数を入力してください',
      'pk_win.required' => 'PK勝ちを入力してください',
      'pk_win.integer' => 'PK勝ちは整数を入力してください',
      'pk_lose.required' => 'PK負けを入力してください',
      'pk_lose.integer' => 'PK負けは整数を入力してください',
    );

    //バリデーション処理
    $val=\Validator::make($input,$rules,$messages);
    if($val->fails()){
      return redirect()->back()
        ->withErrors($val->errors())
        ->withInput()
        ->with('messages');
    }

    Vpoint::create($input);

    return redirect()->route('admin.vpoint.index')->with('msg','保存しました');
  }

  public function edit($id){
    $vpoint = Vpoint::where('id',$id)->first();
    return view('admin.vpoint.edit')->with(compact('vpoint'));
  }

  public function update(){
    //dd(Input::all());
    $input = Input::except('_token','id');
    $id = Input::get('id');

    $rules = array(
      'name'=>'required',
      'win'=>'required|integer',
      'lose'=>'required|integer',
      'draw'=>'required|integer',
      'pk_win'=>'required|integer',
      'pk_lose'=>'required|integer',
    );

    $messages = array(
      'name.required' => '設定名称を入力してください',
      'win.required' => '勝ちを入力してください',
      'win.integer' => '勝ちは整数を入力してください',
      'lose.required' => '負けを入力してください',
      'lose.integer' => '負けは整数を入力してください',
      'draw.required' => '引き分けを入力してください',
      'draw.integer' => '引き分けは整数を入力してください',
      'pk_win.required' => 'PK勝ちを入力してください',
      'pk_win.integer' => 'PK勝ちは整数を入力してください',
      'pk_lose.required' => 'PK負けを入力してください',
      'pk_lose.integer' => 'PK負けは整数を入力してください',
    );

    //バリデーション処理
    $val=\Validator::make($input,$rules,$messages);
    if($val->fails()){
      return redirect()->back()
        ->withErrors($val->errors())
        ->withInput()
        ->with('messages');
    }

    Vpoint::where('id',$id)->update($input);

    return redirect()->route('admin.vpoint.index')->with('msg','保存しました');
  }

  public function delete($id){
    Matches::where('id',$id)->delete();
    Comments::where('match_id',$id)->delete();
    return redirect()->route('admin.vpoint.index')->with('msg','削除しました');
  }

}
