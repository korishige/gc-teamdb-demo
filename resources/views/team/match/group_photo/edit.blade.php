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
      <span>集合写真投稿</span>
      <span>GROUP PHOTO POST</span>
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
      {!!Form::open(['files'=>true,'url'=>route('team.match.group_photo.update'),'class'=>"form-horizontal form-label-left"])!!}
      {!!Form::hidden('id',$match->id)!!}
        <div id="gallery">
          <div class="col">
            <h3 style="width: 100%">{{ $match->home0->name }}　写真</h3>
            @if($match->home_photo)
            <img src="/upload/300/{{$match->home_photo}}">
            <input type="checkbox" value="1" name="home_photo_delete">写真削除
            @endif
            {!!Form::file('home_photo')!!}
          </div><!-- /.col -->

          <div class="col">
            <h3 style="width: 100%">{{ $match->away0->name }}　写真</h3>
            @if($match->away_photo)
            <img src="/upload/300/{{$match->away_photo}}">

            <input type="checkbox" value="1" name="away_photo_delete">写真削除
            @endif
            {!!Form::file('away_photo')!!}
          </div><!-- /.col -->
        </div>
        <div class="btn_reg">
          <input type="button" value="戻る" onclick="javascript:history.back();">
          <input type="submit" value="登録">
        </div><!-- /.btn_reg -->
        {!!Form::close()!!}
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop
