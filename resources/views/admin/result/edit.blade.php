@extends('layouts.admin')

@section('content')
@include('layouts.parts.error')

<div class="x_panel">
		<ol class="breadcrumb">
				<li>{{$match->leagueOne->name}} </li>
				<li>第{{$match->section}}節 {{$match->match_date.' '.$match->match_time}}開始 {{array_get($teams,$match->home_id)}} vs {{array_get($teams,$match->away_id)}}</li>
				<li class="active">結果入力</li>
		</ol>

	<div class="x_content">
		{!!Form::open(['url'=>route('admin.result.update'),'class'=>"form-horizontal form-label-left"])!!}
			{!!Form::hidden('id',$match->id)!!}

			{!!Form::rbinline('is_filled','結果入力状況',config('app.is_filled'),$match->is_filled)!!}
			{!!Form::rbinline('is_publish','公開状況',config('app.is_publish'),$match->is_publish)!!}

			<div class="form-group">
				<div class="form-inline">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">試合結果</label>
					<label for="address"></label><div class="form-control-static">{{array_get($teams,$match->home_id)}}</div>
					{!!Form::select('home_pt',array_combine(range(0,20), range(0,20)), $match->home_pt,['class'=>'form-control','placeholder'=>'▼'])!!} ―
					{!!Form::select('away_pt',array_combine(range(0,20), range(0,20)), $match->away_pt,['class'=>'form-control','placeholder'=>'▼'])!!}
					<label for="address"></label><div class="form-control-static">{{array_get($teams,$match->away_id)}}</div>
				</div>
				<div class="form-inline">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">PK</label>
					<label for="address"></label><div class="form-control-static">{{array_get($teams,$match->home_id)}}</div>
					{!!Form::select('home_pk',array_combine(range(0,20), range(0,20)), $match->home_pk,['class'=>'form-control','placeholder'=>'▼'])!!} ―
					{!!Form::select('away_pk',array_combine(range(0,20), range(0,20)), $match->away_pk,['class'=>'form-control','placeholder'=>'▼'])!!}
					<label for="address"></label><div class="form-control-static">{{array_get($teams,$match->away_id)}}</div>
				</div>
			</div>

			<?php
			$goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','home')->where('team_id',$match->home_id)->get()->toArray();
			?>
			<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">{{array_get($teams,$match->home_id)}} 得点・アシスト</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<table class="table-striped">
							<tr>
								<td>時間</td>
								<td>得点</td>
							</tr>
							@for($i=0;$i<20;$i++)
							<tr>
								<td>{!!Form::select("home_goals[$i][time]",config('app.matchTimeAry'), isset($goals[$i]['time'])?$goals[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
								<td>{!!Form::select("home_goals[$i][player]",$players_home['name'], isset($goals[$i]['goal_player_id'])?$goals[$i]['goal_player_id']:'',['placeholder'=>'選手選択'])!!}</td>
							</tr>
							@endfor
						</table>
					</div>
			</div>

			<?php
			$cards = \App\Cards::where('match_id',$match->id)->where('h_or_a','home')->where('team_id',$match->home_id)->get()->toArray();
			?>
			<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">{{array_get($teams,$match->home_id)}} 警告・退場</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<table class="table-striped">
							<tr>
								<td>時間</td>
								<td>警告種別</td>
								<td>対象選手</td>
							</tr>
							@for($i=0;$i<5;$i++)
							<tr>
								<td>{!!Form::select("home_cards[$i][time]",config('app.matchTimeAry'), isset($cards[$i]['time'])?$cards[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
								<td>{!!Form::select("home_cards[$i][type]",['yellow'=>'警告','red'=>'退場'], isset($cards[$i]['color'])?$cards[$i]['color']:'',['placeholder'=>'種別選択'])!!}</td>
								<td>{!!Form::select("home_cards[$i][player]",$players_home['name'], isset($cards[$i]['player_id'])?$cards[$i]['player_id']:'',['placeholder'=>'選手選択'])!!}</td>
							</tr>
							@endfor
						</table>
					</div>
			</div>

			<?php
			$goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','away')->where('team_id',$match->away_id)->get()->toArray();
			?>
			<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">{{array_get($teams,$match->away_id)}} 得点・アシスト</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<table class="table-striped">
							<tr>
								<td>時間</td>
								<td>得点</td>
							</tr>
							@for($i=0;$i<20;$i++)
							<tr>
								<td>{!!Form::select("away_goals[$i][time]",config('app.matchTimeAry'), isset($goals[$i]['time'])?$goals[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
								<td>{!!Form::select("away_goals[$i][player]",$players_away['name'], isset($goals[$i]['goal_player_id'])?$goals[$i]['goal_player_id']:'',['placeholder'=>'選手選択'])!!}</td>
							</tr>
							@endfor
						</table>
					</div>
			</div>

			<?php
			$cards = \App\Cards::where('match_id',$match->id)->where('h_or_a','away')->where('team_id',$match->away_id)->get()->toArray();
			?>
			<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12">{{array_get($teams,$match->away_id)}} 警告・退場</label>
					<div class="col-md-10 col-sm-10 col-xs-12">
						<table class="table-striped">
							<tr>
								<td>時間</td>
								<td>警告種別</td>
								<td>対象選手</td>
							</tr>
							@for($i=0;$i<5;$i++)
							<tr>
								<td>{!!Form::select("away_cards[$i][time]",config('app.matchTimeAry'), isset($cards[$i]['time'])?$cards[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
								<td>{!!Form::select("away_cards[$i][type]",['yellow'=>'警告','red'=>'退場'], isset($cards[$i]['color'])?$cards[$i]['color']:'',['placeholder'=>'種別選択'])!!}</td>
								<td>{!!Form::select("away_cards[$i][player]",$players_away['name'], isset($cards[$i]['player_id'])?$cards[$i]['player_id']:'',['placeholder'=>'選手選択'])!!}</td>
							</tr>
							@endfor
						</table>
					</div>
			</div>

			{!!Form::textareaField('note','マッチレポート',$match->note,['size'=>'1x3'])!!}

			{!!Form::textareaField('home_comment',array_get($teams,$match->home_id).'コメント',$match->home_comment,['size'=>'3x3'])!!}
			{!!Form::textareaField('away_comment',array_get($teams,$match->away_id).'コメント',$match->away_comment,['size'=>'3x3'])!!}

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