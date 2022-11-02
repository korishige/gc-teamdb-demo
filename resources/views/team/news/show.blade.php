@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/news.css" rel="stylesheet" type="text/css" />
@stop

@section('overlay')
    <div class="content_title">
        <div class="inner">
            <h1>
                <span>お知らせ</span>
                <span>NEWS</span>
            </h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
@stop

@section('content')
<article>
  <section>
    <div id="news_detail">
      <div class="inner">

        <h2>{{$obj->title}}</h2>

        <div class="date">
          配信日：{{date('Y年m月d日',strtotime($obj->dis_dt))}}
        </div><!-- /.date -->

        <div class="content">
          {!! nl2br($obj->body) !!}
        </div><!-- /.content -->

        <div class="btn">
          <a href="{{route('team.news.index')}}">一覧へ戻る</a>
        </div><!-- /.btn -->

      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop