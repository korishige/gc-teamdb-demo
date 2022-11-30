@extends('layouts.team')

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	function check(){
	if(window.confirm('一括削除してよろしいですか？')){ // 確認ダイアログを表示
		return true; // 「OK」時は送信を実行
	}
	else{ // 「キャンセル」時の処理
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false; // 送信を中止
	}
}

$(function(){
	$(document).on('click','#toggle',function(){
		$('.chkbox').prop('checked', this.checked);
	});
})
</script>
@endsection

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/starter_setting.css" rel="stylesheet" type="text/css" />
<style>
	#starter_create .btn input {
    display: block;
    width: 30%;
    height: 50px;
    line-height: 50px;
    color: #fff;
    background-image: url(../img/common/icon_print.png);
    background-size: 8%;
    background-repeat: no-repeat;
    background-position: 5% center;
    background-color: #2CA17D;
    text-decoration: none;
    font-size: 1.2em;
    border-radius: 5px;
    font-family: 'Noto Sans JP',sans-serif;
}
</style>
@stop

@section('overlay')
<div class="content_title">
	<div class="inner">
		<h1>
			<span>スタメン登録</span>
			<span>Starting Member Registration</span>
		</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')
<div id="starter_create">
	<div class="inner">
		{!! Form::open(['url'=>route('team.starter.edit',['id'=>$match_id]),'method'=>'GET','class'=>"form-horizontal form-label-left"]) !!}
		{!! Form::select('starting_member_id', $match_histories, (\Input::has('starting_member_id'))?\Input::get('starting_member_id'):'', ['placeholder'=>'過去スタメン選択','class'=>'form-control','style'=>"width:220px"])!!}
			<input type="submit" value="選択">
		<br><div style="color:red">過去スタメン選択後は保存してください</div>
		<br><div style="color:red">選択した過去スタメンに出場停止選手がいた場合は選手名が表示されません</div>
		{!! Form::close() !!}

		<div style="margin-top:20px"></div>
		{!! Form::close() !!}
		{!!Form::open(['url'=>route('team.starter.update'),'class'=>"form-horizontal form-label-left"])!!}
		{!! Form::hidden('match_id', $match_id) !!}
			<div class="head">
				<h1>{{$match->leagueOne->name}}</h1>
				<div class="row">
					<div class="date">
						開催日：{{date('Y年n月j日',strtotime($match->match_date))}}
					</div><!-- /.date -->
					<?php
						if($match->away_id == \Session::get('team_id')){
							$away = $match->home0->name;
							$home = $match->away0->name;
						}else{
							$away = $match->away0->name;
							$home = $match->home0->name;
						}
					?>
					<div class="opp">
						対戦相手：{{$away}}
					</div><!-- /.opp -->
					<div class="team">
						チーム名：{{$home}}
					</div><!-- /.team -->
				</div><!-- /.row -->
			</div><!-- /.head -->

			<div class="row">
				<div class="box">
					<h2>スタメン</h2>
					<table>
						<tr>
							<th>選手名</th>
							<th>Pos</th>
							<th>背番号</th>
							<th>Cap</th>
							<th>先発</th>
							<th>ベンチ入り</th>
						</tr>
						@for($i=0;$i<25;$i++)
						<tr>
							@if(0)
							<td>
								{!!Form::text('number['.$i.']',old('number'))!!}
							</td>
							<td>
								{!!Form::select('position['.$i.']',config('app.positionAry'), null, ['placeholder'=>'選択'])!!}
							</td>
							<td>
								{!!Form::select('player_id['.$i.']', $players, null, ['placeholder'=>'選手選択'])!!}
							</td>
							<td>
								{!!Form::hidden('is_starter['.$i.']',0)!!}
								{!!Form::checkbox('is_starter['.$i.']',$i)!!}
							</td>
							@else
								<td>
									{!!Form::select('player_id['.$i.']', $players, isset($pop['player_id'][$i])?$pop['player_id'][$i]:'', ['placeholder'=>'選手選択'])!!}
								</td>
								<td>
									{!!Form::select('position['.$i.']',config('app.positionAry'), isset($pop['position'][$i])?$pop['position'][$i]:'',  ['placeholder'=>'選択'])!!}
								</td>
								<td>
									{!!Form::text('number['.$i.']', isset($pop['number'][$i])?$pop['number'][$i]:'')!!}
								</td>
								<td>
									<?php
									if($i == $pop['cap']){
										$checked = 'checked';
									}else{
										$checked = '';
									}
									?>
									<input type="radio" name="cap" value="{{$i}}" {{$checked}} >
								</td>
								<td>
									{!!Form::hidden('is_starter['.$i.']',0)!!}
									<?php
									$aaa = isset($pop['is_starter'][$i])?$pop['is_starter'][$i]:'';
									?>
									{!!Form::checkbox('is_starter['.$i.']',1, ($aaa==1)?'true':'')!!}
								</td>
								<td>
									{!!Form::hidden('is_bench['.$i.']',0)!!}
									<?php
									$bbb = isset($pop['is_bench'][$i])?$pop['is_bench'][$i]:'';
									?>
									{!!Form::checkbox('is_bench['.$i.']',1, ($bbb==1)?'true':'')!!}
								</td>
							@endif
						</tr>
						@endfor

					</table>
				</div>

				<div class="box">
					<h2>ベンチ入りスタッフ</h2>

					<table>
						<tr>
							<th>役職</th>
							<th>スタッフ名</th>
						</tr>
						@for($i=0;$i<6;$i++)
						<tr>
							<td>
								{!!Form::text('staff_role['.$i.']',$pop['staff_role'][$i])!!}
							</td>
							<td>
								{!!Form::text('staff_name['.$i.']',$pop['staff_name'][$i])!!}
							</td>
						</tr>
						@endfor
					</table>

					<table>
						<tr>
							<th></th>
							<th>シャツ</th>
							<th>ショーツ</th>
							<th>ソックス</th>
						</tr>
						<tr>
							<td>FP(正)</td>
							<td>{!!Form::text('fp_pri_shirt',isset($pop['fp_pri_shirt'])?$pop['fp_pri_shirt']:'')!!}</td>
							<td>{!!Form::text('fp_pri_shorts',isset($pop['fp_pri_shorts'])?$pop['fp_pri_shorts']:'')!!}</td>
							<td>{!!Form::text('fp_pri_socks',isset($pop['fp_pri_socks'])?$pop['fp_pri_socks']:'')!!}</td>
						</tr>
						<tr>
							<td>FP(副)</td>
							<td>{!!Form::text('fp_sub_shirt',isset($pop['fp_sub_shirt'])?$pop['fp_sub_shirt']:'')!!}</td>
							<td>{!!Form::text('fp_sub_shorts',isset($pop['fp_sub_shorts'])?$pop['fp_sub_shorts']:'')!!}</td>
							<td>{!!Form::text('fp_sub_socks',isset($pop['fp_sub_socks'])?$pop['fp_sub_socks']:'')!!}</td>
						</tr>
						<tr>
							<td>GK(正)</td>
							<td>{!!Form::text('gk_pri_shirt',isset($pop['gk_pri_shirt'])?$pop['gk_pri_shirt']:'')!!}</td>
							<td>{!!Form::text('gk_pri_shorts',isset($pop['gk_pri_shorts'])?$pop['gk_pri_shorts']:'')!!}</td>
							<td>{!!Form::text('gk_pri_socks',isset($pop['gk_pri_socks'])?$pop['gk_pri_socks']:'')!!}</td>
						</tr>
						<tr>
							<td>GK(副)</td>
							<td>{!!Form::text('gk_sub_shirt',isset($pop['gk_sub_shirt'])?$pop['gk_sub_shirt']:'')!!}</td>
							<td>{!!Form::text('gk_sub_shorts',isset($pop['gk_sub_shorts'])?$pop['gk_sub_shorts']:'')!!}</td>
							<td>{!!Form::text('gk_sub_socks',isset($pop['gk_sub_socks'])?$pop['gk_sub_socks']:'')!!}</td>
						</tr>
					</table>

				</div>

			</div><!-- /.row -->

			<div class="btn">
				<input type="submit" value="保存する">
				<!-- <input type="text" value="保存する"> -->
				<a href="{{route('team.starter.print',['id'=>$match->id])}}">印刷する</a>
			</div><!-- /.btn -->
			<div><span style="color:red">※保存した後に印刷してください</span></div>


		{!!Form::close()!!}

	</div><!-- /.inner -->
</div><!-- /#starter_create -->

@endsection
