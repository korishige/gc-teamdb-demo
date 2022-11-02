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
<link href="/css/results.css?d=20210327" rel="stylesheet" type="text/css" />
@endsection

@section('js')
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
	<script>
		$(function () {
			$('.group3_first').on('click', () => {
				// $('#group31').show();
				// $('#group32').hide();
				$('#g31_on').attr('class', 'on');
				$('#g32_on').attr('class', '');
				// $(".fp3").show()
				// $(".sp3").hide()
			});
			$('.group3_second').on('click', () => {
				// $('#group32').show();
				// $('#group31').hide();
				$('#g32_on').attr('class', 'on');
				$('#g31_on').attr('class', '');
				// $(".sp3").show()
				// $(".fp3").hide()
			});
		});
	</script>
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
			<ul>
				@foreach($groups as $g)
					<li class="{{($group->id == $g->id)?'on':''}}"><a href="{{route('front.result.index',['groups'=>$g->id])}}">{{ $g->name }}</a></li>
					{{-- <li{{$_on[2]}}><a href="{{route('front.result.index',['groups_id'=>3])}}">関西</a></li> --}}
					{{-- <li{{$_on[3]}}><a href="{{route('front.result.index',['groups'=>3])}}">3部</a></li> --}}
				@endforeach
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.league_type -->

	<div class="inner">
		<div class="main">

			{{-- @if($groups_id==2)
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
			@elseif($groups_id==3) --}}

			<div class="period_list">
				<div class="inner">
					<ul>
							<li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.result.index',['groups_id'=>$group->id,'period'=>'first'])}}">1st stage</a></li>
							<li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.result.index',['groups_id'=>$group->id,'period'=>'second'])}}">2nd stage</a></li>
					</ul>
				</div><!-- /.inner -->
			</div><!-- /.period_list --><br><br>

			{{-- @if($groups_id==1)
				<div class="period_list">
					<div class="inner">
						<ul>
							<li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.result.index',['groups_id'=>1,'period'=>'first'])}}">1st stage</a></li>
							<li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.result.index',['groups_id'=>1,'period'=>'second'])}}">2nd stage</a></li>
						</ul>
					</div><!-- /.inner -->
				</div><!-- /.period_list --><br><br>
			@else
				<div class="period_list">
					<div class="inner">
						<ul>
							<li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.result.index',['groups_id'=>3,'period'=>'first'])}}">1st stage</a></li>
							<li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.result.index',['groups_id'=>3,'period'=>'second'])}}">2nd stage</a></li>
						</ul>
					</div><!-- /.inner -->
				</div><!-- /.period_list --><br><br>
			@endif --}}

			{{-- @if($period=='first')
			<div class="part_list" id="group31">
				<div class="inner">
					<ul> --}}
						{{-- TODO:ここに、３部の場合の前期・後期の表示変更も対応する必要あり--}}
						{{-- <li{{$_on2[4]}}><a href="{{route('front.result.group',['group_id'=>4])}}">3部A</a></li>
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
			</div>
			@else
			<div class="part_list" id="group32">
				<div class="inner">
					<ul> --}}
						{{-- TODO:ここに、３部の場合の前期・後期の表示変更も対応する必要あり--}}
						{{-- <li{{$_on2[13]}}><a href="{{route('front.result.group',['group_id'=>13])}}">上位A</a></li>
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
			</div>
      @endif

			@endif --}}


			<article>
				<section>

					<div id="results">
						<div class="inner">
							@forelse($leagues as $league)
								@if(config('app.nendo')!=2020 and ($league->group_id == 26 or $league->group_id == 27))
									<?php continue; ?>
								@endif
								<?php
									if($league->group->grouping==1){
										$group_tag = '1';
									}elseif($league->group->grouping==2){
										$group_tag = '2';
									}else{
										$group_tag = '3';
									}
								?>

							<div class="league_info">

								<div class="col">
									<div class="head">
										<h2>{{$league->name}}リーグ情報</h2>
										<div class="btn">
											<ul>
												<li><a href="{{route('front.result.index',['groups'=>$groups_id])}}">結果速報</a></li>
												<li><a href="{{route('front.schedule.index',['groups'=>$groups_id])}}">日　程</a></li>
												<li><a href="{{route('front.table.groups',['groups'=>$groups_id])}}">星取表</a></li>
												<li><a href="{{route('front.team.index')}}#{{$group_tag}}">参加チーム</a></li>
												<li><a href="{{route('front.gallery.index',['group'=>$groups_id])}}">フォトギャラリー</a></li>
											</ul>
										</div><!-- /.btn -->
									</div><!-- /.head -->
									<div class="row">
										@foreach($matches[$league->id] as $match)
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
										{!!$matches[$league->id]->appends(Input::except('page'))->render()!!}
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

