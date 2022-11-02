@extends('layouts.front',['page_title'=>env('title')])

@section('css')
<link href="/css/index.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/js/swiper.min.js"></script>

<link href="css/slider.css" rel="stylesheet" type="text/css" />

<script>
    var sliderSelector = '.swiper-container',
    options = {
        autoplay:true,
        init: false,
        loop: true,
        speed:800,
        slidesPerView: 2, // or 'auto'
        spaceBetween: 20,
        centeredSlides : true,
        effect: 'coverflow', // 'cube', 'fade', 'coverflow',
        coverflowEffect: {
        rotate: 50, // Slide rotate in degrees
        stretch: 0, // Stretch space between slides (in px)
        depth: 100, // Depth offset in px (slides translate in Z axis)
        modifier: 1, // Effect multipler
        slideShadows : true, // Enables slides shadows
        },
        grabCursor: true,
        parallax: true,
        pagination: {
        el: '.swiper-pagination',
        clickable: true,
        },
        navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        },
        breakpoints: {
        1023: {
          slidesPerView: 1,
          spaceBetween: 0
        }
        },
        // Events
        on: {
        imagesReady: function(){
          this.el.classList.remove('loading');
        }
        }
        };
        var mySwiper = new Swiper(sliderSelector, options);

// Initialize slider
mySwiper.init();
</script>
@endsection

@section('contents')
	<div class="swiper-container">
        <div class="swiper-wrapper">
            <!-- 各スライドここから -->
            <div class="swiper-slide" style="background:url(/img/index/header.png)">
                <div class="bar">
                    <h2>九州</h2>
                    <div class="btn">詳細はこちら</div>
                </div><!-- /.bar -->
                <a href="{{route('front.result.index',['groups'=>1])}}"></a>
            </div>
            {{-- <div class="swiper-slide" style="background:url(/img/index/2bu_top1005-2.jpg)">
                <div class="bar">
                    <h2>2部リーグ情報</h2>
                    <div class="btn">詳細はこちら</div>
                </div><!-- /.bar -->
                <a href="https://fukuoka-fa-u18.com/result/groups/2"></a>
            </div> --}}
            <div class="swiper-slide" style="background:url(/img/index/Boost_logo_2.png)">
                <div class="bar">
                    <h2>関西</h2>
                    <div class="btn">詳細はこちら</div>
                </div><!-- /.bar -->
                <a href="{{route('front.result.index',['groups'=>2])}}"></a>
            </div>
            <!-- 各スライドここまで -->
        </div>

        <!-- ページネーションを表示する場合 -->
        <div class="swiper-pagination"></div>

        <!-- 前後スライドへのナビゲーションボタン(矢印)を表示する場合 -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- スクロールバーを表示する場合 -->
        <!-- <div class="swiper-scrollbar"></div> -->
    </div>

	<main>
	<article>
	
	    <section>
	        <div id="news">
	            <div class="inner">
	                <h2><span>NEWS</span><span>お知らせ</span></h2>
	                
	                <div class="row">
                    	@foreach($newsObj as $news)
	                    <div class="col">
	                        <div class="txt">
                                <span>{{date('Y.m.d',strtotime($news->dis_dt))}}</span>
	                            <h3>{{$news->title}}</h3>
	                        </div><!-- /.txt -->
	                        <a href="{{route('front.news.show',['id'=>$news->id])}}"></a>
	                    </div><!-- /.col -->
	                    @endforeach	                    
	                </div><!-- /.row -->
	                
	                <div class="bottom">
	                    <a href="{{route('front.news.index')}}">一覧はこちら</a>
	                </div><!-- /.bottom -->
	                
	            </div><!-- /.inner -->
	        </div>
	    </section>
	    
	    <section>
	        <div id="league">
                <div class="head">
                    <div class="musk">
                        <h2>
                            <span>LEAGUE</span>
                            <span>結果速報</span>
                        </h2>
                    </div><!-- /.musk -->
                </div><!-- /.head -->
                
                <div class="top">
                    <ul>
											@foreach($groups as $group)
                        <li><a href="{{route('front.result.index',['groups'=>$group->id])}}">{{ $group->name }}</a></li>
                        {{-- <li><a href="{{route('front.result.index',['groups'=>2])}}">関西</a></li> --}}
                        {{-- <li><a href="{{route('front.result.index',['groups'=>3])}}">3部</a></li> --}}
											@endforeach
                    </ul>
                </div><!-- /.top -->
                
	            <div class="inner">
	                
								@foreach($groups as $group)
	                <div class="league_info">
	                    <div class="col">
	                        <div class="head">
	                            <h2><span>{{ $group->kana }}</span>{{ $group->name }}リーグ情報</h2>
	                            <div class="btn">
	                                <ul>
	                                    <li><a href="{{route('front.result.index',['groups'=>$group->id])}}">結果速報</a></li>
	                                    <li><a href="{{route('front.schedule.index',['groups'=>$group->id])}}">日　程</a></li>
	                                    <li><a href="{{route('front.table.groups',['groups_id'=>$group->id])}}">星取表</a></li>
																			<li><a href="{{route('front.ranking.groups',['groups_id'=>$group->id])}}">得点ランキング</a></li>
	                                    <li><a href="{{route('front.team.index')}}#{{ $group->id }}">参加チーム</a></li>
	                                    <li><a href="{{route('front.gallery.index',['groups'=>$group->id])}}">フォトギャラリー</a></li>
	                                </ul>
	                            </div><!-- /.btn -->
	                        </div><!-- /.head -->
	                        <div class="row">
                            	@forelse($matches[$group->id] as $match)
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
										@if($match->is_filled)<div class="icon">九州試合結果</div>@endif
	                                    <h3>
	                                    	{{date('m/d',strtotime($match->match_date))}} {{$match->home0->name}} @if($match->is_filled){{$match->home_pt}}-{{$match->away_pt}}@else vs @endif {{$match->away0->name}}【{{array_get(Config::get('app.seasonAry'),$match->leagueOne->season)}}第{{$match->section or ' - '}}節】
	                                    </h3>
	                                </div><!-- /.txt -->
	                                <div class="btn">詳細はこちら</div>
	                                <a href="{{route('front.result.show',['id'=>$match->id])}}"></a>
	                            </div><!-- /.col -->
                                @empty
                                <div style="width: 100%; background: #fff; position: relative; padding: 15px;overflow: hidden;"> まだ公開されている試合結果が有りません </div>
                                @endforelse
	                        </div><!-- /.row -->
	                    </div><!-- /.col -->
	                    
	                    <div class="bottom">
	                        <a href="{{route('front.result.index',['groups'=>$group->id])}}">一覧はこちら</a>
	                    </div><!-- /.btn -->
	                    
	                </div><!-- /.league_info -->
								@endforeach
	                
	            </div><!-- /.inner -->
	        </div>
	    </section>
	    
	    <section>
	        <div id="other">
	            <div class="inner">
	                
                    <div class="col">
                        <img src="/img/index/other_stadium2.png">
                        <div class="btn">
                            会場一覧
                        </div><!-- /.btn -->
                        <a href="{{route('front.venue.index')}}"></a>
                    </div><!-- /.col -->
                    
                    <div class="col">
                        <img src="/img/index/other_schedule.png">
                        <div class="btn">
                            大会日程
                        </div><!-- /.btn -->
                        <a href="{{route('front.schedule.index')}}"></a>
                    </div><!-- /.col -->
                    
                    <div class="col">
                        <img src="/img/index/other_outline.png">
                        <div class="btn">
                            大会概要
                        </div><!-- /.btn -->
                        <a href="{{route('front.abstract')}}"></a>
                    </div><!-- /.col -->
                    
                    {{-- <div class="col">
                        <img src="/img/index/other_pastgame.png">
                        <div class="btn">
                            過去の大会結果
                        </div><!-- /.btn -->
                        <a href="https://www.juniorsoccer-news.com/post-577401"></a>
                    </div><!-- /.col --> --}}
                    
                    <div class="col">
                        <img src="/img/index/other_team.png">
                        <div class="btn">
                            チーム紹介
                        </div><!-- /.btn -->
                        <a href="{{route('front.team.index')}}"></a>
                    </div><!-- /.col -->
                    
                    <div class="col">
                        <img src="/img/index/other_live.png">
                        <div class="btn">
                            LIVE配信
                        </div><!-- /.btn -->
                        <a href="{{route('front.live')}}"></a>
                    </div><!-- /.col -->
	                
	            </div><!-- /.inner -->
	        </div>
	    </section>
	
	</article>
	</main>

	<aside>
		<div class="inner">
			<div class="col league_info">
				<h2>リーグ情報</h2>
			    <ul>
						@foreach($groups as $group)
							<li><a style="color:#fff; text-decoration:none;" href="{{route('front.result.index',['groups'=>$group->id])}}">{{ $group->name }}リーグ情報</a></li>
						@endforeach
			    </ul>
			</div><!-- /.league_info -->
			<div class="col related_info">
				<h2>関連情報</h2>
				<ul>
					<li>
						<span>
							<a href="https://www.bluewave2015.com/"><img src="/img/common/bar_blue_wave.jpeg"></a>
						</span>
						BlueWave sports concierge office
					</li>
          <li>
						<span>
							<a href="http://www.green-card.co.jp/"><img src="/img/common/bar-greencard.png"></a>
						</span>
						株式会社グリーンカード
					</li>
					<li></li>
				</ul>
			</div><!-- /.related_info -->

		</div>
	</aside>
@endsection

