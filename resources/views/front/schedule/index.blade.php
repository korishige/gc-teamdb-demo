<?php
$nendo = date('Y', strtotime('-3 month'));
if(Input::has('id')){
	$page_title = Input::get('id').'部 | 日程 ｜ '.config('app.title').' | '.$nendo;
}else{
	$page_title = '日程 ｜ '.env('title').' | '.$nendo;
}
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/schedule.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
	<script>
		$(function () {
			$('.group3_first').on('click', () => {
				// $('#group31').show();
				// $('#group32').hide();
				$('#g31_on').attr('class', 'on');
				$('#g32_on').attr('class', '');
			});
			$('.group3_second').on('click', () => {
				// $('#group32').show();
				// $('#group31').hide();
				$('#g32_on').attr('class', 'on');
				$('#g31_on').attr('class', '');
			});
		});
	</script>
@endsection

@section('footer_sub')
@endsection

@section('contents')
<div class="content_title">
	<div class="inner">
		<h1>日程</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->

<div class="bc">
  <span><a href="{{route('front.index')}}">TOP</a></span>
  <span><a href="{{route('front.schedule.index')}}">日程</a></span>
</div><!-- /.bc -->

<main class="content">

	<div class="league_list">
		<div class="inner">
			<ul>
				@foreach($groups as $group)
					<li {{($groups_id==$group->id)?'class=on':''}}><a href="{{route('front.schedule.index',['groups_id'=>$group->id])}}">{{ $group->name }}</a></li>
				@endforeach
			</ul>
		</div><!-- /.inner -->
	</div><!-- /.league_type -->

		<div class="period_list">
			<div class="inner">
				<ul>
					<li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.schedule.index',['groups_id'=>$groups_id,'period'=>'first'])}}">1st stage</a></li>
					<li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.schedule.index',['groups_id'=>$groups_id,'period'=>'second'])}}">2nd stage</a></li>
				</ul>
			</div><!-- /.inner -->
		</div><!-- /.period_list -->
	
	<div class="inner">
		<div class="main">

			<article>
				<section>
					<div id="schedule">
						<div class="inner">
							@forelse($leagues as $league)
							<div class="head" style="margin-top:20px">
								<h2>{{$league->name}}　{{array_get(Config::get('app.seasonAry'),$league->season)}}</h2>
								<span>最終更新日: {{$league->matches1->max('updated_at')}}</span>
							</div><!-- /.head -->

							<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
							<div class="box">
								<table>
									<tr>
										<th><a href="?&sort=section&" style="text-decoration: none; color: white;">節<br>▼</a></th>
										<th><a href="?&sort=match_at&" style="text-decoration: none; color: white;">日時<br>▼</a></th>
										<th>開始</th>
										<th>対戦カード</th>
										<th>会場</th>
									</tr>
									@forelse($matches[$league->id] as $match)
									<tr>
										<td>{{$match->section}}</td>
										<td>
											@if($match->is_publish == 2)
												<h1>延期</h1>
											@elseif($match->is_publish == 3)
												<h1>未定</h1>
											@else
												{{date('Y/m/d',strtotime($match->match_date))}}
											@endif
										</td>
										<td>
											@if($match->is_publish == 2)
											@elseif($match->is_publish == 3)
											@else
												{{$match->match_time}}
											@endif
										</td>
										<td class="match">
											<span>{{$match->home0->name}}</span>
											<span>
												@if($match->is_filled and $match->match_date < date('Y-m-d 06:00:00'))
													@if($match->home_pt != $match->away_pt)
														{{$match->home_pt}}　vs　{{$match->away_pt}}
													@else
														{{$match->home_pt}}(PK{{$match->home_pk}})　vs　(PK{{$match->away_pk}}){{$match->away_pt}}
													@endif
												@endif
											</span>
											<span>{{$match->away0->name}}</span>
										</td>
										<td>{{$match->place->name or ''}}</td>
									</tr>
									@empty
										<tr>
											<td colspan="5">まだ日程が確定していません</td>
										</tr>
									@endforelse
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

