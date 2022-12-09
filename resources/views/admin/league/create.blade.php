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
@include('layouts.parts.error')
<div class="x_panel">
	<ol class="breadcrumb">
		<li><a href="{{route('admin.league.index')}}">大会一覧</a></li>
		<li class="active">大会作成</li>
	</ol>

	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.league.store'),'class'=>"form-horizontal form-label-left"])!!}

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">大会</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::select('convention',Config::get('app.conventionAry'),Input::old('convention'),['class'=>'form-control','style'=>'width:200px'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">年度</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('year',Input::old('year')?Input::old('year'):config('app.nendo_backend'),['class'=>'form-control','style'=>'width:200px'])!!}
				<span style="color:red">基本参加チーム選択が本年度({{date('Y')}}年)のものと紐づく様になっているので、2020と入力しても参加チームの割当グループは2020年のものにはならないので気をつけてください。</span>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">期日</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
			{!!Form::select('season',Config::get('app.seasonAry'),Input::has('season')?Input::get('season'):'u15',['class'=>'form-control'])!!}
			</div>
		</div>

		<?php
		$vpoints = \App\Vpoint::get()->lists('name','id');
		$groups = \App\Groups::where('id', '<>', 28)->get()->lists('name', 'id');
		foreach ($groups as $key => $group) {
			$g = \App\Groups::find($key);
			$gs[$key] = $group . '(' . config('app.conventionAry')[$g->convention] . ')';
		}
		?>
		{!!Form::selectField('group_id','グループ',$gs, Input::old('group_id'),['style'=>'width:200px'])!!}

		<!-- {!!Form::selectField('v_point_settings_id','勝ち点方式',$vpoints,old('v_point_settings_id',['style'=>'width:200px']))!!} -->

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">都道府県</label>
			<div class="col-md-10 col-sm-10 col-xs-12">			
				<?php
				$data = old('prefs')?old('prefs'):[];
				foreach($prefs as $key=>$val):
				?>
				<label class='checkbox-inline'>
				{!!Form::checkbox('prefs[]',  $key.":".$val, (array_search($key,$data)!==false)?1:0, ['class'=>'field'])!!}{!!$val!!}
				</label>
				<?php
				endforeach;
				?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">リーグ戦名称</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('name',Input::old('name'),['placeholder'=>'リーグ戦名称を入力','class'=>'form-control'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">リーグの説明</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::textarea('description',Input::old('description'),['class'=>'form-control','rows'=>5])!!}
			</div>
		</div>

		{{--
		{!!Form::cbinline('teams[]','参加チーム',$teams,old('teams',[]))!!}
		--}}

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">参加チーム</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{{-- <span style="color:red">{{config('app.nendo_backend')}}年度のグループ別に並んでおります</span>s --}}
				<?php
				$data = old('teams')?old('teams'):[];
				$_group = '1部';
				foreach($teams as $key=>$val):
					// $aaa = explode("@", $val);
					// if($_group != $aaa[1]){
					// 	print("<br>");
					// 	$_group = $aaa[1];
					// }
				?>
				<label class='checkbox-inline'>
				{!!Form::checkbox('teams[]', $key.":".$val, (array_search($key,$data)!==false)?1:0, ['class' => 'field'])!!} {!!$val!!}
				</label>
				<?php
				endforeach;
				?>
			</div>
		</div>
<!-- 		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">参加チーム</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				<div class="well well-sm">参加チームは チームA、チームB、チームC、チームD のように記載</div>
				{!!Form::text('team',Input::old('team'),['placeholder'=>'参加チームを入力 「、」 区切り','class'=>'form-control'])!!}
			</div>
		</div>
 -->
		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</div>

		{!!Form::close()!!}
	</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
@stop