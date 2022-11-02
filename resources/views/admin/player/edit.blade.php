@extends('layouts.admin')

@section('css')
<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
@show

@section('js')
<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
		$( ".inputCal" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>
@stop

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.team.index')}}">チーム一覧</a></li>
	  <li><a href="{{route('admin.team.player.index',['id'=>$player->team_id])}}">{{$player->team->name}} 選手管理</a></li>
	  <li class="active">選手編集</li>
	</ol>

	<div class="x_title">
		<h2>選手編集</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.team.player.update'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::hidden('id',$player->id)!!}

			{!!Form::textField('suspension_at','出場停止期間',$player->suspension_at,['style'=>'width:300px'])!!}

			{!!Form::textField('name','選手名',$player->name,['style'=>'width:300px'])!!}
			{!!Form::selectField('school_year','学年',range(1,3),$player->school_year,['style'=>'width:80px'])!!}
			{!!Form::textField('birthday','生年月日',$player->birthday,['style'=>'width:100px','class'=>'form-control inputCal'])!!}
			{!!Form::rbinline('position','ポジション',config('app.positionAry'), $player->position,['style'=>'width:300px'])!!}
			{!!Form::selectField('birthplace','出身地',config('app.prefAry')+[99=>'その他'],$player->birthplace,['style'=>'width:80px'])!!}
			{!!Form::textField('related_team','出身チーム',$player->related_team)!!}
			{!!Form::rbinline('pivot','利き足',config('app.pivotAry'), $player->pivot,['style'=>'width:300px'])!!}

			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">身長</label>
				<div class="col-md-1 col-sm-1 col-xs-12">
					<div class="input-group">
						{!!Form::text('height',$player->height,['class'=>'form-control col-sm-1'])!!}
						<span class="input-group-addon">cm</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">体重</label>
				<div class="col-md-1 col-sm-1 col-xs-12">
					<div class="input-group">
						{!!Form::text('weight',$player->weight,['class'=>'form-control col-sm-1'])!!}
						<span class="input-group-addon">kg</span>
					</div>
				</div>
			</div>

			{!!Form::textField('goal','今年の目標',$player->goal)!!}


			<div class="form-group">
				<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">選手写真</label>
				<div class="col-sm-10">
					@if($player->img)
					<img src="/upload/100/{{$player->img}}">
					<input type="checkbox" value="1" name="img_delete">写真削除
					@endif
					{!!Form::file('img')!!}
				</div>
			</div>

			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-2">
					<button type="submit" class="btn btn-success">保存</button>
				</div>
			</div>

		{!!Form::close()!!}
	</div>
</div>
@stop