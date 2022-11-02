<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\News2;

class News2Controller extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $obj = News2::get();
    return view('admin.news2.index')->with(compact('obj'));
  }

  public function create(){
    $obj = News2::get();
    return view('admin.news2.create')->with(compact('obj'));
  }

  public function store(Request $req){
    $input = $req->except('_token','files');
    News2::create($input);
    return redirect()->route('admin.news2.index')->with('msg','保存しました');
  }

  public function edit($id){
    $obj = News2::find($id);
    return view('admin.news2.edit')->with(compact('obj'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id','files');
    $id = $req->get('id');
    News2::where('id',$id)->update($input);
    return redirect()->route('admin.news2.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    News2::where('id',$id)->delete();
    return redirect()->route('admin.news2.index')->with('msg','削除しました');
  }
}
