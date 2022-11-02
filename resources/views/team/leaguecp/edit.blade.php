@extends('layouts.admin')

@section('css')
<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
@show

@section('js')
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
		$( ".inputCal" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>
@stop

@section('content')
<div class="x_panel">
	<div class="clearfix"></div>
	<ol class="breadcrumb">
		<li><a href="{{route('admin.league.index')}}">大会一覧</a></li>
		<li class="active">{{$league->name}} 情報編集</li>
	</ol>

	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.league.update'),'class'=>"form-horizontal form-label-left"])!!}
		<input type="hidden" name="id" value="{{$league->id}}">

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">年度</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('year',$league->year,['class'=>'form-control','style'=>'width:200px'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">期日</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::select('season',Config::get('app.seasonAry'),$league->season,['class'=>'form-control','style'=>'width:200px'])!!}
			</div>
		</div>

		<?php
		$vpoints = \App\Vpoint::get()->lists('name','id');
		$groups = \App\Groups::get()->lists('name', 'id');
		?>
		{!!Form::selectField('group_id','グループ',$groups, Input::old('group_id'),['style'=>'width:200px'])!!}

		<!-- {!!Form::selectField('v_point_settings_id','勝ち点方式',$vpoints,$league->v_point_settings_id,['style'=>'width:200px'])!!} -->

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">リーグ戦名称</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('name',$league->name,['placeholder'=>'リーグ戦名称を入力','class'=>'form-control'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">リーグの説明</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::textarea('description',$league->description,['class'=>'form-control','rows'=>5])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">参加チーム</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				<?php
				$data = $league->team->lists('team_id')->toArray();
				foreach($teams as $key=>$val):
					?>
					<label class='checkbox-inline'>
						{!!Form::checkbox('teams[]', $key, (array_search($key,$data)!==false)?1:0, ['class' => 'field', 'disabled'=>'disabled'])!!} {!!print($val)!!}
					</label>
					<?php
				endforeach;
				?>
			</div>
		</div>

		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</div>

	{!!Form::close()!!}
	</div>
</div>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

<script src="/css/summernote-ja-JP.js"></script>
<script>
	$(document).ready(function() {
		$('.summernote').summernote({
    lang: 'ja-JP' // default: 'en-US'
});
	});
</script>
@stop