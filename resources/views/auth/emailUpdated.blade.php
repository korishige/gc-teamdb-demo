@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/account.css" rel="stylesheet" type="text/css" />
@stop

@section('js')
@stop

@section('overlay')
<div class="content_title">
  <div class="inner">
    <h1>
      <span>アカウント情報</span>
      <span>ACCOUNT INFORMATION</span>
    </h1>
  </div><!-- /.inner -->
</div><!-- /.content_title -->
@stop


@section('content')

@include('layouts.parts.error')
<article>
  <div id="account">
    <div class="inner">
        <h2>変更完了</h2>
        <div class="txt">
          メールアドレス変更が完了しました。<br>
          下記、ログインからサービスをご利用ください。<br><br>

          <a href="{{route('login')}}">ログインページに戻る</a>
        </div><!-- /.txt -->
    </div><!-- /.inner -->
  </div><!-- /#account -->
</article>
@endsection

