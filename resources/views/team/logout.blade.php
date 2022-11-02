@extends('layouts.team_plain')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/login.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
<article>
  <section>
    <div id="logout">
      <div class="inner">
        <h2>ログアウトしました</h2>
        <div class="txt">
          <a href="{{route('front.index')}}">公開サイトを見る</a>
          <a href="{{route('login')}}">ログイン画面はこちら</a>
        </div><!-- /.txt -->
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop