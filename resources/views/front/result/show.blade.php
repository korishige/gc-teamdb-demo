<?php
// {記事のタイトル「6/9 佐賀商業 4-1 柳ヶ浦【前期第6節】」とか}｜高円宮杯 JFA U-18 サッカーリーグ 福岡｜2020（年度変わったらここも変わる）
$nendo = date('Y', strtotime('-3 month'));
$title = sprintf("%s %s %d-%d %s 【%s第%s節】", date('m/d',strtotime($match->match_date)), $match->home0->name, $match->home_pt, $match->away_pt, $match->away0->name, array_get(Config::get('app.seasonAry'),$match->leagueOne->season), $match->section or ' - ');
$page_title = $title .' ｜ '.env('title').' | '.$nendo;
?>
@extends('layouts.front',['page_title'=>$page_title])

@section('css')
<link href="/css/results.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>結果速報</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.result.index')}}">結果速報</a></span>
    </div><!-- /.bc -->

    <main class="content">
        
        <div class="league_list">
            <div class="inner">
            <?php
            $_on = [];
            foreach([1,2,3] as $k){
                if($k==$match->leagueOne->group->grouping){
                    $_on[$k] = ' class=on';
                }else{
                    $_on[$k] = '';
                }
            }
            $_on2 = [];
            foreach(range(2,29) as $k){
                if($k==$match->leagueOne->group_id){
                    $_on2[$k] = ' class=on';
                }else{
                    $_on2[$k] = '';
                }
            }
            ?>
                <ul>
                    <li{{$_on[1]}}><a href="{{route('front.result.index',['groups'=>1])}}">九州</a></li>
                    <li{{$_on[2]}}><a href="{{route('front.result.index',['groups'=>2])}}">関西</a></li>
                    {{-- <li{{$_on[3]}}><a href="{{route('front.result.index',['groups'=>3])}}">3部</a></li> --}}
                </ul>
            </div><!-- /.inner -->
        </div><!-- /.league_type -->
        
        <div class="inner">
        <div class="main">

            {{-- @if($match->leagueOne->group->grouping==2)
            <div class="part_list">
                <div class="inner">
                    <ul>
                        <li{{$_on2[2]}}><a href="{{route('front.result.group',['group_id'=>2])}}">2部A</a></li>
                        <li{{$_on2[3]}}><a href="{{route('front.result.group',['group_id'=>3])}}">2部B</a></li>
                        @if(config('app.nendo')==2020)
                        <li{{$_on2[26]}}><a href="{{route('front.result.group',['group_id'=>26])}}">2部C</a></li>
                        <li{{$_on2[27]}}><a href="{{route('front.result.group',['group_id'=>27])}}">2部D</a></li>
                        @endif
                    </ul>
                </div><!-- /.inner -->
            </div>
            @elseif($match->leagueOne->group->grouping==3)
            <div class="part_list">
                <div class="inner">
                    <ul>
                        <li{{$_on2[4]}}><a href="{{route('front.result.group',['group_id'=>4])}}">3部A</a></li>
                        <li{{$_on2[5]}}><a href="{{route('front.result.group',['group_id'=>5])}}">3部B</a></li>
                        <li{{$_on2[6]}}><a href="{{route('front.result.group',['group_id'=>6])}}">3部C</a></li>
                        <li{{$_on2[7]}}><a href="{{route('front.result.group',['group_id'=>7])}}">3部D</a></li>
                        <li{{$_on2[8]}}><a href="{{route('front.result.group',['group_id'=>8])}}">3部E</a></li>
                        <li{{$_on2[9]}}><a href="{{route('front.result.group',['group_id'=>9])}}">3部F</a></li>
                        <li{{$_on2[10]}}><a href="{{route('front.result.group',['group_id'=>10])}}">3部G</a></li>
                        <li{{$_on2[11]}}><a href="{{route('front.result.group',['group_id'=>11])}}">3部H</a></li>
                        @if(config('app.nendo')!=2020)
                        <li{{$_on2[12]}}><a href="{{route('front.result.group',['group_id'=>12])}}">3部I</a></li>
                        @endif
                        @if(config('app.nendo')==2022)
                            <li{{$_on2[29]}}><a href="{{route('front.result.group',['group_id'=>29])}}">3部J</a></li>
                        @endif
                    </ul>
                </div><!-- /.inner -->
            </div>
            @endif --}}

        <article>
            <section>
            
                <div id="results_detail">
                    <div class="inner">
                        
                        <div class="set">
                           
                            <div class="head">
                                <h2>{{array_get(Config::get('app.seasonAry'),$match->leagueOne->season)}} {{$match->leagueOne->group->name}} 第{{$match->section or ' - '}}節  {{date('m/d',strtotime($match->match_date))}}
                                            （{{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}}）</h2>
                                <span>会場：{{$match->venue->name}}</span>
                            </div><!-- /.head -->

                            <div class="score_box">
                                <div class="col">
                                    <a href="{{route('front.team.show',['id'=>$match->home_id])}}">{{$match->home0->name}}</a>
                                </div><!-- /.col -->
                                <div class="col number">
                                    <div class="box">
                                        @if($match->is_filled)
                                        {{$match->home_pt}}
                                        @else
                                        -
                                        @endif
                                    </div><!-- /.box -->
                                    <div class="box">
                                        <?php
                                        $home_first_half = \App\Goals::where('match_id',$match->id)->where('h_or_a','home')->where('time','<=',50)->count('id');
                                        $home_last_half = \App\Goals::where('match_id',$match->id)->where('h_or_a','home')->where('time','>',50)->count('id');
                                        $away_first_half = \App\Goals::where('match_id',$match->id)->where('h_or_a','away')->where('time','<=',50)->count('id');
                                        $away_last_half = \App\Goals::where('match_id',$match->id)->where('h_or_a','away')->where('time','>',50)->count('id');
                                        ?>
                                        @if($match->is_filled)
                                            <span>{{$home_first_half}} - {{$away_first_half}}</span>
                                            <span>{{$home_last_half}} - {{$away_last_half}}</span>
                                            @if($match->home_pt == $match->away_pt)
                                            PK<span>{{$match->home_pk}} - {{$match->away_pk}}</span>
                                            @endif
                                        @endif
                                    </div><!-- /.box -->
                                    <div class="box">
                                        @if($match->is_filled)
                                            {{$match->away_pt}}
                                        @else
                                            -
                                        @endif
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                                <div class="col">
                                    <a href="{{route('front.team.show',['id'=>$match->away_id])}}">{{$match->away0->name}}</a>
                                </div><!-- /.col -->
                            </div><!-- /.score -->
                            
                            <div class="img">
                                <?php
                                    if(!empty($match->home_photo)){
                                        $home_img = "/upload/300/".$match->home_photo;
                                    }elseif(!empty($match->home->team->group_img)){
                                        $home_img = "/upload/300/".$match->home->team->group_img;
                                    }else{
                                        $home_img = "/img/common/dammy_img_league.png";
                                    }
                                    if(!empty($match->away_photo)){
                                        $away_img = "/upload/300/".$match->away_photo;
                                    }elseif(!empty($match->away->team->group_img)){
                                        $away_img = "/upload/300/".$match->away->team->group_img;
                                    }else{
                                        $away_img = "/img/common/dammy_img_league.png";
                                    }
                                    ?>


                                <img src="{{$home_img}}">
                                <img src="{{$away_img}}">
                            </div><!-- /.img -->

                            <div class="info">
                                @if($match->home_pt != $match->away_pt && $match->home_pt > $match->away_pt)
                                    <div class="mom">
                                        <h2>
                                            MOM　
                                        {{$match->mom_hplayer->name or '削除済みプレイヤー'}}
                                        </h2>
                                    </div>
                                @elseif($match->home_pt != $match->away_pt && $match->home_pt < $match->away_pt)
                                    <div class="mom">
                                        <h2>
                                            MOM　
                                        {{$match->mom_aplayer->name or '削除済みプレイヤー'}}
                                        </h2>
                                    </div>
                                @elseif($match->home_pt == $match->away_pt && $match->home_pk > $match->away_pk)
                                    <div class="mom">
                                        <h2>
                                            MOM　
                                        {{$match->mom_hplayer->name or '削除済みプレイヤー'}}
                                        </h2>
                                    </div>
                                @elseif($match->home_pt == $match->away_pt && $match->home_pk < $match->away_pk)
                                    <div class="mom">
                                        <h2>
                                            MOM　
                                        {{$match->mom_aplayer->name or '削除済みプレイヤー'}}
                                        </h2>
                                    </div>
                                @endif
                                @if(\App\Goals::where('match_id',$match->id)->exists())
                                <div class="scorer">
                                    <h2>得点者</h2>
                                    <div class="row">
                                        <div class="home_col">
                                            <dl>
                                                <?php
                                                $goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','home')->get();
                                                ?>
                                                @foreach($goals as $goal)
                                                <div>
                                                    <dd>
                                                        {{array_get(config('app.matchTimeAry'),$goal->time)}}　
                                                        @if($goal->goal_player_id!=0)
                                                        {{$goal->player->name or '削除済みプレイヤー'}}
                                                        @else
                                                        オウンゴール
                                                        @endif
                                                    </dd>
                                                </div>
                                                @endforeach
                                            </dl>
                                        </div><!-- /.col -->
                                        <div class="away_col">
                                            <dl>
                                                <?php
                                                $goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','away')->get();
                                                ?>
                                                @foreach($goals as $goal)
                                                <div>
                                                    <dd>
                                                        {{array_get(config('app.matchTimeAry'),$goal->time)}}　
                                                        @if($goal->goal_player_id!=0)
                                                        {{$goal->player->name or '削除済みプレイヤー'}}
                                                        @else
                                                        オウンゴール
                                                        @endif
                                                    </dd>
                                                </div>
                                                @endforeach
                                            </dl>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div><!-- /.scorer -->
                                @endif

                                @if($match->note != null || $match->note != '')
                                    <div class="remarks">
                                        <h2>マッチレポート</h2>
                                        <br>
                                        {!!nl2br($match->note)!!}
                                    </div><!-- /.remarks -->
                                @endif
                            </div><!-- /.info -->

                            <div class="photo">
                                <h2>フォトギャラリー</h2>
                                <div class="row">
                                    @forelse($match->gallery as $photo)
                                    <a href="/upload/original/{{$photo->img}}"><img src="/upload/original/{{$photo->img}}"></a>
                                    @empty
                                    画像は登録されていません
                                    @endforelse
                                </div><!-- /.row -->
                            </div><!-- /.photo -->
                        </div><!-- /.set -->
                        
                        {{--
                        <div class="ranking">
                            <div class="head">
                                <h2>2020年度　○○大会　前期　1部</h2>
                                <span>最終更新日: 2019-10-06 13:46:25</span>
                            </div><!-- /.head -->
                            
                            <div class="tabs">
                            
                                <input id="all" type="radio" name="tab_item" checked>
                                <label class="tab_item" for="all">全順位</label>
                                <input id="match" type="radio" name="tab_item">
                                <label class="tab_item" for="match">試　合</label>
                                <input id="stats" type="radio" name="tab_item">
                                <label class="tab_item" for="stats">戦績表</label>
                                
                                <div class="tab_content" id="all_content">
                                
                                <div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
                                
                                
                                <div class="tab_content_description">
                                    <div class="box">
                                    <table>
                                        <tr>
                                            <th>順位<span></span></th>
                                            <th>チーム名<span></span></th>
                                            <th>勝点<span></span></th>
                                            <th>試合数<span></span></th>
                                            <th>勝数<span></span></th>
                                            <th>引分数<span></span></th>
                                            <th>敗数<span></span></th>
                                            <th>得点<span></span></th>
                                            <th>失点<span></span></th>
                                            <th>得失点差<span></span></th>
                                        </tr>
                                        <tr>
                                            <td class="textC">1</td>
                                            <td class="team">大津</td>
                                            <td class="textC">34</td>
                                            <td class="textC">18</td>
                                            <td class="textC">10</td>
                                            <td class="textC">4</td>
                                            <td class="textC">4</td>
                                            <td class="textC">39</td>
                                            <td class="textC">20</td>
                                            <td class="textC last">19</td>
                                        </tr>
                                                                    <tr >
                                            <td class="textC">2</td>
                                            <td class="team">東福岡</td>
                                            <td class="textC">34</td>
                                            <td class="textC">18</td>
                                            <td class="textC">11</td>
                                            <td class="textC">1</td>
                                            <td class="textC">6</td>
                                            <td class="textC">49</td>
                                            <td class="textC">31</td>
                                            <td class="textC last">18</td>
                                        </tr>
                                        <tr>
                                            <td class="textC">3</td>
                                            <td class="team">長崎総附</td>
                                            <td class="textC">34</td>
                                            <td class="textC">18</td>
                                            <td class="textC">11</td>
                                            <td class="textC">1</td>
                                            <td class="textC">6</td>
                                            <td class="textC">44</td>
                                            <td class="textC">28</td>
                                            <td class="textC last">16</td>
                                        </tr>
                                                                    <tr >
                                            <td class="textC">4</td>
                                            <td class="team">神村学園</td>
                                            <td class="textC">28</td>
                                            <td class="textC">18</td>
                                            <td class="textC">8</td>
                                            <td class="textC">4</td>
                                            <td class="textC">6</td>
                                            <td class="textC">41</td>
                                            <td class="textC">32</td>
                                            <td class="textC last">9</td>
                                        </tr>
                                        <tr>
                                            <td class="textC">5</td>
                                            <td class="team">熊本国府</td>
                                            <td class="textC">27</td>
                                            <td class="textC">18</td>
                                            <td class="textC">8</td>
                                            <td class="textC">3</td>
                                            <td class="textC">7</td>
                                            <td class="textC">28</td>
                                            <td class="textC">27</td>
                                            <td class="textC last">1</td>
                                        </tr>
                                                                    <tr >
                                            <td class="textC">6</td>
                                            <td class="team">日章学園</td>
                                            <td class="textC">26</td>
                                            <td class="textC">18</td>
                                            <td class="textC">8</td>
                                            <td class="textC">2</td>
                                            <td class="textC">8</td>
                                            <td class="textC">35</td>
                                            <td class="textC">37</td>
                                            <td class="textC last">-2</td>
                                        </tr>
                                        <tr>
                                            <td class="textC">7</td>
                                            <td class="team">九国大付属</td>
                                            <td class="textC">26</td>
                                            <td class="textC">18</td>
                                            <td class="textC">8</td>
                                            <td class="textC">2</td>
                                            <td class="textC">8</td>
                                            <td class="textC">30</td>
                                            <td class="textC">38</td>
                                            <td class="textC last">-8</td>
                                        </tr>
                                                                    <tr >
                                            <td class="textC">8</td>
                                            <td class="team">宮崎日大</td>
                                            <td class="textC">17</td>
                                            <td class="textC">18</td>
                                            <td class="textC">5</td>
                                            <td class="textC">2</td>
                                            <td class="textC">11</td>
                                            <td class="textC">28</td>
                                            <td class="textC">44</td>
                                            <td class="textC last">-16</td>
                                        </tr>
                                        <tr>
                                            <td class="textC">9</td>
                                            <td class="team">筑陽学園</td>
                                            <td class="textC">17</td>
                                            <td class="textC">18</td>
                                            <td class="textC">5</td>
                                            <td class="textC">2</td>
                                            <td class="textC">11</td>
                                            <td class="textC">33</td>
                                            <td class="textC">52</td>
                                            <td class="textC last">-19</td>
                                        </tr>
                                                                    <tr >
                                            <td class="textC">10</td>
                                            <td class="team">東海大福岡</td>
                                            <td class="textC">14</td>
                                            <td class="textC">18</td>
                                            <td class="textC">3</td>
                                            <td class="textC">5</td>
                                            <td class="textC">10</td>
                                            <td class="textC">32</td>
                                            <td class="textC">50</td>
                                            <td class="textC last">-18</td>
                                        </tr>
                                    </table>
                                    </div><!-- /.box -->
                                </div>
                                </div>

                                <div class="tab_content" id="match_content">
                                
                                <div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
                                
                                <div class="tab_content_description">
                                    <div class="box">
                                    <table cellspacing="0" cellpadding="0" border="0">
                                            <tr>
                                                <th>キックオフ</th>
                                                <th></th>
                                                <th>試合状況</th>
                                                <th></th>
                                                <th>試合会場</th>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/06 (日)
                                                </td>
                                                <td class="team">
                                                    東海大福岡
                                                </td>
                                                <td class="score">
                                                    5&nbsp;-&nbsp;2
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    筑陽学園
                                                </td>
                                                <td>タイガーフィールド</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/06
                                                    (
                                                    日
                                                    )
                                                </td>
                                                <td class="team">
                                                    東福岡
                                                </td>
                                                <td class="score">
                                                    0&nbsp;-&nbsp;1
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    大津
                                                </td>
                                                <td>東福岡高校</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/06
                                                    (
                                                    日
                                                    )
                                                </td>
                                                <td class="team">
                                                    九国大付属
                                                </td>
                                                <td class="score">
                                                    3&nbsp;-&nbsp;0
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    日章学園
                                                </td>
                                                <td>九州国際大学</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/06
                                                    (
                                                    日
                                                    )
                                                </td>
                                                <td class="team">
                                                    熊本国府
                                                </td>
                                                <td class="score">
                                                    0&nbsp;-&nbsp;1
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    長崎総附
                                                </td>
                                                <td>タイガーフィールド</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/06
                                                    (
                                                    日
                                                    )
                                                </td>
                                                <td class="team">
                                                    神村学園
                                                </td>
                                                <td class="score">
                                                    3&nbsp;-&nbsp;1
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    宮崎日大
                                                </td>
                                                <td>東福岡高校</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/05
                                                    (
                                                    土
                                                    )
                                                </td>
                                                <td class="team">
                                                    東海大福岡
                                                </td>
                                                <td class="score">
                                                    2&nbsp;-&nbsp;3
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    宮崎日大
                                                </td>
                                                <td>タイガーフィールド</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/05
                                                    (
                                                    土
                                                    )
                                                </td>
                                                <td class="team">
                                                    神村学園
                                                </td>
                                                <td class="score">
                                                    1&nbsp;-&nbsp;1
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    日章学園
                                                </td>
                                                <td>東福岡高校</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/05
                                                    (
                                                    土
                                                    )
                                                </td>
                                                <td class="team">
                                                    大津
                                                </td>
                                                <td class="score">
                                                    3&nbsp;-&nbsp;1
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    長崎総附
                                                </td>
                                                <td>東福岡高校</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/05
                                                    (
                                                    土
                                                    )
                                                </td>
                                                <td class="team">
                                                    九国大付属
                                                </td>
                                                <td class="score">
                                                    0&nbsp;-&nbsp;3
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    熊本国府
                                                </td>
                                                <td>九州国際大学</td>
                                            </tr>
                                            <tr>
                                                <td class="textC">
                                                    10/05
                                                    (
                                                    土
                                                    )
                                                </td>
                                                <td class="team">
                                                    東福岡
                                                </td>
                                                <td class="score">
                                                    4&nbsp;-&nbsp;2
                                                    <span>試合終了</span>
                                                </td>
                                                <td class="team">
                                                    筑陽学園
                                                </td>
                                                <td>東福岡高校</td>
                                            </tr>
                                        </table>
                                        </div><!-- /.box -->
                                </div>
                                </div>

                                <div class="tab_content" id="stats_content">
                                
                                <div class="sp_note">&lt;&lt;　スワイプでご覧いただけます。　&gt;&gt;</div>
                                
                                <div class="tab_content_description">
                                    <div class="box">
                                    <table>
                                            <tr>
                                                <th></th>
                                                <th>大津</th>
                                                <th>東福岡</th>
                                                <th>長崎総附</th>
                                                <th>神村学園</th>
                                                <th>熊本国府</th>
                                                <th>日章学園</th>
                                                <th>九国大付属</th>
                                                <th>宮崎日大</th>
                                                <th>筑陽学園</th>
                                                <th>東海大福岡</th>
                                                <th>暫定<br>順位</th>
                                            </tr>
                                            <tr class="home">
                                                <th>大津</th>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    3 ○ 2<br>
                                                    1 ○ 0<br>
                                                </td>
                                                <td>
                                                    0 ● 1<br>
                                                    3 ○ 1<br>
                                                </td>
                                                <td>
                                                    1 △ 1<br>
                                                    0 ● 1<br>
                                                </td>
                                                <td>
                                                    3 ○ 0<br>
                                                    2 △ 2<br>
                                                </td>
                                                <td>
                                                    3 ○ 1<br>
                                                    0 ● 2<br>
                                                </td>
                                                <td>
                                                    3 ○ 2<br>
                                                    2 △ 2<br>
                                                </td>
                                                <td>
                                                    4 ○ 0<br>
                                                    2 △ 2<br>
                                                </td>
                                                <td>
                                                    1 ● 2<br>
                                                    5 ○ 0<br>
                                                </td>
                                                <td>
                                                    2 ○ 1<br>
                                                    4 ○ 0<br>
                                                </td>
                                                <td>1</td>
                                            </tr>
                                            <tr class="home">
                                                <th>東福岡</th>
                                                <td>
                                                    2●3<br>
                                                    0●1<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    1●3<br>
                                                    4○2<br>
                                                </td>
                                                <td>
                                                    1△1<br>
                                                    2○1<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    0●2<br>
                                                </td>
                                                <td>
                                                    3○0<br>
                                                    8○4<br>
                                                </td>
                                                <td>
                                                    0●2<br>
                                                    4○3<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    3○0<br>
                                                </td>
                                                <td>
                                                    5○0<br>
                                                    4○2<br>
                                                </td>
                                                <td>
                                                    3○2<br>
                                                    6○2<br>
                                                </td>
                                                <td>2</td>
                                            </tr>
                                            <tr class="home">
                                                <th>長崎総附</th>
                                                <td>
                                                    1○0<br>
                                                    1●3<br>
                                                </td>
                                                <td>
                                                    3○1<br>
                                                    2●4<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    1●5<br>
                                                    5○0<br>
                                                </td>
                                                <td>
                                                    1○0<br>
                                                    1○0<br>
                                                </td>
                                                <td>
                                                    3○0<br>
                                                    3○0<br>
                                                </td>
                                                <td>
                                                    0●2<br>
                                                    8○0<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    1●2<br>
                                                </td>
                                                <td>
                                                    4○3<br>
                                                    1●2<br>
                                                </td>
                                                <td>
                                                    4○2<br>
                                                    3△3<br>
                                                </td>
                                                <td>3</td>
                                            </tr>
                                            <tr class="home">
                                                <th>神村学園</th>
                                                <td>
                                                    1△1<br>
                                                    1○0<br>
                                                </td>
                                                <td>
                                                    1△1<br>
                                                    1●2<br>
                                                </td>
                                                <td>
                                                    5○1<br>
                                                    0●5<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    2●3<br>
                                                    1○0<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    1△1<br>
                                                </td>
                                                <td>
                                                    2●3<br>
                                                    2●3<br>
                                                </td>
                                                <td>
                                                    4○2<br>
                                                    3○1<br>
                                                </td>
                                                <td>
                                                    1●3<br>
                                                    3○0<br>
                                                </td>
                                                <td>
                                                    2△2<br>
                                                    9○3<br>
                                                </td>
                                                <td>4</td>
                                            </tr>
                                            <tr class="home">
                                                <th>熊本国府</th>
                                                <td>
                                                    0●3<br>
                                                    2△2<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    2○0<br>
                                                </td>
                                                <td>
                                                    0●1<br>
                                                    0●1<br>
                                                </td>
                                                <td>
                                                    3○2<br>
                                                    0●1<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    0●2<br>
                                                    0●4<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    3○0<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    4○2<br>
                                                </td>
                                                <td>
                                                    3○2<br>
                                                    4○1<br>
                                                </td>
                                                <td>
                                                    1△1<br>
                                                    1△1<br>
                                                </td>
                                                <td>5</td>
                                            </tr>
                                            <tr class="home">
                                                <th>日章学園</th>
                                                <td>
                                                    1●3<br>
                                                    2○0<br>
                                                </td>
                                                <td>
                                                    0●3<br>
                                                    4●8<br>
                                                </td>
                                                <td>
                                                    0●3<br>
                                                    0●3<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    1△1<br>
                                                </td>
                                                <td>
                                                    2○0<br>
                                                    4○0<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    3○1<br>
                                                    0●3<br>
                                                </td>
                                                <td>
                                                    5○2<br>
                                                    3○1<br>
                                                </td>
                                                <td>
                                                    3△3<br>
                                                    3○0<br>
                                                </td>
                                                <td>
                                                    1●4<br>
                                                    2○0<br>
                                                </td>
                                                <td>6</td>
                                            </tr>
                                            <tr class="home">
                                                <th>九国大付属</th>
                                                <td>
                                                    2●3<br>
                                                    2△2<br>
                                                </td>
                                                <td>
                                                    2○0<br>
                                                    3●4<br>
                                                </td>
                                                <td>
                                                    2○0<br>
                                                    0●8<br>
                                                </td>
                                                <td>
                                                    3○2<br>
                                                    3○2<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    0●3<br>
                                                </td>
                                                <td>
                                                    1●3<br>
                                                    3○0<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    1○0<br>
                                                    1●3<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    1●3<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    1△1<br>
                                                </td>
                                                <td>7</td>
                                            </tr>
                                            <tr class="home">
                                                <th>宮崎日大</th>
                                                <td>
                                                    0●4<br>
                                                    2△2<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    0●3<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    2○1<br>
                                                </td>
                                                <td>
                                                    2●4<br>
                                                    1●3<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    2●4<br>
                                                </td>
                                                <td>
                                                    2●5<br>
                                                    1●3<br>
                                                </td>
                                                <td>
                                                    0●1<br>
                                                    3○1<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    2○1<br>
                                                    4△4<br>
                                                </td>
                                                <td>
                                                    1○0<br>
                                                    3○2<br>
                                                </td>
                                                <td>8</td>
                                            </tr>
                                            <tr class="home">
                                                <th>筑陽学園</th>
                                                <td>
                                                    2○1<br>
                                                    0●5<br>
                                                </td>
                                                <td>
                                                    0●5<br>
                                                    2●4<br>
                                                </td>
                                                <td>
                                                    3●4<br>
                                                    2○1<br>
                                                </td>
                                                <td>
                                                    3○1<br>
                                                    0●3<br>
                                                </td>
                                                <td>
                                                    2●3<br>
                                                    1●4<br>
                                                </td>
                                                <td>
                                                    3△3<br>
                                                    0●3<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    3○1<br>
                                                </td>
                                                <td>
                                                    1●2<br>
                                                    4△4<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>
                                                    4○1<br>
                                                    2●5<br>
                                                </td>
                                                <td>9</td>
                                            </tr>
                                            <tr class="home">
                                                <th>東海大福岡</th>
                                                <td>
                                                    1●2<br>
                                                    0●4<br>
                                                </td>
                                                <td>
                                                    2●3<br>
                                                    2●6<br>
                                                </td>
                                                <td>
                                                    2●4<br>
                                                    3△3<br>
                                                </td>
                                                <td>
                                                    2△2<br>
                                                    3●9<br>
                                                </td>
                                                <td>
                                                    1△1<br>
                                                    1△1<br>
                                                </td>
                                                <td>
                                                    4○1<br>
                                                    0●2<br>
                                                </td>
                                                <td>
                                                    2○1<br>
                                                    1△1<br>
                                                </td>
                                                <td>
                                                    0●1<br>
                                                    2●3<br>
                                                </td>
                                                <td>
                                                    1●4<br>
                                                    5○2<br>
                                                </td>
                                                <td class="none">&nbsp;</td>
                                                <td>10</td>
                                            </tr>
                                        </table>
                                        </div><!-- /.box -->
                                </div>
                                </div>
                            
                            </div><!-- /.tabs -->
                       
                       
                        </div><!-- /.ranking -->
                        --}}
                        
                        <div class="pageprev">
                            <a href="{{route('front.result.index')}}">
                                ページ一覧へ戻る
                            </a>
                        </div><!-- /.pageprev -->

                    </div><!-- /.inner -->
                </div>
            
            </section>
        </article>
        
        </div><!-- /.main -->

    @include('front.parts.side')
  
  </div><!-- /.inner -->
  </main>
@stop

