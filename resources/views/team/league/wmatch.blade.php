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
					<h1>{{$player->name}}選手の警告・退場を受けた試合</h1>
				</div><!-- /.league_list -->

				<div class="order">

					<div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>

					<div class="box">

            @if(count($cards) != 0)
						<table>
							<tr>
                <th style="width: 10%"><a style="text-decoration: none; color: white;">対戦カード</a></th>
                <th style="width: 20%"><a style="text-decoration: none; color: white;">試合日</a></th>
                {{-- <th style="width: 10%"><a style="text-decoration: none; color: white;">詳細</a></th> --}}
              </tr>
                @foreach($cards as $i=>$card)
                  <tr {{($i%2)?'':'class="bgColor"'}}>
                    <td class="textC">{{$card->match->home0->name}} vs {{$card->match->away0->name}}</td>
                    <td class="team" style="text-align: center;">{{$card->match->match_at}}</td>
                    {{-- <td class="textC last"><a href="{{route('team.match.edit',['id'=>$card->match->id])}}"><button class="btn btn-sm">試合確認</button></a></td> --}}
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
