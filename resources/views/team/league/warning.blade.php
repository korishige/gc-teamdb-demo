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
						<li><a href="{{route('team.league.table',['id'=>$league->id])}}">戦績表</a></li>
						<li><a href="{{route('team.league.goals',['id'=>$league->id])}}">得点</a></li>
            {{-- <li><a href="{{route('team.league.block',['id'=>$league->id])}}">ブロック選手</a></li> --}}
            <li class="on"><a href="{{route('team.league.warning',['id'=>$league->id, 'nendo'=>$league->year])}}">警告者</a></li>
            <li></li>
					</ul>
				</div><!-- /.league_list -->

				<div class="order">

					<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>

					<div class="box">

            {!!Form::open(['url'=>route('team.league.warning',['id'=>$league->id]),'method'=>'get','class'=>'row form-inline'])!!}
              {!!Form::hidden('id',\Input::get('oid'))!!}
              @if($opval == 0)
                {!!Form::select('group_id',\App\Groups::get()->lists('name', 'id'),\Input::has('group_id')?\Input::get('group_id'):'',['class'=>'form-control','style'=>'width:30%','placeholder'=>'リーグ選択'])!!}
                {!!Form::select('team_id',\App\Teams::get()->lists('name', 'id'),\Input::has('team_id')?\Input::get('team_id'):'',['class'=>'form-control','style'=>'width:30%','placeholder'=>'チーム選択'])!!}
              @else
                {!!Form::select('team_id',$teams,\Input::has('team_id')?\Input::get('team_id'):'',['class'=>'form-control','style'=>'width:30%','placeholder'=>'チーム選択'])!!}
              @endif
              {!!Form::select('school_year',config('app.schoolYearAry'),Input::has('school_year')?Input::get('school_year'):'',['class'=>'form-control','placeholder'=>'▼学年選択','style'=>'width:30%'])!!}
              {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'選手名検索','style'=>'width:30%'])!!}
              <div class="btn">
                <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:10px">
              </div><!-- /.btn -->
            {!!Form::close()!!}
            <br>

            @if(count($players) != 0)
						<table>
							<tr>
                <th style="width: 10%"><a href="?sort=group" style="text-decoration: none; color: white;">リーグ</a></th>
                <th style="width: 20%"><a href="?sort=team" style="text-decoration: none; color: white;">チーム名</a></th>
                <th style="width: 10%"><a href="?sort=school_year" style="text-decoration: none; color: white;">学年</a></th>
                <th style="width: 15%">名前</th>
                <th style="width: 10%"><a href="?sort=yellow" style="text-decoration: none; color: white;">警告</a></th>
                <th style="width: 10%"><a href="?sort=red" style="text-decoration: none; color: white;">退場</a></th>
                <th style="width: 15%"><a href="?sort=suspension_at" style="text-decoration: none; color: white;">出場停止</a></th>
                <th style="width: 10%"><a href="?sort=suspension_at" style="text-decoration: none; color: white;">詳細</a></th>
              </tr>
                @foreach($players as $i=>$player)
                  <tr {{($i%2)?'':'class="bgColor"'}}>
                    <td class="textC">{{$player->group_name}}</td>
                    <td class="team" style="text-align: center;">{{$player->team_name}}</td>
                    <td class="textC">{{array_get(config('app.schoolYearAry'),$player->school_year)}}</td>
                    <td class="textC">{{$player->player_name}}</td>
                    <td class="textC">{{$player->yellow}}</td>
                    <td class="textC">{{$player->red}}</td>
                    <td class="textC">{{$player->suspension_at}}</td>
                    <td class="textC last"><a href="{{route('team.league.wmatch',['player_id'=>$player->player_id, 'id'=>$league->id, 'nendo'=>$league->year])}}"><button class="btn btn-sm">試合確認</button></a></td>
                  </tr>
                @endforeach
						</table>
            @else
              該当する選手がいません
            @endif
					</div><!-- /.box -->
				</div><!-- /.order -->
			</div><!-- /.inner -->
		</div>
	</section>

</article>
@endsection
