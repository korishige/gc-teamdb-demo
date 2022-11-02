<?php
// 1部 全順位｜高円宮杯 JFA U-18 サッカーリーグ 福岡｜2020（年度変わったらここも変わる）
$page_title = sprintf("%s 全順位 | %s | %s", isset($league->group->name) ? $league->group->name : '', env('title'), isset($league->year) ? $league->year : '');
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
                        <li class="{{($yyyy==$year)?'on':''}}"><a href="{{route('front.order.index',['groups_id'=>1,'yyyy'=>$year])}}">{{$year}}年</a></li>
                    @endfor
                </ul>
            </div><!-- /.inner -->
        </div><!-- /.year_list -->

        <div class="league_list">
            <div class="inner">
                <ul>
					<?php
					// $_on = [];
					// $_id = $groups_id;
					// foreach (range(1, 3) as $k) {
					// 	if ($k == $groups_id) {
					// 		$_on[$k] = ' class=on';
					// 	} else {
					// 		$_on[$k] = '';
					// 	}
					// }
					// $_on2 = [];
					// foreach (range(2, 29) as $k) {
					// 	$_on2[$k] = '';
					// }
					?>
                    <li {{($group_id==1)?'class=on':''}}><a href="{{route('front.order.index',['groups_id'=>1,'yyyy'=>$yyyy])}}">九州</a></li>
                    <li {{($group_id==2)?'class=on':''}}><a href="{{route('front.order.index',['groups_id'=>2,'yyyy'=>$yyyy])}}">関西</a></li>
                    {{-- <li {{($groups_id==3)?'class=on':''}}><a href="{{route('front.order.index',['groups_id'=>3,'yyyy'=>$yyyy])}}">3部</a></li> --}}
                </ul>
            </div><!-- /.inner -->
        </div><!-- /.league_type -->

        {{-- @if($groups_id==2)
            <div class="part_list">
                <div class="inner">
                    <ul>
                        <li{{$_on2[2]}}><a href="{{route('front.order.group',['group_id'=>2,'yyyy'=>$yyyy])}}">2部A</a></li>
                        <li{{$_on2[3]}}><a href="{{route('front.order.group',['group_id'=>3,'yyyy'=>$yyyy])}}">2部B</a></li>
                        @if($yyyy==2020)
                            <li{{$_on2[26]}}><a href="{{route('front.order.group',['group_id'=>26,'yyyy'=>$yyyy])}}">2部C</a></li>
                            <li{{$_on2[27]}}><a href="{{route('front.order.group',['group_id'=>27,'yyyy'=>$yyyy])}}">2部D</a></li>
                        @endif
                    </ul>
                </div><!-- /.inner -->
            </div><!-- /.part_list --> --}}
        {{-- @elseif($groups_id==3) --}}
            {{-- @if($yyyy!=2020) --}}
                @if($group_id==1)
                    <div class="period_list">
                        <div class="inner">
                            <ul>
                                <li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.order.groups',['groups_id'=>1,'yyyy'=>$yyyy,'period'=>'first'])}}">1st stage</a></li>
                                <li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.order.groups',['groups_id'=>1,'yyyy'=>$yyyy,'period'=>'second'])}}">2nd stage</a></li>
                            </ul>
                        </div><!-- /.inner -->
                    </div><!-- /.period_list -->
                @else
                    <div class="period_list">
                        <div class="inner">
                            <ul>
                                <li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.order.groups',['groups_id'=>3,'yyyy'=>$yyyy,'period'=>'first'])}}">1st stage</a></li>
                                <li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.order.groups',['groups_id'=>3,'yyyy'=>$yyyy,'period'=>'second'])}}">2nd stage</a></li>
                            </ul>
                        </div><!-- /.inner -->
                    </div><!-- /.period_list -->
                @endif
            {{-- @endif --}}
            {{-- @if($period=='first')
            <div class="part_list" id="group31">
                <div class="inner">
                    <ul> --}}
                        {{-- TODO:ここに、３部の場合の前期・後期の表示変更も対応する必要あり--}}
                        {{-- <li{{$_on2[4]}}><a href="{{route('front.order.group',['group_id'=>4,'yyyy'=>$yyyy])}}">3部A</a></li>
                        <li{{$_on2[5]}}><a href="{{route('front.order.group',['group_id'=>5,'yyyy'=>$yyyy])}}">3部B</a></li>
                        <li{{$_on2[6]}}><a href="{{route('front.order.group',['group_id'=>6,'yyyy'=>$yyyy])}}">3部C</a></li>
                        <li{{$_on2[7]}}><a href="{{route('front.order.group',['group_id'=>7,'yyyy'=>$yyyy])}}">3部D</a></li>
                        <li{{$_on2[8]}}><a href="{{route('front.order.group',['group_id'=>8,'yyyy'=>$yyyy])}}">3部E</a></li>
                        <li{{$_on2[9]}}><a href="{{route('front.order.group',['group_id'=>9,'yyyy'=>$yyyy])}}">3部F</a></li>
                        <li{{$_on2[10]}}><a href="{{route('front.order.group',['group_id'=>10,'yyyy'=>$yyyy])}}">3部G</a></li>
                        <li{{$_on2[11]}}><a href="{{route('front.order.group',['group_id'=>11,'yyyy'=>$yyyy])}}">3部H</a></li>
                        @if(config('app.nendo')!=2020)
                            <li{{$_on2[12]}}><a href="{{route('front.order.group',['group_id'=>12,'yyyy'=>$yyyy])}}">3部I</a></li>
                        @endif
                        @if(config('app.nendo')==2022)
                            <li{{$_on2[29]}}><a href="{{route('front.order.group',['group_id'=>29,'yyyy'=>$yyyy])}}">3部J</a></li>
                        @endif
                    </ul>
                </div><!-- /.inner -->
            </div><!-- /.part_list -->
            @elseif($period=='second' and $yyyy!=2020)
                <div class="part_list" id="group32">
                    <div class="inner">
                        <ul>
                            <li{{$_on2[14]}}><a href="{{route('front.order.group',['group_id'=>13,'yyyy'=>$yyyy])}}">上位A</a></li>
                            <li{{$_on2[15]}}><a href="{{route('front.order.group',['group_id'=>14,'yyyy'=>$yyyy])}}">上位B</a></li>
                            <li{{$_on2[16]}}><a href="{{route('front.order.group',['group_id'=>15,'yyyy'=>$yyyy])}}">上位C</a></li>
                            <li{{$_on2[17]}}><a href="{{route('front.order.group',['group_id'=>16,'yyyy'=>$yyyy])}}">上位D</a></li>
                            <li{{$_on2[18]}}><a href="{{route('front.order.group',['group_id'=>17,'yyyy'=>$yyyy])}}">上位E</a></li>
                            <li{{$_on2[19]}}><a href="{{route('front.order.group',['group_id'=>18,'yyyy'=>$yyyy])}}">上位F</a></li>
                            <li{{$_on2[20]}}><a href="{{route('front.order.group',['group_id'=>19,'yyyy'=>$yyyy])}}">下位A</a></li>
                            <li{{$_on2[21]}}><a href="{{route('front.order.group',['group_id'=>20,'yyyy'=>$yyyy])}}">下位B</a></li>
                            <li{{$_on2[22]}}><a href="{{route('front.order.group',['group_id'=>21,'yyyy'=>$yyyy])}}">下位C</a></li>
                            <li{{$_on2[23]}}><a href="{{route('front.order.group',['group_id'=>22,'yyyy'=>$yyyy])}}">下位D</a></li>
                            <li{{$_on2[24]}}><a href="{{route('front.order.group',['group_id'=>23,'yyyy'=>$yyyy])}}">下位E</a></li>
                            <li{{$_on2[25]}}><a href="{{route('front.order.group',['group_id'=>24,'yyyy'=>$yyyy])}}">下位F</a></li>
                        </ul>
                    </div><!-- /.inner -->
                </div><!-- /.part_list -->
            @endif --}}
        {{-- @endif --}}

        <div class="inner">
            <div class="main">

                <article>
                    <section>
                        <div id="ranking">
                            <div class="inner">
                                @forelse($leagues as $league)
                                    @if($yyyy!=2020 and ($league->group_id == 26 or $league->group_id == 27))
										                <?php continue; ?>
                                    @endif
                                    {{-- TODO:ここに、３部の場合の前期・後期の表示変更も対応する必要あり--}}

                                    <div class="head">
                                        <h2>{{$league->name}}　{{array_get(Config::get('app.seasonAry'),$league->season)}}</h2>
                                        <span>最終更新日: {{$league->matches->max('updated_at')}}</span>
                                    </div><!-- /.head -->

                                    <div class="snav">
                                        <ul>
                                            <li>
                                                <a href="{{route('front.order.index',['group_id'=>$league->group->id])}}"
                                                   class="on">全順位</a></li>
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

