<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\News;
use App\User;
use App\Team;

// 内部向け
class NewsController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function index(){
    $obj = News::get();
    return view('admin.news.index')->with(compact('obj'));
  }

  public function create(){
    $obj = News::get();
    return view('admin.news.create')->with(compact('obj'));
  }

  public function store(Request $req){
    // dd($req->all());

    $input = $req->except('_token','files','broadcast');

    // メール送信
    $broadcast = $req->get('broadcast');

    if($broadcast){

      // TODO : 一旦まだ一斉送信は、テストモード

      // $users = User::where('role','team')->where('is_active',1)->whereIn('id',[133,134])->get();
      $users = User::where('role','team')->where('is_active',1)->get();

      foreach($users as $user){
        $data = array();

        // TODO : 場合によっては、bccで１つで送ったほうがよい？

        $USE_TEXT = 0;
        if($USE_TEXT){
          $data['body'] = strip_tags($input['body']);
          \Mail::send(['text'=>'emails.news'],$data,function($m) use ($user){
            $m->to($user->email)->subject('福岡サッカー協会よりお知らせ | '.\Input::get('title'));
          });
        }else{
          $data['body'] = $input['body'];
          \Mail::send('emails.news_html',$data,function($m) use ($user){
              $m->to($user->email)->subject('福岡サッカー協会よりお知らせ | '.\Input::get('title'));
          });
        }
      }
    }

    News::create($input);

    return redirect()->route('admin.news.index')->with('msg','保存しました');
  }

  public function edit($id){
    $obj = News::find($id);
    return view('admin.news.edit')->with(compact('obj'));
  }

  public function update(Request $req){
    $input = $req->except('_token','id','files');
    $id = $req->get('id');
    News::where('id',$id)->update($input);
    return redirect()->route('admin.news.index')->with('msg','保存しました');
  }

  public function delete($id){
    if(\Session::get('role')!='admin') return 'error';
    News::where('id',$id)->delete();
    return redirect()->route('admin.news.index')->with('msg','削除しました');
  }
}
