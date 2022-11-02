<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LeagueTeams;
use App\Matches;
use App\MatchPhotos;

use Input;
use Cache;

class ResultGalleryController extends Controller {

  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function edit($id){
    // $id : match_id
    $match = Matches::find($id);
    $photos = MatchPhotos::where('match_id',$match->id)->lists('img','row')->toArray();
    // チーム情報の取得に必要
    $teamObj = LeagueTeams::where('leagues_id',$match->leagues_id)->orderBy('id','asc')->lists('name','team_id');
    return view('admin.result.gallery.edit')->with(compact('match','teamObj','photos'));
  }

  public function update(Request $req){
    $id = $req->get('id');
    // dd($req->all());
    // dd($id);
    // if($req->hasFile('gallery')) print("gallery_has");
    // if($req->has('img_delete')) print("img_delete_has");
    // return 0;

    $data = array();

    if($req->has('img_delete')){
      foreach($req->get('img_delete') as $key=>$flg){
        if($flg==1){
          $obj = MatchPhotos::where('match_id',$id)->where('row',$key)->first();
          upfileDelete($obj->img);
          MatchPhotos::where('match_id',$id)->where('row',$key)->delete();
        }
      }      
    }

    if($req->hasFile('gallery')){
      if($req->file('gallery') !== NULL){
        foreach($req->file('gallery') as $key=>$file){
          if($file != ''){
            $filename = uploadFile($file);
            // "img" => array:3 [▼
            //   "id" => "pDjCTT4F57uJQwdL2D4yamhKVJ02zU"
            //   "name_file" => "pDjCTT4F57uJQwdL2D4yamhKVJ02zU.jpg"
            //   "title" => "41c64c26.jpg"
            // ]
            MatchPhotos::updateOrCreate(['match_id'=>$id,'row'=>$key],['img'=>$filename['name_file']]);
          }
        }      
      }      
    }

    return redirect()->route('admin.result.index')->with('msg','保存しました');
  }

}
