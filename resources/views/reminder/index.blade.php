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
        <div id="reminber">
          <h2>パスワード再発行</h2>
          {!!Form::open(['url'=>route('reminder')])!!}
          <input name="email" type="text" placeholder="登録済みのEメールを入力してください" required="" value="{{old('email')}}"/>
          <div class="btn">
            <input type="submit" value="再発行依頼">
          </div><!-- /.btn -->
          {!!Form::close()!!}
        </div><!-- /#register -->
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop