<?php
// 1部 リーグ情報｜高円宮杯 JFA U-18 サッカーリーグ 福岡｜2020
if(Input::has('page')){
    $page_title = Input::get('page') .'ページ | フォトギャラリー ｜ '.env('title').' | '.date('Y', strtotime('-3 month'));
}else{
    $page_title = 'フォトギャラリー ｜ '.env('title').' | '.date('Y', strtotime('-3 month'));
}
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/gallery.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>ギャラリー</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.gallery.index')}}">ギャラリー</a></span>
    </div><!-- /.bc -->

    <div class="year_list">
        <div class="inner">
            <ul>
                @for($year=(date('md')>='0320')?date('Y'):date('Y')-1; $year>=2022; $year--)
                    <li class="{{($yyyy==$year)?'on':''}}"><a href="{{route('front.gallery.index',['groups_id'=>$groups_id,'yyyy'=>$year])}}">{{$year}}年</a></li>
                @endfor
            </ul>
        </div><!-- /.inner -->
    </div><!-- /.year_list -->

    <div class="league_list">
        <div class="inner">
            <ul>
                @foreach($groups as $group)
					<li {{($groups_id==$group->id)?'class=on':''}}><a href="{{route('front.gallery.index',['groups_id'=>$group->id])}}">{{ $group->name }}</a></li>
				@endforeach
            </ul>

        </div><!-- /.inner -->
    </div><!-- /.league_type -->

    <main class="content">
    
    <div class="inner">
        <div class="main">

        <article>
                <div id="gallery">
                    <div class="inner">

                        @forelse($matches as $match)
                        <div class="col">
                            <h2>{{date('m/d',strtotime($match->match_date))}} {{$match->home0->name}} {{$match->home_pt}}-{{$match->away_pt}} {{$match->away0->name}}
                                【{{array_get(Config::get('app.seasonAry'),$match->leagueOne->season)}}第{{$match->section or ' - '}}節】</h2>
                            <div class="img">
                                @foreach($match->photo1 as $photo)
                                <a href="/upload/original/{{$photo->img}}" data-lightbox="a"><img src="/upload/300/{{$photo->img}}"></a>
                                @endforeach
                            </div><!-- /.img -->
                            <div class="btn">
                                <a href="{{route('front.result.show',['id'=>$match->id,'yyyy'=>$yyyy])}}">試合結果はこちら</a>
                            </div><!-- /.btn -->
                        </div><!-- /.col -->
                        @empty
                        登録がありません
                        @endforelse
                        
                        <div class="pager">
                            {!!$matches->appends(Input::except('page'))->render()!!}
                        </div><!-- /.pager -->
                        
                   
                    </div><!-- /.inner -->
                </div>

        </article>

        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

