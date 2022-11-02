<?php
// 1部 戦績表｜高円宮杯 JFA U-18 サッカーリーグ 福岡｜2020（年度変わったらここも変わる）
$page_title = sprintf("%s 戦績表 | %s | %s", isset($league->group->name) ? $league->group->name : '', env('title'), isset($league->year) ? $league->year : '');
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
    <span><a href="{{route('front.table.index')}}">戦歴表</a></span>
  </div><!-- /.bc -->

  <main class="content">

    <div class="year_list">
      <div class="inner">
        <ul>
          @for($year=(date('md')>='0320')?date('Y'):date('Y')-1; $year>=2022; $year--)
            <li class="{{($yyyy==$year)?'on':''}}"><a href="{{route('front.table.index',['groups'=>$group_id,'yyyy'=>$year])}}">{{$year}}年</a></li>
          @endfor
        </ul>
      </div><!-- /.inner -->
    </div><!-- /.year_list -->

    <div class="league_list">
      <div class="inner">
        <ul>
          @foreach($groups as $group)
          <li {{($group->id==$groups_id)?' class=on':''}}><a href="{{route('front.table.groups',['groups'=>$group->id,'yyyy'=>$yyyy])}}">{{ $group->name }}</a></li>
          {{-- <li {{($groups==2)?' class=on':''}}><a href="{{route('front.table.groups',['groups'=>2,'yyyy'=>$yyyy])}}">関西</a></li> --}}
          {{-- <li {{($groups==3)?' class=on':''}}><a href="{{route('front.table.groups',['groups'=>3,'yyyy'=>$yyyy])}}">3部</a></li> --}}
          @endforeach
        </ul>
      </div><!-- /.inner -->
    </div><!-- /.league_type -->

    {{-- @if($groups==2)
      <div class="part_list">
        <div class="inner">
          <ul>
            <li{{$_on2[2]}}><a href="{{route('front.table.index',['group_id'=>2,'yyyy'=>$yyyy])}}">2部A</a></li>
            <li{{$_on2[3]}}><a href="{{route('front.table.index',['group_id'=>3,'yyyy'=>$yyyy])}}">2部B</a></li>
            @if($yyyy==2020)
              <li{{$_on2[26]}}><a href="{{route('front.table.index',['group_id'=>26,'yyyy'=>$yyyy])}}">2部C</a></li>
              <li{{$_on2[27]}}><a href="{{route('front.table.index',['group_id'=>27,'yyyy'=>$yyyy])}}">2部D</a></li>
            @endif
          </ul>
        </div><!-- /.inner -->
      </div><!-- /.part_list -->
    @elseif($groups==3)
      @if($yyyy!=2020) --}}
      @if($groups==1)
        <div class="period_list">
          <div class="inner">
            <ul>
              <?php
                    if($yyyy==2021){
                      $g3_season1_groups = range(4,12)+[29];
                      $g3_season2_groups = range(13,24);
                    }else{
                      $g3_season1_groups = range(4,12);
                      $g3_season2_groups = range(13,24);
                    }
              ?>
              <li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.table.groups',['groups_id'=>1,'period'=>'first','yyyy'=>$yyyy])}}">1st stage</a></li>
              <li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.table.groups',['groups_id'=>1,'period'=>'second','yyyy'=>$yyyy])}}">2nd stage</a></li>
            </ul>
          </div><!-- /.inner -->
        </div><!-- /.period_list -->
      @else
        <div class="period_list">
          <div class="inner">
            <ul>
              <?php
                    if($yyyy==2021){
                      $g3_season1_groups = range(4,12)+[29];
                      $g3_season2_groups = range(13,24);
                    }else{
                      $g3_season1_groups = range(4,12);
                      $g3_season2_groups = range(13,24);
                    }
              ?>
              <li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.table.groups',['groups_id'=>3,'period'=>'first','yyyy'=>$yyyy])}}">1st stage</a></li>
              <li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.table.groups',['groups_id'=>3,'period'=>'second','yyyy'=>$yyyy])}}">2nd stage</a></li>
            </ul>
          </div><!-- /.inner -->
        </div><!-- /.period_list -->
      @endif
      {{-- @endif

      @if(in_array($group_id,range(4,12)))
      <div class="part_list" id="group31">
        <div class="inner">
          <ul>
            <li{{$_on2[4]}}><a href="{{route('front.table.index',['group_id'=>4])}}">3部A</a></li>
            <li{{$_on2[5]}}><a href="{{route('front.table.index',['group_id'=>5])}}">3部B</a></li>
            <li{{$_on2[6]}}><a href="{{route('front.table.index',['group_id'=>6])}}">3部C</a></li>
            <li{{$_on2[7]}}><a href="{{route('front.table.index',['group_id'=>7])}}">3部D</a></li>
            <li{{$_on2[8]}}><a href="{{route('front.table.index',['group_id'=>8])}}">3部E</a></li>
            <li{{$_on2[9]}}><a href="{{route('front.table.index',['group_id'=>9])}}">3部F</a></li>
            <li{{$_on2[10]}}><a href="{{route('front.table.index',['group_id'=>10])}}">3部G</a></li>
            <li{{$_on2[11]}}><a href="{{route('front.table.index',['group_id'=>11])}}">3部H</a></li>
            @if($yyyy!=2020)
              <li{{$_on2[12]}}><a href="{{route('front.table.index',['group_id'=>12])}}">3部I</a></li>
            @endif
            @if($yyyy==2022)
              <li{{$_on2[29]}}><a href="{{route('front.table.index',['group_id'=>29])}}">3部J</a></li>
            @endif
          </ul>
        </div><!-- /.inner -->
      </div>
      @elseif(in_array($group_id,range(13,24)))
      <div class="part_list" id="group32">
        <div class="inner">
          <ul>
            <li{{$_on2[13]}}><a href="{{route('front.table.index',['group_id'=>13])}}">上位A</a></li>
            <li{{$_on2[14]}}><a href="{{route('front.table.index',['group_id'=>14])}}">上位B</a></li>
            <li{{$_on2[15]}}><a href="{{route('front.table.index',['group_id'=>15])}}">上位C</a></li>
            <li{{$_on2[16]}}><a href="{{route('front.table.index',['group_id'=>16])}}">上位D</a></li>
            <li{{$_on2[17]}}><a href="{{route('front.table.index',['group_id'=>17])}}">上位E</a></li>
            <li{{$_on2[18]}}><a href="{{route('front.table.index',['group_id'=>18])}}">上位F</a></li>
            <li{{$_on2[19]}}><a href="{{route('front.table.index',['group_id'=>19])}}">下位A</a></li>
            <li{{$_on2[20]}}><a href="{{route('front.table.index',['group_id'=>20])}}">下位B</a></li>
            <li{{$_on2[21]}}><a href="{{route('front.table.index',['group_id'=>21])}}">下位C</a></li>
            <li{{$_on2[22]}}><a href="{{route('front.table.index',['group_id'=>22])}}">下位D</a></li>
            <li{{$_on2[23]}}><a href="{{route('front.table.index',['group_id'=>23])}}">下位E</a></li>
            <li{{$_on2[24]}}><a href="{{route('front.table.index',['group_id'=>24])}}">下位F</a></li>
          </ul>
        </div><!-- /.inner -->
      </div><!-- /.part_list -->
      @endif
    @endif --}}

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
                          <a href="{{route('front.order.index',['group_id'=>$league->group->id])}}">全順位</a></li>
                      <li><a href="{{route('front.match.index',['groups'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">試　合</a></li>
                      <li><a href="{{route('front.table.groups',['groups'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}" class="on">戦績表</a></li>
                      <li>
                          <a href="{{route('front.ranking.groups',['groups_id'=>$league->group->id,'yyyy'=>$yyyy, 'period'=>$period])}}">得点ランキング</a>
                      </li>
                    </ul>
                  </div><!-- /.snav -->

                  <div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
                  <div class="box stats">
                    @if(count($resultObj)>0)
                      <table cellspacing="0" cellpadding="0" border="0">
                        <thead>
                        <tr>
                          <th></th>
                          @foreach($resultObj[$league->id] as $result)
                            <th>{{$result->name}}
                          @endforeach
                          <th class="last">暫定順位</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php $k = 0;?>
                        @foreach($table[$league->id] as $i=>$row)
                          <tr class="home">
                            <td>{{$resultObj[$league->id][$k]->name}}</td>
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
                            <th class="last">{{$resultObj[$league->id][$k]->rank}}</th>
                          </tr>
						  <?php $k++;?>
                        @endforeach
                        </tbody>

                      </table>
                    @else
                      リーグ戦がありません
                    @endif
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

