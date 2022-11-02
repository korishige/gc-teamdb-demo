@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/team.css" rel="stylesheet" type="text/css" />
@stop

@section('overlay')
    <div class="content_title">
        <div class="inner">
            <h1>
                <span>チーム情報</span>
                <span>TEAM INFORMATION</span>
            </h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')
<article>

    <section>
        <div id="team">
            <div class="inner">
                <div id="create">

                    <div class="box">

		{!!Form::open(['files'=>true,'url'=>route('team.info.update'),'class'=>"form-horizontal form-label-left"])!!}
		<input type="hidden" name="id" value="{{$team->id}}">

		<?php
		$groups = \App\Groups::get()->lists('name', 'id');
		?>
		<h2>所属リーグ</h2>
		{!!array_get($groups, $team->group_id)!!}

		<h2>チーム名</h2>
		{!!$team->name!!}

		<h2>設立年</h2>
		西暦{{$team->year}}年

		<h2>所在地</h2>
		{{array_get(config('app.prefAry'),$team->pref_id).$team->add1.$team->add2}}

		<h2>電話番号</h2>
		{{$team->tel}}

		<h2>エンブレム画像</h2>
		@if($team->emblem_img!='')
		<img src="/upload/300_crop/{{$team->emblem_img}}">
		@endif

		<h2>集合写真（カメラ横向き撮影）</h2>
		@if($team->group_img!='')
		<img src="/upload/300/{{$team->group_img}}">
		@endif

        <h2>チームの監督</h2>
        {{$team->manager}}
        
        <h2>チームコーチ</h2>
        {{$team->coach}}

        <h2>ユニフォーム色</h2>
        
        <div class="uniform">
          
            <div class="head">
                <span>シャツ</span>
                <span>ショーツ</span>
                <span>ソックス</span>
            </div><!-- /.head -->
           
            <div class="col">
                <h3>FP(正)</h3>
                <span>{{$team->fp_pri_shirt}}</span>
                <span>{{$team->fp_pri_shorts}}</span>
                <span>{{$team->fp_pri_socks}}</span>
            </div><!-- /.col -->
            
            <div class="col">
                <h3>FP(副)</h3>
                <span>{{$team->fp_sub_shirt}}</span>
                <span>{{$team->fp_sub_shorts}}</span>
                <span>{{$team->fp_sub_socks}}</span>
            </div><!-- /.col -->
            
            <div class="col">
                <h3>GK(正)</h3>
                <span>{{$team->gk_pri_shirt}}</span>
                <span>{{$team->gk_pri_shorts}}</span>
                <span>{{$team->gk_pri_socks}}</span>
            </div><!-- /.col -->
            
            <div class="col">
                <h3>GK(副)</h3>
                <span>{{$team->gk_sub_shirt}}</span>
                <span>{{$team->gk_sub_shorts}}</span>
                <span>{{$team->gk_sub_socks}}</span>
            </div><!-- /.col -->

        </div><!-- /.uniform -->

        <h2>指導方針や目標</h2>
        {!!nl2br($team->policy)!!}
        
        <h2>過去の主な実績</h2>
        {!!nl2br($team->record)!!}
        
        <h2>学校ホームページ　URL</h2>
        {{$team->url_school}}
        
        <h2>チームホームページ　URL</h2>
        {{$team->url_team}}

        <h2>ブログ　URL</h2>
        {{$team->url_blog}}
        
        <h2>Facebook　URL</h2>
        {{$team->url_facebook}}
        
        <h2>Twitter　URL</h2>
        {{$team->url_twitter}}

        <h2>Instagram　URL</h2>
        {{$team->url_instagram}}

		<div class="ln_solid"></div>
        <div class="btn_reg">
            <input type="button" value="戻る" onclick="javascript:history.back();">
            <input type="submit" value="登録">
        </div><!-- /.btn_reg -->

		{!!Form::close()!!}
	</div>
</div>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
@stop