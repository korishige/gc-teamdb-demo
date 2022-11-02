<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;

use App\Leagues;
use App\Matches;
use App\MatchPhotos;
use App\Groups;

class GalleryController extends Controller
{

  public function __construct()
  {
  }

  public function index($groups_id = 1, $yyyy = '')
  {
    $yyyy = ($yyyy == '') ? config('app.nendo') : $yyyy;
    $nav_on = 'gallery';

    // // 部に所属するグループ抜き出し
    // $group_ids = Groups::where('grouping',$groups_id)->lists('id');
    // // 部に属するリーグ抜き出し
    // $leagues = Leagues::whereIn('group_id',$group_ids)->get();
    // $league_ids = Leagues::whereIn('group_id',$group_ids)->lists('id');

    // $g = Groups::where('grouping',$groups_id)->lists('id');

    // foreach($leagues as $league){
    //   $matches[$league->id] = Matches::with('away','home','venue','goals','leagueOne')->whereHas('leagueOne',function($q) use ($g){
    //     return $q->whereIn('group_id',$g);
    //   })->has('photo1')->where('is_filled',1)->where('is_publish',1)->orderBy('updated_at','desc')->paginate(18);
    // }

    if ($groups_id == 1) {
      $group = Groups::where('convention', config('app.convention'))->first();
      $groups_id = $group->id;
    }

    // $groups_id = Input::has('groups_id') ? Input::get('groups_id') : $group->id;
    // $groups = Groups::where('grouping',$groups_id)->lists('id');

    $groups = Groups::where('convention', config('app.convention'))->get();

    // 部に属するリーグ抜き出し
    $leagues = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->get();
    // 部に属するリーグIDのみ抜き出し
    $league_ids = Leagues::where('convention', config('app.convention'))->where('year', $yyyy)->where('group_id', $groups_id)->lists('id');

    // $leagues = Leagues::where('grouping',$group_id)->get();
    // $league_ids = Leagues::where('grouping',$group_id)->lists('id');
    // todo : 2020-04-26 is_filled, is_publish のフィルタ入れたほうがいいかも
    // $match_ids = Matches::whereIn('leagues_id',$league_ids)->lists('id');
    // $photos = MatchPhotos::whereIn('match_id',$match_ids)->orderBy('updated_at','desc')->paginate(10);

    $matches = Matches::whereIn('leagues_id', $league_ids)->has('photo1')->orderBy('match_at', 'desc')->paginate(10);

    // dd($match);
    // $photos = MatchPhotos::whereIn('match_id',$match_ids)->orderBy('updated_at','desc')->paginate(10);
    return view('front.gallery.index')->with(compact('groups_id', 'nav_on', 'matches', 'leagues', 'yyyy', 'groups'));
  }

  public function show($id)
  {
    // $id : 試合ID
    $nav_on = 'gallery';
    $photos = MatchPhotos::find($id);
    // return "デザイン待ち";
    return view('front.gallery.show')->with(compact('nav_on', 'photos'));
  }
}
