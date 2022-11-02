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
        <div id="register">

          <h2>新規登録</h2>

          {!!Form::open(['method'=>'post','files'=>true,'url'=>route('regist.completed'),'class'=>"form-horizontal form-label-left"])!!}
            <div class="box">
              <h2>メールアドレス(ログインID)<span>必須</span></h2>

              {!!Form::text('email',old('email'),[])!!}

              <p>お知らせが配信されますので確実に受け取れるアドレスをご登録ください</p>

              <h2>パスワード<span>必須</span>
              </h2>

              {!!Form::text('password',old('password'),['class'=>'w20'])!!}

              <p>6～15文字</p>

              <h2>所属リーグ<span>必須</span></h2>

              <?php
              $groups = \App\Groups::get()->lists('name', 'id');
              ?>
              {!!Form::select('group_id',$groups, old('group_id'),['class'=>'league'])!!}

              <p>※はじめて参加される組織、チームの場合は、必ず「仮」を選択ください</p>

              <h2>組織名称<span>必須</span></h2>
              <?php
              $orgs = \App\Organizations::get()->lists('name', 'id');
              ?>
              {!!Form::select('organizations_id',$orgs, old('organizations_id'),['class'=>'organization'])!!}
              <p>※組織名が見つからない場合は、チーム追加を中断し、ご連絡ください</p>

              <h2>チーム名<span>必須</span></h2>

              <p>※「県立」「私立」や「高校」「サッカー部」などの記載は省きます。　Ｂチームなどの場合は末尾に必ず入れてください。</p>

              {!!Form::text('name',old('name'),['class'=>50,'placeholder'=>'チーム名をいれてください'])!!}

              <h2>設立年</h2>

              <div class="year_est row">
                <span>西暦</span>
                {!!Form::text('year',old('year'),['class'=>'w20'])!!}
                <span>年</span>
              </div><!-- /.year_est -->

              <h2>所在地<span>必須</span></h2>
              <div class="address">
                <span>都道府県</span>
                {!!Form::select('pref_id',config('app.prefAry'),old('pref_id'),['class'=>'form-control w30'])!!}
              </div><!-- /.address -->
              <div class="address">
                <span>市区町村</span>
                {!!Form::text('add1',old('add1'),['class'=>'w30'])!!}
              </div><!-- /.address -->
              <div class="address">
                <span>以降の住所</span>
                {!!Form::text('add2',old('add2'),['class'=>'w30'])!!}
              </div><!-- /.address -->

              <h2>電話番号<span>必須</span></h2>
              {!!Form::text('tel',old('tel'),['class'=>'w30'])!!}

              <h2>エンブレム画像</h2>
              {!!Form::file('emblem_img')!!}

              <h2>集合写真（カメラ横向き撮影）</h2>
              {!!Form::file('group_img')!!}

              <h2>チームの監督</h2>
              {!!Form::text('manager',old('manager'),['placeholder'=>'監督の名前を入れてください','class'=>'w50'])!!}

              <h2>チームコーチ</h2>
              {!!Form::text('coach',old('coach'),['placeholder'=>'コーチの名前を入れてください','class'=>'w50'])!!}

              <h2>指導方針や目標</h2>
              {!!Form::textarea('policy',old('policy'),['size'=>'30x10'])!!}

              <h2>過去の主な実績</h2>
              {!!Form::textarea('record',old('record'),['size'=>'30x5'])!!}

              <h2>学校ホームページ　URL</h2>
              {!!Form::text('url_school',old('url_school'))!!}

              <h2>チームホームページ　URL</h2>
              {!!Form::text('url_team',old('url_team'))!!}

              <h2>ブログ　URL</h2>
              {!!Form::text('url_blog',old('url_blog'))!!}

              <h2>Facebook　URL</h2>
              {!!Form::text('url_facebook',old('url_facebook'))!!}

              <h2>Twitter　URL</h2>
              {!!Form::text('url_twitter',old('url_twitter'))!!}

              <h2>Instagram　URL</h2>
              {!!Form::text('url_instagram',old('url_instagram'))!!}

            </div><!-- /.box -->

            <div class="btn_reg">
              <input type="button" value="戻る" onclick="javascript:history.back();">
              <input type="submit" value="登録">
            </div><!-- /.btn_reg -->

          {!!Form::close()!!}
        </div><!-- /#register -->
      </div><!-- /.inner -->
    </div>
  </section>
</article>

@stop