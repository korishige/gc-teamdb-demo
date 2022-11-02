<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;
use Cache;

use App\Cfg;
use App\Pref;
use App\Sports;
use App\Leagues;
use App\LeagueTeams;
use App\Matches;
use App\Comments;

class PcCommentController extends Controller {

	public function __construct(){

	}

	public function create($leagues_id,$match_id){
		//$pref = $this->pref[$id_sites];

		$league = Leagues::find($leagues_id);
		$match = Matches::find($match_id);

		return view('front.comment.create',compact('league','match'));
	}

	// 試合とコメント同時投稿
	public function store0(){
		$input = Input::except('_token');
		$inputC = Input::except('_token','home_id','home_pt','away_id','away_pt','match_at','place');
		$inputM = Input::except('comment','img','mov');

		$matchCnt = Matches::where('leagues_id',$inputM['leagues_id'])->where('home_id',$inputM['home_id'])->where('away_id',$inputM['away_id'])->count();

		if($matchCnt>1){
			return \Redirect::back()
			->withInput()
			->with('msg','すでに登録された対戦です');
		}

		if($inputM['home_id']==$inputM['away_id']){
			return \Redirect::back()
			->withInput()
			->with('msg','同じチームが設定されています');
		}

		$rules = array(
			'pass'=>'required'
			);

		$messages = array(
			'pass.required' => 'パスワードを入力してください'
			);

        //バリデーション処理
		$val=\Validator::make($input,$rules,$messages);
		if($val->fails()){
			return \Redirect::back()
			->withErrors($val->errors())
			->withInput()
			->with('messages');
		}

		$inputC['ip'] = $_SERVER['REMOTE_ADDR'];
		$inputM['ip'] = $_SERVER['REMOTE_ADDR'];

		$image = Input::file('img');
		if($image!=''){
			$sInfoFile = uploadFile($image);
			$inputC['img'] = $sInfoFile['name_file'];
		}else{
			$inputC['img'] = '';
		}

		$match = Matches::create($inputM);

		$inputC['match_id'] = $match->id;
		Comments::create($inputC);

		return redirect()->back()->with('msg','試合結果とコメントを追加しました');
	}

	// コメントのみ
	public function store(){
		$input = Input::except('_token');

		$rules = array(
			'comment'=>'required',
			'pass'=>'required'
			);

		$messages = array(
			'comment.required' => 'コメントを入力してください',
			'pass.required' => 'パスワードを入力してください'
			);

        //バリデーション処理
		$val=\Validator::make($input,$rules,$messages);
		if($val->fails()){
			return \Redirect::back()
			->withErrors($val->errors())
			->withInput()
			->with('messages');
		}

		$input['ip'] = $_SERVER['REMOTE_ADDR'];

		$image = Input::file('img');
		if($image!=''){
			$sInfoFile = uploadFile($image);
			$input['img'] = $sInfoFile['name_file'];
		}else{
			$input['img'] = '';
		}

		Comments::create($input);

		return Redirect::route('pref.league.match',['id'=>$input['match_id']])->with('msg','コメントを作成しました');
	}

	public function edit($id){
		$comment = Comments::find($id);
		$league = Leagues::find($comment->leagues_id);
		$match = Matches::find($comment->match_id);

		return view('front.comment.edit',compact('comment','league','match'));
	}

	public function update(){

		$input = Input::except('_token','img_del','img');
		$id = Input::get('id');
        //dd(Input::get('img_del'));

		$comment = Comments::find($id);

    		// passのチェック必須
		if($input['pass']!=$comment->pass){
			return \Redirect::back()
			->withInput()
			->with('msg','パスワードが異なります');
		}

		$rules = array(
			'comment'=>'required',
			'pass'=>'required'
			);

		$messages = array(
			'comment.required' => 'コメントを入力してください',
			'pass.required' => 'パスワードを入力してください'
			);

        //バリデーション処理
		$val=\Validator::make($input,$rules,$messages);
		if($val->fails()){
			return \Redirect::back()
			->withErrors($val->errors())
			->withInput()
			->with('messages');
		}

		$input['ip'] = $_SERVER['REMOTE_ADDR'];

		$image = Input::file('img');
		if($image!=''){
			$sInfoFile = uploadFile($image);
			$input['img'] = $sInfoFile['name_file'];
		}elseif(Input::get('img_del')==1){
			$input['img'] = '';
		}else{
      ;	// 画像データはそのまま
    }

    Comments::where('id',$id)->update($input);

    return Redirect::route('pref.league.match',['id'=>$comment->leagues_id])->with('msg','コメントを編集しました');
  }

  public function delete(){
  	//$pref = $this->pref[$id_sites];

  	$input = Input::except('_token','id');
  	$id = Input::get('id');
  	$comment = Comments::find($id);
		//$league_id = $match->leagues_id;

  	if($input['pass']!=$comment->pass){
  		return \Redirect::back()
  		->withInput()
  		->with('msg','パスワードが異なります');
  	}
  	Comments::where('id',$id)->delete();

  	return \Redirect::route('pref.league.match',['id'=>$comment->leagues_id])->with('msg','コメントを削除しました');
  	return "comment.delete";
  }

}
