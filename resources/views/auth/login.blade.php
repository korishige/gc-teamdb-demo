@extends('layouts.team_plain')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/login.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
@include('layouts.parts.message')
<article>
  <section>
    <div id="login">
      <div class="inner">
        <h2>Green Card Team DB</h2>
        {!! Form::open(['url'=>'/login','method'=>'post'])!!}
          {!!Form::hidden('flag',0)!!}
          <div class="box">
            <div class="team_emb">
              {{-- <img src="/team/img/common/logo.png"> --}}
            </div><!-- /.team_emb -->
            <dl>
              <div>
                <dt>ログイン</dt>
                <dd>
                  <input name="email" type="text" class="form-control" placeholder="E-mail" required="" @if($cookie != null) value="{{$cookie['email']}}" @endif/>
                </dd>
              </div>
              <div>
                <dt>パスワード</dt>
                <dd>
                  <input name="password" type="password" class="form-control" placeholder="Password" required="" @if($cookie != null) value="{{$cookie['password']}}" @endif/>
                </dd>
              </div>
              <dd style="margin: 20px;">
                <input type="checkbox" name='remember' value="1" @if($cookie != null) @if($cookie['remember']==1) checked @endif @endif>ログイン状態を保存する
              </dd>
            </dl>
            <div class="btn">
              <input type="submit" value="ログイン">
            </div><!-- /.btn -->
            {{-- <p>※パスワードを忘れた方は<a href="{{route('reminder')}}">こちら</a></p> --}}
          </div><!-- /.box -->
          <div class="box">
            <div class="btn">
              {{--
              <a href="{{route('register')}}">
                新規登録はこちら
              </a>
              --}}
            </div><!-- /.btn -->
          </div><!-- /.box -->
        {!!Form::close()!!}
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop