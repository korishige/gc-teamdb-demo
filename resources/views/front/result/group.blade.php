<?php
// 1部 リーグ情報｜高円宮杯 JFA U-18 サッカーリーグ 福岡｜2020
$nendo = date('Y', strtotime('-3 month'));
if(Input::has('page')){
	$page_title = Input::get('page') .'ページ | 結果速報 ｜ '.env('title').' | '.$nendo;
}else{
	$page_title = '結果速報 ｜ '.env('title').' | '.$nendo;
}
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/results.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
<div class="content_title">
	<div class="inner">
		<h1>結果速報</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->

<div class="bc">
	<span><a href="{{route('front.index')}}">TOP</a></span>
	<span><a href="{{route('front.result.index')}}">結果速報</a></span>
</div><!-- /.bc -->

<main class="content">

	<div class="league_list">
		<div class="inner">
			<?php
			$_on = [];
			foreach([1,2,3] as $k){
				if($k==$groups){
					$_on[$k] = ' class=on';
				}else{
					$_on[$k] = '';
				}
			}
            $_on2 = [];
            foreach(range(2,29) as $k){
                if($k==$group_id){
                    $_on2[$k] = ' class=on';
                }else{
                    $_on2[$k] = '';
                }
            }
			?>
			<ul>
				<li{{$_on[1]}}><a href="{{route('front.result.index',['groups'=>1])}}">九州</a></li>
				<li{{$_on[2]}}><a href="{{route('front.result.index',['groups'=>2])}}">関西</a></li>
				{{-- <li{{$_on[3]}}><a href="{{route('front.result.index',['groups'=>3])}}">3部</a></li> --}}
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.league_type -->

	<div class="inner">
		<div class="main">

			{{-- @if($groups==2)
			<div class="part_list">
				<div class="inner">
					<ul>
						<li{{$_on2[2]}}><a href="{{route('front.result.group',['group_id'=>2])}}">2部A</a></li>
						<li{{$_on2[3]}}><a href="{{route('front.result.group',['group_id'=>3])}}">2部B</a></li>
						@if(config('app.nendo')==2020)
						<li{{$_on2[26]}}><a href="{{route('front.result.group',['group_id'=>26])}}">2部C</a></li>
						<li{{$_on2[27]}}><a href="{{route('front.result.group',['group_id'=>27])}}">2部D</a></li>
						@endif
					</ul>
				</div><!-- /.inner -->
			</div>
			@elseif($groups==3) --}}
			@if($period=='first')
			{{-- <div class="part_list">
				<div class="inner">
					<ul>
						<li{{$_on2[4]}}><a href="{{route('front.result.group',['group_id'=>4])}}">3部A</a></li>
						<li{{$_on2[5]}}><a href="{{route('front.result.group',['group_id'=>5])}}">3部B</a></li>
						<li{{$_on2[6]}}><a href="{{route('front.result.group',['group_id'=>6])}}">3部C</a></li>
						<li{{$_on2[7]}}><a href="{{route('front.result.group',['group_id'=>7])}}">3部D</a></li>
						<li{{$_on2[8]}}><a href="{{route('front.result.group',['group_id'=>8])}}">3部E</a></li>
						<li{{$_on2[9]}}><a href="{{route('front.result.group',['group_id'=>9])}}">3部F</a></li>
						<li{{$_on2[10]}}><a href="{{route('front.result.group',['group_id'=>10])}}">3部G</a></li>
						<li{{$_on2[11]}}><a href="{{route('front.result.group',['group_id'=>11])}}">3部H</a></li>
						@if(config('app.nendo')!=2020)
						<li{{$_on2[12]}}><a href="{{route('front.result.group',['group_id'=>12])}}">3部I</a></li>
						@endif
						@if(config('app.nendo')==2022)
							<li{{$_on2[29]}}><a href="{{route('front.result.group',['group_id'=>29])}}">3部J</a></li>
						@endif
					</ul>
				</div><!-- /.inner -->
			</div> --}}
				@else
					{{-- <div class="part_list">
						<div class="inner">
							<ul>
								<li{{$_on2[13]}}><a href="{{route('front.result.group',['group_id'=>13])}}">上位A</a></li>
								<li{{$_on2[14]}}><a href="{{route('front.result.group',['group_id'=>14])}}">上位B</a></li>
								<li{{$_on2[15]}}><a href="{{route('front.result.group',['group_id'=>15])}}">上位C</a></li>
								<li{{$_on2[16]}}><a href="{{route('front.result.group',['group_id'=>16])}}">上位D</a></li>
								<li{{$_on2[17]}}><a href="{{route('front.result.group',['group_id'=>17])}}">上位E</a></li>
								<li{{$_on2[18]}}><a href="{{route('front.result.group',['group_id'=>18])}}">上位F</a></li>
								<li{{$_on2[19]}}><a href="{{route('front.result.group',['group_id'=>19])}}">下位A</a></li>
								<li{{$_on2[20]}}><a href="{{route('front.result.group',['group_id'=>20])}}">下位B</a></li>
								<li{{$_on2[21]}}><a href="{{route('front.result.group',['group_id'=>21])}}">下位C</a></li>
								<li{{$_on2[22]}}><a href="{{route('front.result.group',['group_id'=>22])}}">下位D</a></li>
								<li{{$_on2[23]}}><a href="{{route('front.result.group',['group_id'=>23])}}">下位E</a></li>
								<li{{$_on2[24]}}><a href="{{route('front.result.group',['group_id'=>24])}}">下位F</a></li>
							</ul>
						</div><!-- /.inner -->
					</div> --}}
				@endif
			{{-- @endif --}}


			<article>
				<section>

					<div id="results">
						<div class="inner">
							@forelse($leagues as $league)

							<div class="league_info">

								<div class="col">
									<div class="head">
										<h2>{{$groups}}部リーグ情報</h2>
										<div class="btn">
											<ul>
												<li><a href="{{route('front.result.index',['groups'=>$groups])}}">結果速報</a></li>
												<li><a href="{{route('front.schedule.index',['groups'=>$groups])}}">日　程</a></li>
												<li><a href="{{route('front.order.index',['groups'=>$groups])}}">星取表</a></li>
												<li><a href="{{route('front.team.index')}}">参加チーム</a></li>
												<li><a href="{{route('front.gallery.index',['group'=>$groups])}}">フォトギャラリー</a></li>
											</ul>
										</div><!-- /.btn -->
									</div><!-- /.head -->
									<div class="row">
										@foreach($matches as $match)
										<div class="col">
											<?php
											$class_ = ($match->home_pt == $match->away_pt)?' two':'';
											?>
											<div class="img{{$class_}}">
												<?php
												if(!empty($match->home_photo)){
													$home_img = "/upload/300/".$match->home_photo;
												}elseif(!empty($match->home->team->group_img)){
													$home_img = "/upload/300/".$match->home->team->group_img;
												}else{
													$home_img = "/img/common/dammy_img_league.png";
												}
												if(!empty($match->away_photo)){
													$away_img = "/upload/300/".$match->away_photo;
												}elseif(!empty($match->away->team->group_img)){
													$away_img = "/upload/300/".$match->away->team->group_img;
												}else{
													$away_img = "/img/common/dammy_img_league.png";
												}

												if($match->home_pt > $match->away_pt){
													if(!empty($match->home_photo)){
														$win_img = "/upload/300/".$match->home_photo;
													}elseif(!empty($match->home->team->group_img)){
														$win_img = "/upload/300/".$match->home->team->group_img;
													}else{
														$win_img = "/img/common/dammy_img_league.png";
													}
												}elseif($match->home_pt == $match->away_pt){
													if(!empty($match->home_photo)){
														$home_img = "/upload/300/".$match->home_photo;
													}elseif(!empty($match->home->team->group_img)){
														$home_img = "/upload/300/".$match->home->team->group_img;
													}else{
														$home_img = "/img/common/dammy_img_league.png";
													}
													if(!empty($match->away_photo)){
														$away_img = "/upload/300/".$match->away_photo;
													}elseif(!empty($match->away->team->group_img)){
														$away_img = "/upload/300/".$match->away->team->group_img;
													}else{
														$away_img = "/img/common/dammy_img_league.png";
													}
												}else{
													if(!empty($match->away_photo)){
														$win_img = "/upload/300/".$match->away_photo;
													}elseif(!empty($match->away->team->group_img)){
														$win_img = "/upload/300/".$match->away->team->group_img;
													}else{
														$win_img = "/img/common/dammy_img_league.png";
													}
												}
												?>
												@if($match->home_pt > $match->away_pt)
													<img src="{{$home_img}}">
												@elseif($match->home_pt < $match->away_pt)
													<img src="{{$away_img}}">
												@else
													<span><img src="{{$home_img}}"></span>
													<span><img src="{{$away_img}}"></span>
												@endif
											</div><!-- /.img -->
											<div class="txt">
												@if($match->is_filled)<div class="icon">{{$match->leagueOne->group->name}}試合結果</div>@endif
												<h3>{{date('m/d',strtotime($match->match_date))}} {{$match->home0->name}} {{$match->home_pt}}-{{$match->away_pt}} {{$match->away0->name}}【{{array_get(Config::get('app.seasonAry'),$match->leagueOne->season)}}第{{$match->section or ' - '}}節】</h3>
												{{--<span> {{array_get(Config::get('app.seasonAry'),$match->leagueOne->season)}} {{$match->leagueOne->group->name}} 第{{$match->section}}節 {{date('m/d',strtotime($match->match_date))}}
													（{{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}}）  </span>--}}
												</div><!-- /.txt -->
												<div class="btn">詳細はこちら</div>
												<a href="{{route('front.result.show',['id'=>$match->id])}}"></a>
											</div><!-- /.col -->
											@endforeach
										</div><!-- /.row -->
									</div><!-- /.col -->

									<div class="pager">
										{!!$matches->appends(Input::except('page'))->render()!!}
									</div><!-- /.pager -->

								</div><!-- /.league_info -->

							@empty
							<div class="head">なし</div>
							@endforelse
							</div><!-- /.inner -->
						</div>

					</section>
				</article>

			</div><!-- /.main -->

			@include('front.parts.side')

		</div><!-- /.inner -->
	</main>
	@stop

