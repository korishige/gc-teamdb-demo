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
      <span>ギャラリー</span>
      <span>GALLERY</span>
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
				{!!Form::open(['files'=>true,'url'=>route('team.match.gallery.update'),'class'=>"form-horizontal form-label-left"])!!}
				{!!Form::hidden('id',$match->id)!!}
				<div id="gallery">
					<h3>ファイル選択（複数選択可能）</h3>
					<input type="file" class="form-control" name="gallery[]" multiple>
			    @for($i=0;$i<count($photos);$i++)
					<div class="col">
						<h3>写真<?php printf("%3d",$i+1);?></h3>
		          @if(array_key_exists($i, $photos))
		          <img src="/upload/100/{{$photos[$i]}}">
		          <?php
		          $_tmp = sprintf("img_delete[%d]",$i);
		          ?>
		          <input type="checkbox" value="1" name="{{$_tmp}}">写真削除
		          @endif
					</div><!-- /.col -->
			    @endfor
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
