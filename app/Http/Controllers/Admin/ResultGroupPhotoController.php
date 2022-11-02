<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;

use Input;
use Cache;

class ResultGroupPhotoController extends Controller {

  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function edit($id){
    // $id : match_id
    $match = Matches::find($id);
    // チーム情報の取得に必要
    $teamObj = LeagueTeams::where('leagues_id',$match->leagues_id)->orderBy('id','asc')->lists('name','team_id');
    return view('admin.result.group_photo.edit')->with(compact('match','teamObj'));
  }

  public function update(Request $req){
    $id = $req->get('id');
    // dd($req->all());
    // dd($id);
    // if($req->hasFile('gallery')) print("gallery_has");
    // if($req->has('img_delete')) print("img_delete_has");
    // return 0;

    $data = array();

    $match = Matches::find($id);

    if($req->has('home_photo_delete')){
      $data['home_photo'] = '';
      upfileDelete($match->home_photo);
    }


    if($req->hasFile('home_photo')){
      $image = \Input::file('home_photo');
      // $image = $req->file('home_photo');
      if($image!=''){
        $sInfoFile = uploadFile($image);
        $data['home_photo'] = $sInfoFile['name_file'];
      }else{
        ;
        // $data['home_photo'] = $_team->home_photo;
      }
    }

    if($req->has('away_photo_delete')){
      $data['away_photo'] = '';
      upfileDelete($match->away_photo);
    }

    if($req->hasFile('away_photo')){
      $image = \Input::file('away_photo');
      // $image = $req->file('away_photo');
      if($image!=''){
        $sInfoFile = uploadFile($image);
        $data['away_photo'] = $sInfoFile['name_file'];
      }else{
        ;
        // $team->away_photo = $_team->away_photo;
      }
    }

    if(count($data)>0)
      Matches::where('id',$id)->update($data);

    return redirect()->route('admin.result.index')->with('msg','保存しました');
  }

}
