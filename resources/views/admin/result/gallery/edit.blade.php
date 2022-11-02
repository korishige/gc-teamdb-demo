@extends('layouts.admin')

@section('content')
@include('layouts.parts.error')

<div class="x_panel">
    <ol class="breadcrumb">
        <li>{{$match->leagueOne->name}} </li>
        <li>第{{$match->section}}節 {{$match->match_date.' '.$match->match_time}}開始 {{array_get($teamObj,$match->home_id)}} vs {{array_get($teamObj,$match->away_id)}}</li>
        <li class="active">ギャラリー編集</li>
    </ol>

	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.result.gallery.update'),'class'=>"form-horizontal form-label-left"])!!}
		{!!Form::hidden('id',$match->id)!!}

    <?php
    // var_dump($photos);
    ?>
    @for($i=0;$i<100;$i++)
      <div class="form-group">
        <label for="id-field-name" class="control-label col-md-2 col-sm-12 col-xs-12">写真<?php printf("%3d",$i+1);?></label>
        <div class="col-md-10 col-sm-12 col-xs-12">
          @if(array_key_exists($i, $photos))
          <img src="/upload/100/{{$photos[$i]}}">
          <?php
          $_tmp = sprintf("img_delete[%d]",$i);
          ?>
          <input type="checkbox" value="1" name="{{$_tmp}}">写真削除
          @endif
          {!!Form::file("gallery[".$i."]")!!}
        </div>
      </div>
    @endfor

		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</div>

		{!!Form::close()!!}
	</div>
</div>
@stop