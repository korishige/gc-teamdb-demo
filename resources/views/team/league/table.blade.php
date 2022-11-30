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
						<li><a href="{{route('team.league.order',['id'=>$league->id])}}">リーグ順位</a></li>
						<li><a href="{{route('team.league.match.all',['id'=>$league->id])}}">全試合</a></li>
						<li><a href="{{route('team.league.match.self',['id'=>$league->id])}}">自チーム試合</a></li>
						<li class="on"><a href="{{route('team.league.table',['id'=>$league->id])}}">戦績表</a></li>
						<li><a href="{{route('team.league.goals',['id'=>$league->id])}}">得点</a></li>
						{{-- <li><a href="{{route('team.league.block',['id'=>$league->id])}}">ブロック選手</a></li> --}}
            <li><a href="{{route('team.league.warning',['id'=>$league->id, 'nendo'=>$league->year])}}">警告者</a></li>
            <li></li>
						<li></li>
					</ul>
				</div><!-- /.league_list -->

				<div class="table">

					<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>

					<div class="box">
						<table>
							<tr>
								<th></th>
								@foreach($resultObj as $result)
								<th>{{$result->name}}</th>
								@endforeach
								<th>暫定<br>順位</th>
							</tr>
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

						</table>
					</div><!-- /.box -->

				</div><!-- /.order -->

			</div><!-- /.inner -->
		</div>
		<div class="vod_table_footer"><p>○：勝ち　●：負け　△：引き分け</p></div>
	</section>

</article>
@endsection