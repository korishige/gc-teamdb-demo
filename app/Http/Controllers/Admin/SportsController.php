<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sports;

class SportsController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $obj = Sports::get();
    return view('admin.sports.index')->with(compact('obj'));
  }

  public function create(){
    $obj = Sports::get();
    return view('admin.sports.create')->with(compact('obj'));
  }

  public function store(Request $req){
    $input = $req->except('_token');
    Sports::create($input);
    return redirect()->route('admin.sports.index')->with('msg','保存しました');
  }

  public function edit($id){
    $obj = Sports::find($id);
    return view('admin.sports.edit')->with(compact('obj'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id');
    $id = $req->get('id');
    Sports::where('id',$id)->update($input);
    return redirect()->route('admin.sports.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    Sports::where('id',$id)->delete();
    return redirect()->route('admin.sports.index')->with('msg','削除しました');
  }
}
