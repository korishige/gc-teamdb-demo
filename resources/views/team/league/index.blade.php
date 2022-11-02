@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/league.css?20210330" rel="stylesheet" type="text/css" />
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

				<div class="index">

					<div class="search">
						<h2>絞り込み検索</h2>
						{!!Form::open(['method'=>'GET','url'=>route('team.league.index'),'class'=>'form form-horizontal form-label-left'])!!}
							<div class="row">
								{!!Form::text('year',\Input::has('year')?\Input::get('year'):'',['class'=>'form-control','style'=>'width:100px','placeholder'=>'年度'])!!}
								{!!Form::select('season',config('app.seasonAry'),\Input::has('season')?\Input::get('season'):'',['class'=>'form-control','style'=>'width:120px','placeholder'=>'期日選択'])!!}
								{!!Form::text('keyword',\Input::has('keyword')?\Input::get('keyword'):'',['class'=>'form-control','style'=>'width:300px','placeholder'=>'大会名キーワード'])!!}
								<div class="btn row">
									<input class="btn btn-info" style="margin-top:5px" type="submit" value="検索">

									<a href="{{route('team.league.index')}}">検索条件リセット</a>
								</div><!-- /.btn -->
							</div><!-- /.row -->
						{!!Form::close()!!}
					</div><!-- /.search -->

					<div class="list">
						<table>
							<tr>
								<th>年度</th>
								<th>大会名称(参加チーム数)</th>
								<th>操作</th>
							</tr>
							@foreach($leagueObj as $i=>$league)
							<tr>
								<td>{{$league->year}}</td>
								<td>{{array_get(\App\Groups::all()->lists('name','id'),$league->group_id)}} | {{$league->name}} ({{$league->team->count()}}チーム)</td>
								<td>
									<ul>
										<li><a href="{{route('team.league.match.all',['id'=>$league->id])}}">全試合</a></li>
										<li><a href="{{route('team.league.match.self',['id'=>$league->id])}}">自チーム試合</a></li>
										<li><a href="{{route('team.league.order',['id'=>$league->id])}}">順位</a></li>
										<li><a href="{{route('team.league.table',['id'=>$league->id])}}">戦績表</a></li>
										<li><a href="{{route('team.league.goals',['id'=>$league->id])}}">得点</a></li>
										{{-- <li><a href="{{route('team.league.block',['id'=>$league->id])}}">ﾌﾞﾛｯｸ</a></li> --}}
										<li><a href="{{route('team.league.warning',['id'=>$league->id, 'nendo'=>$league->year])}}">警告者</a></li>
										<li></li>
									</ul>
								</td>
							</tr>
							@endforeach
						</table>
					</div><!-- /.list -->

				</div><!-- /.index -->

			</div><!-- /.inner -->
		</div>
		{!! $leagueObj->appends(Input::except('page'))->render(); !!}
	</section>
</article>
@endsection
