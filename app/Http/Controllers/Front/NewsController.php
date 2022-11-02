<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;

// use App\Cfg;
// use App\Pref;
// use App\Branch;
use App\News2;

class NewsController extends Controller
{

  public function __construct()
  {
  }

  public function index()
  {
    $nav_on = 'news';
    $newsObj = News2::where('convention', config('app.convention'))->where('is_publish', 1)->orderBy('dis_dt', 'desc');
    $newsObj = $newsObj->paginate(30);
    return view('front.news.index')->with(compact('nav_on', 'newsObj'));
  }

  public function show($id)
  {
    $nav_on = 'news';
    $news = News2::findOrFail($id);
    return view('front.news.show')->with(compact('nav_on', 'news'));
  }
}
