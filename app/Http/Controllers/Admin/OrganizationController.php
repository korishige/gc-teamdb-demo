<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Organizations;

class organizationController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $obj = Organizations::get();
    return view('admin.organization.index')->with(compact('obj'));
  }

  public function create(){
    $obj = Organizations::get();
    return view('admin.organization.create')->with(compact('obj'));
  }

  public function store(Request $req){
    $input = $req->except('_token');
    Organizations::create($input);
    return redirect()->route('admin.organization.index')->with('msg','保存しました');
  }

  public function edit($id){
    $obj = Organizations::find($id);
    return view('admin.organization.edit')->with(compact('obj'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id');
    $id = $req->get('id');

    Organizations::where('id',$id)->update($input);
    return redirect()->route('admin.organization.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    Organizations::where('id',$id)->delete();
    return redirect()->route('admin.organization.index')->with('msg','削除しました');
  }
}
