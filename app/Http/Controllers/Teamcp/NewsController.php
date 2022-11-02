<?php

namespace App\Http\Controllers\Team;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\News;

class NewsController extends Controller
{
  public function __construct(){
    $this->middleware('auth.team');
  }

  public function index(){
    $obj = News::where('is_publish',1)->orderBy('updated_at','desc');
    $obj = $obj->paginate(20);
    return view('team.news.index')->with(compact('obj'));
  }

  public function show($id){
    $obj = News::find($id);
    return view('team.news.show')->with(compact('obj'));
  }

}
