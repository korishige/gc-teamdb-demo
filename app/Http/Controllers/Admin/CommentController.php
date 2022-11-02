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

class CommentController extends Controller {

	public function __construct(){
        $this->middleware('auth.admin');
	}

	public function index($id){
		$commentObj = Comments::where('leagues_id',$id)->orderBy('updated_at','desc')->get();
		$league = Leagues::find($id);

		return view('admin.comment.index',compact('commentObj','league'));
		return "league.comment.{$id}";
	}

	public function create(){
	}

	public function store(){
	}

	public function edit($id){
		$comment = Comments::find($id);
		$league = Leagues::find($comment->leagues_id);
		$match = Matches::find($comment->match_id);

		return view('admin.comment.edit',compact('comment','league','match'));
	}

	public function update(){

		$input = Input::except('_token','img_del','img');
		$id = Input::get('id');

		$comment = Comments::find($id);

		// passのチェック必須
		if($input['pass']!=$comment->pass){
			return redirect()->back()
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
			return redirect()->back()
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

    return redirect()->back()->with('msg','コメントを編集しました');
  }

  public function delete($id){
  	//$comment = Comment::find($id);
  	Comments::where('id',$id)->delete();
    return redirect()->back()->with('msg','コメントを削除しました');
  	return "comment.delete";
  }

}
