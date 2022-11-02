<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $userObj = User::where('is_active',1)->get();
    return view('admin.user.index')->with(compact('userObj'));
  }

  public function edit($id){
    $userObj = User::find($id);
    return view('admin.user.edit')->with(compact('userObj'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id');
    $id = $req->get('id');
    User::where('id',$id)->update($input);
    return redirect()->route('admin.user.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    User::where('id',$id)->delete();
    return redirect()->route('admin.user.index')->with('msg','削除しました');
  }
}
