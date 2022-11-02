@include('front.parts.pref.header')
<?php
$baseUrl = Config::get('app.url').'/'.$pref->id_areas.'/'.$pref->id;
$typeNews = Config::get('app.typeNews1admin');
$Gbranch = Input::get('branch');
$Gtag = Input::get('tag');
?>

<script type="text/javascript">
	var ua = navigator.userAgent;
	if (ua.indexOf('iPhone') > 0
		|| (ua.indexOf('Android') > 0) && (ua.indexOf('Mobile') > 0)
		|| ua.indexOf('Windows Phone') > 0) {
		if (confirm('スマートフォンサイトに移動しますか？')) {
			location.href = 'http://www.junior-soccer.jp/sp/{{$pref->id_areas}}/{{$pref->id}}';
		}
	}
</script>

<!-- #header -->
<div id="header">
	<a href="{{$baseUrl}}/">
		<div id="header_logo">
			<h1>{{$pref->title}}の少年サッカー・ジュニアサッカー応援情報サイト</h1>
			<img src="{{Config::get('app.pimgurl')}}/{{$pref->id_areas}}/{{$pref->id}}/img/logo.png" class="mb10" />
		</div>
	</a>
	<div id="header_img">
		<img src="{{Config::get('app.url')}}/_images/common/header_img2.png" />
	</div>
	<div id="header_right">
		| <a href="https://www.facebook.com/pages/%E5%85%A8%E5%9B%BD%E5%B0%91%E5%B9%B4%E3%82%B5%E3%83%83%E3%82%AB%E3%83%BC%E5%BF%9C%E6%8F%B4%E5%9B%A3/1439008816399421">facebook</a>
		| <a href="https://twitter.com/juniorsoccer_cs">Twitter</a>
		| <a href="{{$baseUrl}}/about">少年サッカー応援団とは</a>
		| <!--　<a href="{{$baseUrl}}/member/index/join">新規会員登録</a>　｜-->
		<br />
		<br />
		{{-- ヘッダーバナーテンプレ --}}
		@if($pref->id=='fukuoka')
		{{-- ↓ここにバナーをいれる --}}
		<a href="http://www.junior-soccer.jp/kyushu/fukuoka/news/detail/574388"><img src="/_images/common/header_ban_baito_boshu.png" width="508" height="107"></a>
		@elseif($pref->id=='shizuoka')
		{{-- ↓ここにバナーをいれる --}}
		@else
		{{-- ↓ここにバナーをいれる --}}
		<a href="{{Config::get('app.url')}}/{{$pref->id_areas}}/{{$pref->id}}/result/"><img src="/_images/common/header_bana_sokuhou2.png" width="508" height="107"></a>
		@endif
		{{--ここまで--}}
	</div>
	<div class="clear"></div>
</div>
<!-- /#header -->

@include("front.parts.pref.navi")

<!-- #contents -->
<div id="contents">

	@include('front.parts.pref.sidebar')


    	<!-- #contents main -->
	<div id="contents_main">
		
  <div id='errors' style="color:red">
    @include('layouts.message')
  </div>

		<div id="contents_title_result">
		<div id="contents_title_text"><h2>{{$league->name}}リーグ<br>
		{{$match->match_at}} {{$match->home->name}} {{$match->home_pt}}-{{$match->away_pt}}{{$match->away->name}}　の試合へのコメント</h2></div>
			<div id="contents_title_navi">
				<span class="contents_title_navi_box"><a href="{{route('pref.league.match',['area'=>$pref->id_areas,'pref'=>$pref->id,'id'=>$league->id])}}">試合一覧に戻る</a></span>
			</div>
			<div class="clear"></div>
		</div>

		<div class="league_input">
			{{Form::open(['files'=>true,'url'=>route('pref.comment.update',['area'=>$pref->id_areas,'pref'=>$pref->id]),'class'=>'form-horizontal form-label-left'])}}
				{{Form::hidden('id',$comment->id)}}
				{{Form::hidden('leagues_id',$league->id)}}
				{{Form::hidden('match_id',$match->id)}}

				<div class="form-group">
					<label class="league_label">試合への<br>コメント</label>
					<div class="input_area">
						{{Form::textarea('comment',$comment->comment,['class'=>'form-control','rows'=>10])}}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">試合の画像をアップする</label>
					<div class="input_area">
						@if($comment->img!='')
						<img src="/uploads/100/{{$comment->img}}">
						{{Form::hidden('img_del',0)}}
						{{Form::checkbox('img_del',1)}}既存画像を削除する
						@endif
						{{Form::file('img',['class'=>'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">動画のURLを記入する（youtubeなど）</label>
					<div class="input_area">
						{{Form::text('mov',$comment->mov,['class'=>'form-control','placeholder'=>'動画URL'])}}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">ニックネーム</label>
					<div class="input_area">
						{{Form::text('nickname',$comment->nickname,['placeholder'=>'ニックネームを入力','class'=>'form-control'])}}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">パスワード</label>
					<div class="input_area">
						{{Form::text('pass','',['class'=>'form-control'])}}
					</div>
				</div>

				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="submit_area">
						<button type="submit" class="submit_btn">コメントを投稿する</button>
					</div>
				</div>

			{{Form::close()}}
		</div>

		<h3 class="rank_comment_title mb10">このコメントを削除する</h3>
    {{Form::open(['url'=>route('pref.comment.delete',['area'=>$pref->id_areas,'pref'=>$pref->id]),'class'=>'form-horizontal form-label-left'])}}
    {{Form::hidden('id',$comment->id)}}
				<div class="form-group">
					<label class="league_label">パスワード</label>
					<div class="input_area">
						{{Form::text('pass','',['class'=>'form-control'])}}
					</div>
				</div>
		<div class="form-group">
			<div class="submit_area">
				<button type="submit" class="submit_btn">削除する</button>
			</div>
		</div>
		{{Form::close()}}

		<div class="clear mb20"></div>

	</div>

	<div class="mb30">
		<!-- adsense -->
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- 少年サッカー応援団　県別　コンテンツ下　リンクユニット728×15 -->
		<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-3734940028090902"
		data-ad-slot="8002884742"
		data-ad-format="link"></ins>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<!-- adsense end -->
	</div>

	<div class="clear mb30"></div>

	@include('front.parts.pref.sanka')
	<!--スポンサー旧掲載場所-->

</div>
<!-- /#contents-->


<div id="pagetop"><a href="{{$baseUrl}}/#top">PAGETOP</a></div>

@include('front.parts.pref.footer')