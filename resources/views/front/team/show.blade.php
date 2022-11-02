<?php
$page_title = $team->name .' | チーム情報 ｜ '.env('title');
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="/css/team.css" rel="stylesheet" type="text/css" />
<style>
	.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-top: initial;
    margin-bottom: initial;
    font-weight: 600;
    line-height: initial;
}

	h1{
		font-size: initial;
	}
	h2 {
		font-size: initial;
	}
	.uniform th {
		width: 20%;
		text-align: center;
	}

	.uniform td {
		padding: 10px;
		text-align: center;
	}

	.player {
		width: 100%;
	}

	.player th {
		text-align: center;
	}

	.player td {
		padding: 10px;
		text-align: center;
	}
</style>
@endsection

@section('footer_sub')
@endsection

@section('contents')
<div class="content_title">
	<div class="inner">
		<h1>チーム</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->

<div class="bc">
	<span><a href="{{route('front.index')}}">TOP</a></span>
	<span><a href="{{route('front.team.index')}}">チーム</a></span>
</div><!-- /.bc -->

<main class="content">


	<div class="inner">
		<div class="main">
			<article>
				<div id="team_detail">
					<div class="inner">
						<div class="head">
							<div class="emb">
								@if(!empty($team->emblem_img))
								<img src="/upload/original/{{$team->emblem_img}}">
								@else
								<img src="/img/common/team_emblem_sample.png">
								@endif
							</div><!-- /.emb -->
							<h2>{{$team->name}}</h2>
						</div><!-- /.head -->
						
						
						<div class="txt">
							{{--
							テキストが入ります。このテキストはダミーです。テキストが入ります。このテキストはダミーです。テキストが入ります。このテキストはダミーです。テキストが入ります。このテキストはダミーです。テキストが入ります。このテキストはダミーです。
							--}}
						</div><!-- /.txt -->
						
						<div class="team_img">
							@if(!empty($team->group_img))
							<img src="/upload/original/{{$team->group_img}}">
							@else
							<img src="/img/common/dammy_team_detail01.png">
							@endif
						</div><!-- /.img -->

						<div class="txt">
							@if(!empty($team->manager_mov))
							<h2 class="stitle">監督動画</h2>
							<div style="text-align: center; padding-bottom: 20px;">
							<video controls playsinline width="100%" height="300" style="background: black;" src="/upload/movie/{{$team->manager_mov}}"></video>
							</div>
							@endif

							@if(!empty($team->captain_mov))
							<h2 class="stitle">主将動画</h2>
							<div style="text-align: center; padding-bottom: 20px;">
							<video controls playsinline width="100%" height="300" style="background: black;" src="/upload/movie/{{$team->captain_mov}}"></video>
							</div>
							@endif

							<h2 class="stitle">チーム紹介</h2>

							<h3>設立年</h3>
							@if(isset($team->year))
							{{date('Y年',strtotime($team->year))}} 設立
							@endif


							<h3>住所</h3>
							{{array_get(config('app.prefAry'),$team->pref_id)}} {{$team->add1}}　{{$team->organization->name}}

							<h3>チーム監督名</h3>
							{{$team->manager}}
							
							@if($team->coach!='')
							<h3>チームコーチ名</h3>
							{{$team->coach}}
							@endif

							<h3>ユニフォーム</h3>

							<table class="table uniform">
								<tr>
									<th></th>
									<th>シャツ</th>
									<th>ショーツ</th>
									<th>ソックス</th>
								</tr>
								<tr>
									<td>FP(正)</td>
									<td>{{$team->fp_pri_shirt}}</td>
									<td>{{$team->fp_pri_shorts}}</td>
									<td>{{$team->fp_pri_socks}}</td>
								</tr>
								<tr>
									<td>FP(副)</td>
									<td>{{$team->fp_sub_shirt}}</td>
									<td>{{$team->fp_sub_shorts}}</td>
									<td>{{$team->fp_sub_socks}}</td>
								</tr>
								<tr>
									<td>GK(正)</td>
									<td>{{$team->gk_pri_shirt}}</td>
									<td>{{$team->gk_pri_shorts}}</td>
									<td>{{$team->gk_pri_socks}}</td>
								</tr>
								<tr>
									<td>GK(副)</td>
									<td>{{$team->gk_sub_shirt}}</td>
									<td>{{$team->gk_sub_shorts}}</td>
									<td>{{$team->gk_sub_socks}}</td>
								</tr>
							</table>
		
						</div>
						
						<div class="txt">
							<h2 class="stitle">目的・実績</h2>
							
							<h3>指導方針や目標</h3>
							{!!nl2br($team->policy)!!}
							
							<h3>過去の主な実績</h3>
							{!!nl2br($team->record)!!}
						</div><!-- /.txt -->
						
						<div class="txt">
							<h2 class="stitle">ホームページ・SNS</h2>
							
							@if($team->url_school!='')
								<?php
								$_http_url = strstr($team->url_school, 'http')?$team->url_school:'//'.$team->url_school;
								?>
							<h3>学校HP</h3>
							<a href="{{$team->url_school}}" target="_blank">
								{{$team->url_school}}
							</a>
							@endif

							@if($team->url_team!='')
							<h3>チームHP</h3>
							<a href="{{$team->url_team}}" target="_blank">
								{{$team->url_team}}
							</a>
							@endif
							
							@if($team->url_blog!='')
							<h3>チームブログ</h3>
							<a href="{{$team->url_blog}}" target="_blank">
								{{$team->url_blog}}
							</a>
							@endif
							
							@if($team->url_facebook!='')
							<h3 class="icon_facebook">Facebook</h3>
							<a href="{{$team->url_facebook}}" target="_blank">
								{{$team->url_facebook}}
							</a>
							@endif
							
							@if($team->url_instagram!='')
							<h3 class="icon_instagram">Instagram</h3>
							<a href="{{$team->url_instagram}}" target="_blank">
								{{$team->url_instagram}}
							</a>
							@endif
							
							@if($team->url_twitter!='')
							<h3 class="icon_twitter">twitter</h3>
							<a href="{{$team->url_twitter}}" target="_blank">
								{{$team->url_twitter}}
							</a>
							@endif
							
						</div><!-- /.txt -->

						<div class="txt" id="player">
							<h2 class="stitle">選手情報</h2>
							<h1>※▼をクリックでソートできます</h1><br>
							<table class="table player  table-striped">
								<thead>
									<tr>
										<th scope="col"></th>
										<th scope="col"><a href="?&sort=name&/#player" style="text-decoration: none">氏名<br>▼</a></th>
										<th scope="col"><a href="?&sort=school_year&/#player" style="text-decoration: none">学年<br>▼</a></th>
										<th scope="col"><a href="?&sort=position&/#player" style="text-decoration: none">ポジション<br>▼</a></th>
										<th scope="col"><a href="?&sort=height&/#player" style="text-decoration: none">身長<br>▼</a></th>
										<th scope="col"><a href="?&sort=related_team&/#player" style="text-decoration: none">前所属チーム<br>▼</a></th>
										<th scope="col"><a href="?&sort=goals&/#player" style="text-decoration: none">得点<br>▼</a></th>
									</tr>
								</thead>
								<tbody>
									@foreach($players as $i=>$player)
										<tr>
											<th scope="row">{{ $i + 1 }}</th>
											<td>{{ $player->name }}</td>
											<td>{{array_get(config('app.schoolYearAry'),$player->school_year)}}</td>
											<td>{{array_get(config('app.positionAry'),$player->position)}}</td>
											<td>{{ $player->height == 0.0? '':$player->height}}</td>
											<td>{{ $player->related_team }}</td>
											<td>{{ $player->goals }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>
						
						<div class="pageprev">
							<a href="{{route('front.team.index')}}">
								チーム一覧へ戻る
							</a>
						</div><!-- /.pageprev -->

					</div><!-- /.inner -->
				</div>

			</article>

		</div><!-- /.main -->

		@include('front.parts.side')

	</div><!-- /.inner -->
</main>
@stop

