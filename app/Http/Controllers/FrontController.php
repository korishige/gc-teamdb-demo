<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flynsarmy\DbBladeCompiler\Facades\DbView;

use Input;
use DB;

use App\News2;
use App\Matches;
use App\Template;

// use App\Pref;
// use App\Sports;
use App\Leagues;
use App\Groups;

class FrontController extends Controller
{

	public function __construct()
	{
		//$this->middleware('csrf',['on'=>'post']);
		//$this->middleware('myauth');
		//$this->cfg = Cfg::find(1);
		//$this->aspname = \Config::get('app.aspname');
	}

	public function index()
	{
		$nav_on = 'top';
		$newsObj = News2::where('convention', config('app.convention'))->where('is_publish', 1)->orderBy('dis_dt', 'desc')->take(6)->get();
		// TODO: １部、２部、３部のグループ、開催年度、シーズンに合わせたフィルタリングが必要。
		if (date('n') >= 7 and date('n') <= 4) {
			$now_season = 0;
		} else {
			$now_season = 1;
		}

		// $g[1] = Groups::where('grouping', 1)->lists('id');
		// $g[2] = Groups::where('grouping', 2)->lists('id');
		// $g[3] = Groups::where('grouping', 3)->lists('id');

		$groups = Groups::where('convention', config('app.convention'))->get();

		// now_season / year のフィルタリングが後々必要になる。

		foreach ($groups as $group) {
			$matches[$group->id] = Matches::with('away0', 'home0', 'leagueOne')->whereHas('leagueOne', function ($q) use ($group) {
				return $q->where('year', config('app.nendo'))->where('group_id', $group->id);
			})->where('match_date', '<=', \DB::raw('current_timestamp + interval -6 hour'))->take(4)->orderBy('match_at', 'desc')->get();
			//    })->where('match_date','<=',date('Y-m-d'))->take(4)->orderBy('match_at','desc')->get();
		}

		// $matches[2] = Matches::with('away0', 'home0', 'leagueOne')->whereHas('leagueOne', function ($q) use ($g) {
		// 	return $q->where('year', config('app.nendo'))->whereIn('group_id', $g[2]);
		// })->where('match_date', '<=', \DB::raw('current_timestamp + interval -6 hour'))->take(4)->orderBy('match_at', 'desc')->get();

		// $matches[3] = Matches::with('away0', 'home0', 'leagueOne')->whereHas('leagueOne', function ($q) use ($g) {
		// 	return $q->where('year', config('app.nendo'))->whereIn('group_id', $g[3]);
		// })->where('match_date', '<=', \DB::raw('current_timestamp + interval -6 hour'))->take(4)->orderBy('match_at', 'desc')->get();

		return view('front.index', compact('nav_on', 'newsObj', 'matches', 'groups'));
	}

	public function venues()
	{
		$nav_on = 'top';
		return view('front.index', compact('nav_on', 'newsObj', 'matches'));
	}

	public function about()
	{
		$template = Template::select('about')->where('convention', config('app.convention'))->first();
		return DbView::make($template)->field('about')->with(['nav_on' => 'about'])->render();
	}

	public function live()
	{
		$template = Template::where('convention', config('app.convention'))->first();
		return \DbView::make($template)->field('live')->with(['nav_on' => 'top'])->render();
	}

	public function abst()
	{
		$template = Template::where('convention', config('app.convention'))->first();
		return \DbView::make($template)->field('abstract')->with(['nav_on' => 'top'])->render();
	}

	public function contact()
	{
		return view('front.contact', ['nav_on' => 'top']);
	}

	public function contact_post(Request $req)
	{
		$input = $req->except('_token');

		/*
		kazuki110911@yahoo.co.jp
		info@fukuoka-fa-u18.com
		info@green-card.co.jp

		cc:
		kanri@green-card.co.jp
		*/

		$rules = array(
			'email' => 'required',
			'name' => 'required',
			'body' => 'required',
		);

		$messages = array(
			'name.required' => '名前を入力してください',
			'email.required' => 'メールアドレスを入力してください',
			'body.required' => '本文を入力してください',
		);

		//バリデーション処理
		$val = \Validator::make($input, $rules, $messages);
		if ($val->fails()) {
			return redirect()->back()
				->withErrors($val->errors())
				->withInput()
				->with('messages');
		}

		\Mail::send(['text' => 'emails.contact'], $input, function ($m) use ($input) {
			// $m->to($input['email'])->subject('お問い合わせ');
			$m->to('info@green-card.co.jp')->subject('お問い合わせ');
			$m->cc('kanri@green-card.co.jp');
		});

		return redirect()->route('front.thanks');
		// return view('front.thanks',['nav_on'=>'top']);
	}

	public function thanks()
	{
		return view('front.thanks', ['nav_on' => 'top']);
	}

	public function personal()
	{
		return view('front.personal', ['nav_on' => 'top']);
	}

	public function pp()
	{
		return view('front.pp', ['nav_on' => 'top']);
	}

	public function kiyaku()
	{
		return view('front.kiyaku', ['nav_on' => 'top']);
	}
}
