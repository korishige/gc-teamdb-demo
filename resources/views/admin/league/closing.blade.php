@extends('layouts.admin')

@section('content')
<div class="x_panel">
	<div class="clearfix"></div>

	<?php
	if(count($debug)>0)
		foreach($debug as $row){
			var_dump($row);
			print("<hr>");
		}
	?>

	<ol class="breadcrumb">
		<li><a href="{{route('admin.league.index')}}">大会一覧</a></li>
		<li class="active">{{$league->name}} {{array_get(\App\Groups::get()->lists('name', 'id'),$league->group_id)}} 締め処理</li>
	</ol>

	<div class="x_content">
		{!!Form::open(['url'=>route('admin.league.close'),'class'=>"form-horizontal form-label-left",'method'=>'post'])!!}
		<input type="hidden" name="id" value="{{$league->id}}">

		<h2>最終順位設定</h2>

		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-12">

				{!!Form::rbinline('is_closed','開催状況',['開催中','開催終了'],$league->is_closed)!!}

				@foreach($_teams as $team)
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-12 col-xs-12">{{$team->name}}</label>
					<div class="col-md-3 col-sm-12 col-xs-12">
						<div class="input-group">
							{!!Form::text('rank['.$team->team_id.']',$team->rank,['class'=>'form-control'])!!}
							<span class="input-group-addon">位</span>
						</div>
					</div>
				</div>
				@endforeach

				<div class="form-group">
					<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
						<button type="submit" class="btn btn-success">保存</button>
					</div>
				</div>

				{!!Form::close()!!}				
			</div>
			<div class="col-md-8 col-sm-6 col-xs-12">
				@if(count($resultObj)>0)
				<table class="table table-striped">
					<thead>
						<tr>
							<th></th>
							@foreach($resultObj as $result)
							<th>{{$result->name}}</th>
							@endforeach
							<th class="last">暫定順位</th>
						</tr>
					</thead>
					<tbody>
						<?php $k=0;?>
						@foreach($table as $i=>$row)
						<tr class="home">
							<td>{{$resultObj[$k]->name}}</td>
							@foreach($row as $j=>$col)
							@if($i==$j)
							<td class="none">&nbsp;</td>
							@else
							<td>
								@foreach($col as $val)
								{{$val}}<br>
								@endforeach
							</td>
							@endif
							@endforeach
							<td class="last">{{$resultObj[$k]->rank}}</td>
						</tr>
						<?php $k++;?>
						@endforeach
					</tbody>
				</table>
				@else
				リーグ戦がありません
				@endif
				<div class="vod_table_footer"><p>○：勝ち　●：負け　△：PK勝ち　▲：PK負け</p></div>

				<div class="ln_solid"></div>
			
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="item01">順位</th>
							<th class="item02">チーム名</th>
							@if($league->season == 1)
							<th class="item02">1st勝点</th>
							@endif
							@if($league->season == 1)
							<th class="item03">合計勝点</th>
							@else
							<th class="item03">勝点</th>
							@endif
							<th class="item04">試合数</th>
							<th class="item05">勝数</th>
							<th class="item06">敗数</th>
							<th class="item07">PK勝数</th>
							<th class="item08">PK負数</th>
							<th class="item09">得点</th>
							<th class="item10">失点</th>
							<th class="item11 last">得失点差</th>
						</tr>
					</thead>
					<tbody>
						@foreach($resultObj as $i=>$result)
						<tr {{($i%2)?'':'class="bgColor"'}}>
							<td class="textC">{{$result->rank}}</td>
							<td class="team">{{$result->name}}</td>
							@if($league->season == 1)
							<td class="textC">{{$result->prestage_win_pt}}</td>
							@endif
							<td class="textC">{{$result->win_pt}}</td>
							<td class="textC">{{$result->match_cnt}}</td>
							<td class="textC">{{$result->win_cnt}}</td>
							<td class="textC">{{$result->lose_cnt}}</td>
							<td class="textC">{{$result->pk_win_cnt}}</td>
							<td class="textC">{{$result->pk_lose_cnt}}</td>
							<td class="textC">{{$result->get_pt}}</td>
							<td class="textC">{{$result->lose_pt}}</td>
							<td class="textC last">{{$result->get_lose}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop