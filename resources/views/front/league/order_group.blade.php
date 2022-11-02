<?php
// 1部 全順位｜高円宮杯 JFA U-18 サッカーリーグ 福岡｜2020（年度変わったらここも変わる）
$page_title = sprintf("%s 全順位 | %s | %s", isset($league->group->name)?$league->group->name:'', env('title'), isset($league->year)?$league->year:'');
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/ranking.css" rel="stylesheet" type="text/css">
@endsection

@section('footer_sub')
@endsection

@section('contents')
<div class="content_title">
	<div class="inner">
		<h1>順位</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->

<div class="bc">
	<span><a href="{{route('front.index')}}">TOP</a></span>
	<span><a href="{{route('front.order.index')}}">順位</a></span>
</div><!-- /.bc -->

<main class="content">

	<div class="year_list">
		<div class="inner">
			<ul>
				@for($year=(date('md')>='0320')?date('Y'):date('Y')-1; $year>=2022; $year--)
					<li class="{{($yyyy==$year)?'on':''}}"><a href="{{route('front.order.index',['groups_id'=>$groups_id,'yyyy'=>$year])}}">{{$year}}年</a></li>
				@endfor
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.year_list -->

	<div class="league_list">
		<div class="inner">
			<ul>
				<?php
				// $_on2 = [];
				// foreach(range(2,29) as $k){
				// 	if($k==$group_id){
				// 		$_on2[$k] = ' class=on';
				// 	}else{
				// 		$_on2[$k] = '';
				// 	}
				// }
				?>
				@foreach($groups as $g)
				<li {{($groups_id==$g->id)?'class=on':''}}><a href="{{route('front.order.index',['groups_id'=>$g->id, 'yyyy'=>$yyyy])}}">{{ $g->name }}</a></li>
				{{-- <li {{($groups_id==2)?'class=on':''}}><a href="{{route('front.order.index',['groups_id'=>2, 'yyyy'=>$yyyy])}}">関西</a></li> --}}
				{{-- <li {{($groups==3)?'class=on':''}}><a href="{{route('front.order.index',['groups_id'=>3, 'yyyy'=>$yyyy])}}">3部</a></li> --}}
				@endforeach
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.league_type -->

	<div class="period_list">
		<div class="inner">
			<ul>
				<li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.order.index',['group_id'=>$groups_id,'yyyy'=>$yyyy,'period'=>'first'])}}">1st stage</a></li>
				<li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.order.index',['group_id'=>$groups_id,'yyyy'=>$yyyy,'period'=>'second'])}}">2nd stage</a></li>
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.period_list -->



	<div class="inner">
		<div class="main">

			<article>
				<section>
					<div id="ranking">
						<div class="inner">
							@forelse($leagues as $league)
								<div class="head">
									<h2>{{$league->name}}　{{array_get(Config::get('app.seasonAry'),$league->season)}}</h2>
									<span>最終更新日: {{$league->matches->max('updated_at')}}</span>
								</div><!-- /.head -->

								<div class="snav">
									<ul>
										<li>
												<a href="{{route('front.order.index',['group_id'=>$league->group->id])}}"class="on">全順位</a>
										</li>
										<li>
												<a href="{{route('front.match.index',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">試　合</a>
										</li>
										<li>
												<a href="{{route('front.table.groups',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">戦績表</a>
										</li>
										<li>
												<a href="{{route('front.ranking.groups',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">得点ランキング</a>
										</li>
								</ul>
								</div><!-- /.snav -->

								@if($resultObj[$league->id] == null)
									<div class="head">なし</div>
								@else
									<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
									<div class="box all">
										<table id="sort-table">
											<thead>
												<tr>
													<th>順位</th>
													<th>チーム名</th>
													@if($league->season == 1)
													<th class="item02">1st勝点</th>
													@endif
													@if($league->season == 1)
													<th class="item03">合計勝点</th>
													@else
													<th class="item03">勝点</th>
													@endif
													<th>試合数</th>
													<th>勝数</th>
													<th>敗数</th>
													<th>PK勝数</th>
													<th>PK負数</th>
													<th>得点</th>
													<th>失点</th>
													<th>得失点差</th>
											</tr>
											</thead>
											@foreach($resultObj[$league->id] as $i=>$result)
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
										</table>
									</div><!-- /.box -->
								@endif
							@empty
								<div class="head">なし</div>
							@endforelse
						</div><!-- /.inner -->
					</div>
				</section>

			</article>

		</div><!-- /.main -->

		@include('front.parts.side')

	</div><!-- /.inner -->
</main>
@stop

