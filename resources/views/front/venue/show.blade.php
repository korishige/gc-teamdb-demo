<?php
$page_title = $venue->name .' | 会場情報 ｜ '.env('title');
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/stadium.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>About</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.venue.index')}}">会場情報</a></span>
    </div><!-- /.bc -->

    <main class="content">
       
        <div class="content_stitle">
            <div class="inner">
                <h2>会場情報</h2>
            </div><!-- /.inner -->
        </div><!-- /.content_stitle -->
        
        <div class="inner">
        <div class="main">

        <article>
            <section>
            
                <div id="stadium_detail">
                    <div class="inner">

                        <h2>{{$venue->name}}</h2>

                        <div class="img">
                            @if(empty($venue->img))
                            <img src="/img/common/dammy_img_stadium.png">
                            @else
                            <img src="/upload/original/{{$venue->img}}">
                            @endif
                            <!-- <img src="/img/common/dammy_img_stadium.png"> -->
                        </div><!-- /.img -->
                        
                        <div class="row">
                            <div class="col">
                               
                                <h3>住所</h3>
                                <div class="txt">
                                    @if(!empty($venue->zip))〒{{$venue->zip}}@endif {{array_get(Config::get('app.prefAry'),$venue->pref_id)}} {{$venue->add1}}{{$venue->add2}}
                                </div><!-- /.txt -->
                                <h3>電話</h3>
                                <div class="txt">
                                    TEL {{$venue->tel}}
                                </div><!-- /.txt -->
                                <h3>施設URL</h3>
                                <div class="txt">
                                    <a href="{{$venue->url}}" target="_blank" rel="noopener">施設の情報はこちら</a>
                                </div><!-- /.txt -->
                                <h3>駐車場</h3>
                                <div class="txt">
                                    {{$venue->parking}}
                                </div><!-- /.txt -->
                                
                            </div><!-- /.col -->
                            <div class="col">
                                <div class="map">
                                    <iframe src="https://maps.google.co.jp/maps?output=embed&q={{$venue->add1}}{{$venue->add2}}&z=16" width="600" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                </div><!-- /.map -->
                                <h3>アクセス方法</h3>
                                <div class="txt">
                                {!!nl2br($venue->access)!!}
                                </div><!-- /.txt -->
                            </div><!-- /.col -->
                            
                            <div class="col other">
                                <h3>マッチレポート</h3>
                                <div class="txt">
                                    {!!nl2br($venue->note)!!}
                                </div><!-- /.txt -->
                            </div><!-- /.col .other -->
                        </div><!-- /.row -->
                        
                        <div class="pageprev">
                            <a href="{{route('front.venue.index')}}">
                                ページ一覧へ戻る
                            </a>
                        </div><!-- /.pageprev -->

                    </div><!-- /.inner -->
                </div>
            
            </section>
        </article>
        
        </div><!-- /.main -->

    @include('front.parts.side')
  
  </div><!-- /.inner -->
  </main>
@stop

