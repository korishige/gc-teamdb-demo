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
				@foreach($groups as $group)
					<li {{($groups_id==$group->id)?'class=on':''}}><a href="{{route('front.ranking.groups',['groups_id'=>$group->id, 'yyyy'=>$yyyy])}}">{{ $group->name }}</a></li>
				@endforeach
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.league_type -->

	<div class="period_list">
		<div class="inner">
			<ul>
				<li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.ranking.groups',['group_id'=>$groups_id,'yyyy'=>$yyyy,'period'=>'first'])}}">1st stage</a></li>
				<li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.ranking.groups',['group_id'=>$groups_id,'yyyy'=>$yyyy,'period'=>'second'])}}">2nd stage</a></li>
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
												<a href="{{route('front.order.index',['group_id'=>$league->group->id])}}">全順位</a>
										</li>
										<li>
												<a href="{{route('front.match.index',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">試　合</a>
										</li>
										<li>
												<a href="{{route('front.table.groups',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">戦績表</a>
										</li>
										<li>
												<a href="{{route('front.ranking.groups',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}" class="on">得点ランキング</a>
										</li>
								</ul>
								</div><!-- /.snav -->

								<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
								<div class="box all">
									<table id="sort-table" style="font-size: 22px">
										<thead>
											<tr>
												<th>順位</th>
												<th style="width: 5%; text-align: center;">名前</th>
												<th style="width: 10%;">所属チーム</th>
												<th>得点</th>
										</tr>
										</thead>
										<?php
										$rank=0; $prev_pt = 0;
										?>
										@foreach($rankings[$league->id] as $_player)
												<?php
													if($prev_pt != $_player->cnt){
														$prev_pt = $_player->cnt;
														$rank += 1;
													}
													if($rank >= 10) break;
													$player = \App\Players::find($_player->id);

													if($prev_pt != $_player->cnt) $rank++;
												?>
												<tr class="home">
													<td>{{$rank}}</td>
													<td style="text-align: center;">{{$player->name or "要チェック:{$_player->id}"}}</td>
													<td>{{$player->team->name or '要チェック'}}</td>
													<td>{{$_player->cnt}}</td>
												</tr>
										@endforeach
									</table>
								</div><!-- /.box -->
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

