@extends('layouts.plain')

@section('meta')
<meta http-equiv="refresh" content="5;URL={{config('app.url')}}">
@endsection

@section('content')
<div class="">
  <div id="wrapper">
    <div id="login" class="animate form">
      <section class="login_content">
        <h1>アカウント申請受付完了</h1>
        <div>
          入力されたEメールアドレスに認証URLをお送りしました。<br>
          メールに書かれた認証URLにアクセスして、認証完了してくだい
        </div>
        <div class="clearfix"></div>
        <div class="separator">

          <div>
            <p>{{Config::get('app.copy')}} All Rights Reserved.</p>
          </div>
        </div>
      </section>
      <!-- content -->
    </div>
  </div>
</div>
@stop