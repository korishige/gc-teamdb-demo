@extends('layouts.team')

@section('css')
  <link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
  <link href="/team/css/common.css" rel="stylesheet" type="text/css" />
  <link href="/team/css/style.css?20210330" rel="stylesheet" type="text/css" />
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
          <div class="league_list">
            <ul>
              <li><a href="{{route('team.league.order',['id'=>$league->id])}}">リーグ順位</a></li>
              <li class="{{(preg_match('/team.league.match.all/',Route::currentRouteName()))?'on':''}}"><a href="{{route('team.league.match.all',['id'=>$league->id])}}">全試合</a></li>
              <li class="{{(preg_match('/team.league.match.self/',Route::currentRouteName()))?'on':''}}"><a href="{{route('team.league.match.self',['id'=>$league->id])}}">自チーム試合</a></li>
              <li><a href="{{route('team.league.table',['id'=>$league->id])}}">戦績表</a></li>
              <li class="on"><a href="{{route('team.league.goals',['id'=>$league->id])}}">得点</a></li>
              <li><a href="{{route('team.league.block',['id'=>$league->id])}}">ブロック選手</a></li>
              <li><a href="{{route('team.league.warning',['id'=>$league->id])}}">警告者</a></li>
              <li></li>
            </ul>
          </div><!-- /.league_list -->

          <div class="scorer">

            <div class="box">
              <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <th>順位</th>
                  <th>選 手 名</th>
                  <th>得 点</th>
                </tr>
                <?php $rank = 0; $pre_cnt = 0;?>
                @foreach($goals as $gp)
                <tr>
                  <td class="rank">
                    <?php
                    if($pre_cnt != $gp->cnt){
                    	$pre_cnt = $gp->cnt;
                    	$rank++;
					          }
                    ?>
                    {{$rank}}
                  </td>
                  <td class="player">
                    <?php $p = \App\Players::find($gp->id);?>
                    {{$p->name}}
                  </td>
                  <td class="score">
                    {{$gp->cnt}}
                  </td>
                </tr>
                @endforeach

              </table>
            </div><!-- /.box -->

          </div><!-- /.order -->

        </div><!-- /.inner -->
      </div>

{{--      <div class="pager">--}}
{{--        {!! $matches->appends(Input::except('page'))->render(); !!}--}}
{{--      </div><!-- /.pager -->--}}

    </section>
  </article>
@endsection
