<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Wanted;
use App\Pref;
use App\Branch;
use App\Sports;

class WantedController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $obj = Wanted::get();
    return view('admin.wanted.index')->with(compact('obj'));
  }

  public function create(){
    $branchAry = [];
    $sportsAry = Sports::lists('name','id');
    return view('admin.wanted.create')->with(compact('branchAry','sportsAry'));
  }

  public function store(Request $req){
    $input = $req->except('_token');
    Wanted::create($input);
    return redirect()->route('admin.wanted.index')->with('msg','保存しました');
  }

  public function edit($id){
    $obj = Wanted::find($id);
    $pref = Pref::where('id',$obj->pref_id)->first();
    $branchAry = Branch::where('pref_id',$obj->pref_id)->orderBy('bSort','desc')->lists('name','id');
    $sportsAry = Sports::lists('name','id');

    return view('admin.wanted.edit')->with(compact('obj','branchAry','sportsAry'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id');
    $id = $req->get('id');
    Wanted::where('id',$id)->update($input);
    return redirect()->route('admin.wanted.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    Wanted::where('id',$id)->delete();
    return redirect()->route('admin.wanted.index')->with('msg','削除しました');
  }
}
