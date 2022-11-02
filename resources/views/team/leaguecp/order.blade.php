@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/league.css" rel="stylesheet" type="text/css" />
@stop

@section('js')
@stop

@section('overlay')
<div class="content_title">
	<div class="inner">
		<h1>
			<span>リーグ情報</span>
			<span>LEAGUE INFORMATION</span>
		</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')
<article>
	<section>
		<div id="league">

			<div class="inner">

				<div class="league_list">
					<ul>
						<li class="on"><a href="{{route('team.league.order',['id'=>$league->id])}}">リーグ順位</a></li>
						<li><a href="{{route('team.league.match.all',['id'=>$league->id])}}">全試合</a></li>
						<li><a href="{{route('team.league.match.self',['id'=>$league->id])}}">自チーム試合</a></li>
						<li><a href="{{route('team.league.table',['id'=>$league->id])}}">戦績表</a></li>
						<li><a href="{{route('team.league.goals',['id'=>$league->id])}}">得点</a></li>
						<li><a href="{{route('team.league.block',['id'=>$league->id])}}">ブロック選手</a></li>
            <li><a href="{{route('team.league.warning',['id'=>$league->id])}}">警告者</a></li>
					</ul>
				</div><!-- /.league_list -->

				<div class="order">

					<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>

					<div class="box">
						<table>
							<tr>
								<th><a href="">順位</a></th>
								<th><a href="">チーム名</a></th>
								<th><a href="">勝点</a></th>
								<th><a href="">試合数</a></th>
								<th><a href="">勝数</a></th>
								<th><a href="">引分数</a></th>
								<th><a href="">敗数</a></th>
								<th><a href="">得点</a></th>
								<th><a href="">失点</a></th>
								<th><a href="">得失点差</a></th>
							</tr>
							@foreach($resultObj as $i=>$result)
							<tr {{($i%2)?'':'class="bgColor"'}}>
								<td class="textC">{{$result->rank}}</td>
								<td class="team">{{$result->name}}</td>
								<td class="textC">{{$result->win_pt}}</td>
								<td class="textC">{{$result->match_cnt}}</td>
								<td class="textC">{{$result->win_cnt}}</td>
								<td class="textC">{{$result->draw_cnt}}</td>
								<td class="textC">{{$result->lose_cnt}}</td>
								<td class="textC">{{$result->get_pt}}</td>
								<td class="textC">{{$result->lose_pt}}</td>
								<td class="textC last">{{$result->get_lose}}</td>
							</tr>
							@endforeach
						</table>
					</div><!-- /.box -->
				</div><!-- /.order -->
			</div><!-- /.inner -->
		</div>
	</section>

</article>
@endsection
