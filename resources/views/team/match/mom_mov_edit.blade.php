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
      <span>MOMコメント動画投稿</span>
      <span>MOM MOVIE POST</span>
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
      {!!Form::open(['files'=>true,'url'=>route('team.match.mom_mov.update'),'class'=>"form-horizontal form-label-left"])!!}
      {!!Form::hidden('id',$match->id)!!}
        <div id="gallery">
          <div class="col">
            @if($match->mom_mov)
              <div style="width: 50%; margin: 0 auto;">
                <video controls playsinline width="100%" height="300" style="background: black;" src="/upload/movie/{{$match->mom_mov}}"></video>
              </div>
              
              <div  style="width: 100%; padding-top: 15px;">
                <input type="checkbox" value="1" name="mom_mov_delete" id="mov_del">
                <label for="mov_del">動画削除する場合はチェックを入れて保存してください</label>
              </div>
            @else
              {!!Form::file('mom_mov')!!}
            @endif
          </div><!-- /.col -->
        </div>
        <div class="btn_reg">
          <input type="button" value="戻る" onclick="javascript:history.back();">
          <input type="submit" value="保存">
        </div><!-- /.btn_reg -->
        {!!Form::close()!!}
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop
