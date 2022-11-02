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
        <h2>登録完了</h2>
        <div class="txt">
          仮登録が完了しました。<br>
          登録したメールアドレスに認証メールが届きますので、認証を行ってご利用ください。<br><br>

          <a href="{{route('login')}}">ログインページに戻る</a>
        </div><!-- /.txt -->
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop

