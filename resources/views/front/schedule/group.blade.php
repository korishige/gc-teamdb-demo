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
                $('#group31').show();
                $('#group32').hide();
                $('#g31_on').attr('class', 'on');
                $('#g32_on').attr('class', '');
            });
            $('.group3_second').on('click', () => {
                $('#group32').show();
                $('#group31').hide();
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
            <?php
            $_on = [];
            foreach(range(1,3) as $k){
                if($k==$groups){
                    $_on[$k] = ' class=on';
                }else{
                    $_on[$k] = '';
                }
            }
            $_on2 = [];
            foreach(range(2,29) as $k){
                if($k==$group_id){
                    $_on2[$k] = ' class=on';
                }else{
                    $_on2[$k] = '';
                }
            }
            ?>
            <ul>
                {{-- <li{{$_on[1]}}><a href="{{route('front.schedule.index',['groups'=>1])}}">1部</a></li>
                <li{{$_on[2]}}><a href="{{route('front.schedule.index',['groups'=>2])}}">2部</a></li> --}}
                <li{{$_on[3]}}><a href="{{route('front.schedule.index',['groups'=>3])}}">3部</a></li>
            </ul>
        </div><!-- /.inner -->
    </div><!-- /.league_type -->

    {{-- @if($groups==2)
    <div class="part_list">
        <div class="inner">
            <ul>
                <li{{$_on2[2]}}><a href="{{route('front.schedule.group',['group_id'=>2])}}">2部A</a></li>
                <li{{$_on2[3]}}><a href="{{route('front.schedule.group',['group_id'=>3])}}">2部B</a></li>
                @if(config('app.nendo')==2020)
                <li{{$_on2[26]}}><a href="{{route('front.schedule.group',['group_id'=>26])}}">2部C</a></li>
                <li{{$_on2[27]}}><a href="{{route('front.schedule.group',['group_id'=>27])}}">2部D</a></li>
                @endif
            </ul>
        </div><!-- /.inner -->
    </div>
    @elseif($groups==3) --}}
            <div class="period_list">
                <div class="inner">
                    <ul>
                        <li id="g31_on" class="{{in_array($group_id,range(3,12))?'on':''}}"><a class="group3_first">前　期</a></li>
                        <li id="g32_on" class="{{in_array($group_id,range(13,24))?'on':''}}"><a class="group3_second">後　期</a></li>
                    </ul>
                </div><!-- /.inner -->
            </div><!-- /.period_list -->
            <div class="part_list" id="group31" style="{{in_array($group_id,range(13,24))?'display:none':''}}">
                <div class="inner">
                    <ul>
                        <li{{$_on2[4]}}><a href="{{route('front.schedule.group',['group_id'=>4, 'period'=>'first'])}}">3部A</a></li>
                        <li{{$_on2[5]}}><a href="{{route('front.schedule.group',['group_id'=>5, 'period'=>'first'])}}">3部B</a></li>
                        <li{{$_on2[6]}}><a href="{{route('front.schedule.group',['group_id'=>6, 'period'=>'first'])}}">3部C</a></li>
                        <li{{$_on2[7]}}><a href="{{route('front.schedule.group',['group_id'=>7, 'period'=>'first'])}}">3部D</a></li>
                        <li{{$_on2[8]}}><a href="{{route('front.schedule.group',['group_id'=>8, 'period'=>'first'])}}">3部E</a></li>
                        <li{{$_on2[9]}}><a href="{{route('front.schedule.group',['group_id'=>9, 'period'=>'first'])}}">3部F</a></li>
                        <li{{$_on2[10]}}><a href="{{route('front.schedule.group',['group_id'=>10, 'period'=>'first'])}}">3部G</a></li>
                        <li{{$_on2[11]}}><a href="{{route('front.schedule.group',['group_id'=>11, 'period'=>'first'])}}">3部H</a></li>
                        @if(config('app.nendo')!=2020)
                            <li{{$_on2[12]}}><a href="{{route('front.schedule.group',['group_id'=>12, 'period'=>$period])}}">3部I</a></li>
                        @endif
                        @if(config('app.nendo')==2022)
                            <li{{$_on2[29]}}><a href="{{route('front.schedule.group',['group_id'=>29, 'period'=>$period])}}">3部J</a></li>
                        @endif
                    </ul>
                </div><!-- /.inner -->
            </div>
            <div class="part_list" id="group32" style="{{in_array($group_id,range(3,12))?'display:none':''}}">
                <div class="inner">
                    <ul>
                        <li{{$_on2[13]}}><a href="{{route('front.schedule.group',['group_id'=>13, 'period'=>'second'])}}">上位A</a></li>
                        <li{{$_on2[14]}}><a href="{{route('front.schedule.group',['group_id'=>14, 'period'=>'second'])}}">上位B</a></li>
                        <li{{$_on2[15]}}><a href="{{route('front.schedule.group',['group_id'=>15, 'period'=>'second'])}}">上位C</a></li>
                        <li{{$_on2[16]}}><a href="{{route('front.schedule.group',['group_id'=>16, 'period'=>'second'])}}">上位D</a></li>
                        <li{{$_on2[17]}}><a href="{{route('front.schedule.group',['group_id'=>17, 'period'=>'second'])}}">上位E</a></li>
                        <li{{$_on2[18]}}><a href="{{route('front.schedule.group',['group_id'=>18, 'period'=>'second'])}}">上位F</a></li>
                        <li{{$_on2[19]}}><a href="{{route('front.schedule.group',['group_id'=>19, 'period'=>'second'])}}">下位A</a></li>
                        <li{{$_on2[20]}}><a href="{{route('front.schedule.group',['group_id'=>20, 'period'=>'second'])}}">下位B</a></li>
                        <li{{$_on2[21]}}><a href="{{route('front.schedule.group',['group_id'=>21, 'period'=>'second'])}}">下位C</a></li>
                        <li{{$_on2[22]}}><a href="{{route('front.schedule.group',['group_id'=>22, 'period'=>'second'])}}">下位D</a></li>
                        <li{{$_on2[23]}}><a href="{{route('front.schedule.group',['group_id'=>23, 'period'=>'second'])}}">下位E</a></li>
                        <li{{$_on2[24]}}><a href="{{route('front.schedule.group',['group_id'=>24, 'period'=>'second'])}}">下位F</a></li>
                    </ul>
                </div><!-- /.inner -->
            </div><!-- /.part_list -->
    {{-- @endif --}}
    <div class="inner">
        <div class="main">

        <article>
            <section>
                <div id="schedule">
                    <div class="inner">
                        @forelse($leagues as $league)
                        <div class="head">
                            <h2>{{$league->name}}　{{array_get(Config::get('app.seasonAry'),$league->season)}}</h2>
                            <span>最終更新日: {{$league->matches1->max('updated_at')}}</span>
                        </div><!-- /.head -->
                        
                        <div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
                        <div class="box">
                            <table>
                                <tr>
                                    <th>節</th>
                                    <th>日時</th>
                                    <th>開始</th>
                                    <th>対戦カード</th>
                                    <th>会場</th>
                                </tr>
                                @foreach($matches as $match)
                                <tr>
                                    <td>{{$match->section}}</td>
                                    <td>{{date('Y/m/d',strtotime($match->match_date))}}</td>
                                    <td>{{$match->match_time}}</td>
                                    <td class="match">
                                        <span>{{$match->home0->name}}</span>
                                        <span>
                                        @if($match->is_filled and $match->match_date < date('Y-m-d 06:00:00'))
                                        {{$match->home_pt}}　vs　{{$match->away_pt}}
                                        @endif
                                        </span>
                                        <span>{{$match->away0->name}}</span>
                                    </td>
                                    <td>{{$match->place->name or ''}}</td>
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

