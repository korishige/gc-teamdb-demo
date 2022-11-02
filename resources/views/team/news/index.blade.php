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
    <div id="news">
      <div class="inner">
        <h2>運営からのお知らせ</h2>
        <div class="row">
          @foreach($obj as $news)
          <div class="col row">
            <span>{{date('Y-m-d',strtotime($news->dis_dt))}}</span>
            <h2>{{$news->title}}</h2>
            <a href="{{route('team.news.show',['id'=>$news->id])}}"></a>
          </div><!-- /.col -->
          @endforeach
        </div><!-- /.row -->

        <div class="pager">
          <ul>
            {!! $obj->appends(Input::except('page'))->render(); !!}
            {{--
            <li><a href="" class="prev">&lsaquo; 前のページ</a></li>
            <li><span class="current">1</span></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li><a href="" class="next">前のページ &rsaquo;</a></li>
            --}}
          </ul>
        </div><!-- /.pager -->

      </div><!-- /.inner -->
      
    </div>
  </section>
</article>
@stop