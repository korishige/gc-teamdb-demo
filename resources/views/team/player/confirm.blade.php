@extends('layouts.team')

@section('content')
@include('layouts.parts.error')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('team.player.index')}}">{{$team->name}} 選手一覧</a></li>
	  <li class="active">選手編集</li>
	</ol>

	<div class="x_content">
		<br>

		{!!Form::open(['url'=>route('team.player.store'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::staticField('name','選手名',$player->name)!!}
			{{-- {!!Form::staticField('is_block','ブロック選手',array_get(config('app.is_block'), $player->is_block))!!} --}}
			{!!Form::staticField('school_year','学年',array_get(config('app.schoolYearAry'),$player->school_year))!!}
			{!!Form::staticField('birthday','生年月日',$player->birthday)!!}
			{!!Form::staticField('position','ポジション',array_get(config('app.positionAry'), $player->position))!!}
			{!!Form::staticField('birthplace','出身地',array_get(config('app.prefAry')+[99=>'その他'],$player->birthplace))!!}
			{!!Form::staticField('related_team','出身チーム',$player->related_team)!!}
			{!!Form::staticField('pivot','利き足',array_get(config('app.pivotAry'), $player->pivot))!!}

			{!!Form::staticField('height','身長', $player->height,[],'cm')!!}
			{!!Form::staticField('weight','体重', $player->weight,[],'kg')!!}
			{!!Form::staticField('goal','今年の目標',$player->goal)!!}


			<div class="form-group">
				<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">選手写真</label>
				<div class="col-md-10 col-sm-10 col-xs-12">
					@if(isset($player->img) && $player->img!='')
					<img src="/upload/100/{{$player->img}}">
					@endif
				</div>
			</div>

			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-2">
					<a class="btn btn-info" href="javascript:history.back();">戻る</a>
					<button type="submit" class="btn btn-success">保存</button>
				</div>
			</div>

		{!!Form::close()!!}
	</div>
</div>
@stop