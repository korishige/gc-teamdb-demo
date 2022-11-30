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
						<li class="{{(preg_match('/team.league.match.all/',Route::currentRouteName()))?'on':''}}"><a href="{{route('team.league.match.all',['id'=>$league->id])}}">全試合</a></li>
						<li class="{{(preg_match('/team.league.match.self/',Route::currentRouteName()))?'on':''}}"><a href="{{route('team.league.match.self',['id'=>$league->id])}}">自チーム試合</a></li>
						<li><a href="{{route('team.league.table',['id'=>$league->id])}}">戦績表</a></li>
						<li><a href="{{route('team.league.goals',['id'=>$league->id])}}">得点</a></li>
						{{-- <li><a href="{{route('team.league.block',['id'=>$league->id])}}">ブロック選手</a></li> --}}
            <li><a href="{{route('team.league.warning',['id'=>$league->id, 'nendo'=>$league->year])}}">警告者</a></li>
            <li></li>
						<li></li>
					</ul>
				</div><!-- /.league_list -->

				<div class="match-all">

					<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>

					<div class="box">
						<table cellspacing="0" cellpadding="0" border="0">
							<tr>
								<th>キックオフ</th>
								<th></th>
								<th>試合状況</th>
								<th></th>
								<th>試合会場</th>
							</tr>
							@foreach($matches as $match)
							<tr>
								<td class="textC">
									{{$match->match_date}} ({{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}}) {{$match->match_time}}
								</td>
								<td class="team">
									{{$match->home0->name}}
								</td>
								<td class="score">
                  @if($match->is_filled)
                  {{$match->home_pt}} vs {{$match->away_pt}}
                  <span>試合終了</span>
                  @else

                  @endif
								</td>
								<td class="team">
									{{$match->away0->name}}
								</td>
								<td>{{$match->place->name}}</td>
							</tr>
							@endforeach
						</table>
					</div><!-- /.box -->
				</div><!-- /.order -->
			</div><!-- /.inner -->
		</div>

    <div class="pager">
        {!! $matches->appends(Input::except('page'))->render(); !!}
    </div><!-- /.pager -->

	</section>
</article>
@endsection
