@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/account.css" rel="stylesheet" type="text/css" />
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
            <dl>
                <div>
                    <dt>
                        チーム名
                    </dt>
                    <dd>
                        {{$team->name}}
                    </dd>
                </div>
                <div>
                    <dt>
                        現在の登録メールアドレス
                    </dt>
                    <dd>
                        {{$user->email}}
                    </dd>
                </div>
                {!!Form::open(['method'=>'post','class'=>'form-horizontal form-label-left','url'=>route('team.email.update')])!!}
                <div>
                    <dt>
                        メールアドレス変更
                    </dt>
                    <dd>
                        {!!Form::text('email_new','',['class'=>'form-control col-md-10 col-sm-12 col-xs-12'])!!}
                    </dd>
                </div>
                <div class="txt">
                    <div class="col">
                        新メールアドレスを入力後、メールアドレス変更を押すと、管理画面からログアウトしたあと、新メールアドレスにメールアドレス確認のメールが届きます。メール内に承認リンクがありますので、問題なければ承認してください。
                    </div><!-- /.col -->
                    <div class="col">
                        <button type="submit" class="btn btn-primary">メールアドレス変更</button>
                    </div><!-- /.col -->
                </div><!-- /.txt -->
                {!!Form::close()!!}

                {!!Form::open(['method'=>'post','class'=>'form-horizontal form-label-left','url'=>route('team.password.update')])!!}
                <div>
                    <dt>
                        パスワード変更
                    </dt>
                    <dd>
                        <div class="col">
                            <span>現在のパスワード</span>
                            {!!Form::text('password','',['placeholder'=>'パスワード変更の際に現在のパスワードを入力してください','class'=>'w30'])!!}
                        </div><!-- /.col -->
                        <div class="col">
                            <span>新パスワード 6～15文字</span>
                            {!!Form::text('password_new','',['placeholder'=>'パスワード変更の際に新しいパスワードを入力','class'=>'w30'])!!}
                        </div><!-- /.col -->
                        <div class="col">
                            <span>新パスワード確認用 6～15文字</span>
                            {!!Form::text('password_new2','',['placeholder'=>'上記の新パスワードと同じものを入力','class'=>'w30'])!!}
                        </div><!-- /.col -->
                        <div class="ln_solid"></div>
                    </dd>
                </div>
                <div class="txt">
                    <div class="col">
                        パスワード変更の際は、現在のパスワードを入力し、新パスワード、新パスワード確認用に同じパスワードを入力し、パスワード変更ボタンを押してください。
                    </div><!-- /.col -->
                    <div class="col">
                        <button type="submit" class="btn btn-primary">パスワード変更</button>
                    </div><!-- /.col -->
                </div><!-- /.txt -->
                {!!Form::close()!!}
            </dl>
        </div><!-- /.inner -->
    </div><!-- /#account -->

</article>
@stop