<?php
$page_title = $news->title .' | お知らせ ｜ '.env('title');
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/news.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>お知らせ</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.news.index')}}">お知らせ</a></span>
    </div><!-- /.bc -->

    <main class="content">
    
    <div class="inner">
        <div class="main">

        <article>
                <div id="news_detail">
                    <div class="inner">

                        <h2>{{$news->title}}</h2>
                        
                        <div class="content">
                            {!!nl2br($news->body)!!}
                        </div><!-- /.content -->
                        
                        
                        <div class="pageprev">
                            <a href="{{route('front.news.index')}}">
                                お知らせ一覧へ戻る
                            </a>
                        </div><!-- /.pageprev -->

                    </div><!-- /.inner -->
                </div>

        </article>

        </div><!-- /.main -->

    @include('front.parts.side')
  
  </div><!-- /.inner -->
  </main>
@stop

