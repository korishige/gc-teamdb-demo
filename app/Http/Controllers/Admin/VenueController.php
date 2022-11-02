<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input;

use App\Venue;

class venueController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $obj = Venue::get();
    return view('admin.venue.index')->with(compact('obj'));
  }

  public function create(){
    $obj = Venue::get();
    return view('admin.venue.create')->with(compact('obj'));
  }

  public function store(Request $req){
    $input = $req->except('_token','img');
    $image = Input::file('img');
    if($image!=''){
      $sInfoFile = uploadFile($image);
      $input['img'] = $sInfoFile['name_file'];
    }
    Venue::create($input);
    return redirect()->route('admin.venue.index')->with('msg','保存しました');
  }

  public function edit($id){
    $obj = Venue::find($id);
    return view('admin.venue.edit')->with(compact('obj'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id','img','img_delete');
    $id = $req->get('id');

    // 画像処理関連
    $obj = Venue::find($id);
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

    Venue::where('id',$id)->update($input);
    return redirect()->route('admin.venue.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    Venue::where('id',$id)->delete();
    return redirect()->route('admin.venue.index')->with('msg','削除しました');
  }
}
