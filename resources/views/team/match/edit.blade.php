@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/team.css" rel="stylesheet" type="text/css" />
@stop

@section('overlay')
  <div class="content_title">
      <div class="inner">
            <h1>
                <span>結果入力</span>
                <span>RESULT INPUT</span>
            </h1>
      </div><!-- /.inner -->
  </div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')

<article>
  <section>
      <div id="team">
          <div class="inner">
              {!!Form::open(['url'=>route('team.match.update'),'class'=>"form-horizontal form-label-left"])!!}
              {!!Form::hidden('id',$match->id)!!}
              <div id="result">
                <div class="title">
                  <h2>{{date('n月j日',strtotime($match->match_date))}}（{{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}}）
                    {{array_get(Config('app.seasonAry'),$match->leagueOne->season)}}　{{array_get(\App\Groups::all()->lists('name','id'),$match->leagueOne->group_id)}}　第{{$match->section}}節　</h2>
                  <div class="btn">
                    <a href="{{route('team.check',['id'=>$match->id])}}">累積を確認する</a>
                  </div><!-- /.btn -->
                </div>


                  @if($match->home_id==\Session::get('team_id'))
                    <div class="match_card row">
                        <div class="col">
                            <a href="">{{array_get($teams,$match->home_id)}}</a>
                        </div><!-- /.col -->
                        <div class="col row">
                            {!!Form::select('home_pt',array_combine(range(0,20), range(0,20)), $match->home_pt,['class'=>'form-control','style'=>'width:50px','placeholder'=>'▼'])!!}
                            <span>×</span>
                            {!!Form::select('away_pt',array_combine(range(0,20), range(0,20)), $match->away_pt,['class'=>'form-control','style'=>'width:50px','placeholder'=>'▼'])!!}
                        </div><!-- /.col -->
                        <div class="col">
                            <a href="">{{array_get($teams,$match->away_id)}}</a>
                        </div><!-- /.col -->
                    </div><!-- /.match_card -->
                    <div class="match_card row">
                        <div class="col">
                            <a href="">PK</a>
                        </div><!-- /.col -->
                        <div class="col row">
                            {!!Form::select('home_pk',array_combine(range(0,20), range(0,20)), $match->home_pk,['class'=>'form-control','style'=>'width:50px','placeholder'=>'▼'])!!}
                            <span>×</span>
                            {!!Form::select('away_pk',array_combine(range(0,20), range(0,20)), $match->away_pk,['class'=>'form-control','style'=>'width:50px','placeholder'=>'▼'])!!}
                        </div><!-- /.col -->
                        <div class="col">
                        </div><!-- /.col -->
                    </div><!-- /.match_card -->
                    <div class="edit_area row">
                        <div class="col">
                            <h2>{{array_get($teams,$match->home_id)}}</h2>
                            <h3>MOM</h3>
                            <div class="box">
                                <a>※サイトの試合結果ページには勝利チームのMOMのみ表示されます。<br>(引き分けの場合は表示されません。)</a>
                                
                                {!!Form::select("mom_home",$players_home['name'], $match->mom_home,['placeholder'=>'選手選択'])!!}
                            </div>
                            <?php
                            $goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','home')->where('team_id',$match->home_id)->get()->toArray();
                            ?>
                            <h3>得点</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>得点</th>
                                    </tr>
                                    @for($i=0;$i<20;$i++)
                                    <tr>
                                      <td>{!!Form::select("home_goals[$i][time]",config('app.matchTimeAry'), isset($goals[$i]['time'])?$goals[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
                                      <td>{!!Form::select("home_goals[$i][player]",$players_home['name']+[0=>'オウンゴール'], isset($goals[$i]['goal_player_id'])?$goals[$i]['goal_player_id']:'',['placeholder'=>'選手選択'])!!}</td>
                                    </tr>
                                    @endfor
                                </table>
                                {{--
                                <div class="btn_add">
                                    <span>&rsaquo; 入力欄を追加</span>
                                </div><!-- /.btn -->
                                --}}
                            </div><!-- /.box -->
                            <?php
                            $cards = \App\Cards::where('match_id',$match->id)->where('h_or_a','home')->where('team_id',$match->home_id)->get()->toArray();
                            ?>
                            <h3>警告・退場</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>警告種別</th>
                                        <th>対象選手</th>
                                    </tr>
                                    @for($i=0;$i<5;$i++)
                                    <tr>
                                      <td>{!!Form::select("home_cards[$i][time]",config('app.matchTimeAry'), isset($cards[$i]['time'])?$cards[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
                                      {{--<td>{!!Form::select("home_cards[$i][addtime]",array_combine(range(0,10), range(0,10)), isset($cards[$i]['addtime'])?$cards[$i]['addtime']:'',['placeholder'=>'時間選択'])!!}</td>--}}
                                      <td>{!!Form::select("home_cards[$i][type]",['yellow'=>'警告','red'=>'退場'], isset($cards[$i]['color'])?$cards[$i]['color']:'',['placeholder'=>'種別選択'])!!}</td>
                                      <td>{!!Form::select("home_cards[$i][player]",$players_home['name'], isset($cards[$i]['player_id'])?$cards[$i]['player_id']:'',['placeholder'=>'選手選択'])!!}</td>
                                    </tr>
                                    @endfor
                                </table>
                                {{--
                                <div class="btn_add">
                                    <span>&rsaquo; 入力欄を追加</span>
                                </div><!-- /.btn -->
                                --}}
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                        <div class="col">
                            <h2>{{array_get($teams,$match->away_id)}}</h2>
                            <h3>MOM</h3>
                            <div class="box">
                                <a>※サイトの試合結果ページには勝利チームのMOMのみ表示されます。<br>(引き分けの場合は表示されません。)</a>
                                
                                {!!Form::select("mom_away",$players_away['name'], $match->mom_away,['placeholder'=>'選手選択'])!!}
                            </div>
                            <?php
                            $goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','away')->where('team_id',$match->away_id)->get()->toArray();
                            ?>
                            <h3>得点</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>得点</th>
                                    </tr>
                                    @for($i=0;$i<20;$i++)
                                    <tr>
                                      <td>{!!Form::select("away_goals[$i][time]",config('app.matchTimeAry'), isset($goals[$i]['time'])?$goals[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
                                      {{--<td>{!!Form::select("away_goals[$i][addtime]",array_combine(range(0,10), range(0,10)), isset($goals[$i]['addtime'])?$goals[$i]['addtime']:'',['placeholder'=>'時間選択'])!!}</td>--}}
                                      <td>{!!Form::select("away_goals[$i][player]",$players_away['name']+[0=>'オウンゴール'], isset($goals[$i]['goal_player_id'])?$goals[$i]['goal_player_id']:'',['placeholder'=>'選手選択'])!!}</td>
                                      {{--<td>{!!Form::select("away_goals[$i][assist]",$players_away['name'], isset($goals[$i]['ass_player_id'])?$goals[$i]['ass_player_id']:'',['placeholder'=>'選手選択'])!!}</td>--}}
                                    </tr>
                                    @endfor
                                </table>
                                {{--
                                <div class="btn_add">
                                    <span>&rsaquo; 入力欄を追加</span>
                                </div><!-- /.btn -->
                                --}}
                            </div><!-- /.box -->
                            <?php
                            $cards = \App\Cards::where('match_id',$match->id)->where('h_or_a','away')->where('team_id',$match->away_id)->get()->toArray();
                            ?>
                            <h3>警告・退場</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>警告種別</th>
                                        <th>対象選手</th>
                                    </tr>
                                    @for($i=0;$i<5;$i++)
                                    <tr>
                                      <td>{!!Form::select("away_cards[$i][time]",config('app.matchTimeAry'), isset($cards[$i]['time'])?$cards[$i]['time']:'',['placeholder'=>'時間選択'])!!}</td>
                                      {{--<td>{!!Form::select("away_cards[$i][addtime]",array_combine(range(0,10), range(0,10)), isset($cards[$i]['addtime'])?$cards[$i]['addtime']:'',['placeholder'=>'時間選択'])!!}</td>--}}
                                      <td>{!!Form::select("away_cards[$i][type]",['yellow'=>'警告','red'=>'退場'], isset($cards[$i]['color'])?$cards[$i]['color']:'',['placeholder'=>'種別選択'])!!}</td>
                                      <td>{!!Form::select("away_cards[$i][player]",$players_away['name'], isset($cards[$i]['player_id'])?$cards[$i]['player_id']:'',['placeholder'=>'選手選択'])!!}</td>
                                    </tr>
                                    @endfor
                                </table>
                                {{--
                                <div class="btn_add">
                                    <span>&rsaquo; 入力欄を追加</span>
                                </div><!-- /.btn -->
                                --}}
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                    <div class="remarks">
                        <h2>マッチレポート</h2>
                        {!!Form::textarea('note',$match->note,['size'=>'1x3'])!!}
                    </div><!-- /.remarks -->
                    
                    <div class="comment">
                        <h2>{{array_get($teams,$match->home_id).'コメント'}}</h2>
                         {!!Form::textarea('home_comment',$match->home_comment,['size'=>'3x3'])!!}
                    </div><!-- /.comment -->
                    
                    <div class="comment">
                        <h2>{{array_get($teams,$match->away_id).'チームからの得点・警告・退場連絡'}}</h2>
                        {!!nl2br($match->away_note)!!}
                    </div><!-- /.comment -->
                  @elseif($match->away_id==\Session::get('team_id'))
                    <div class="match_card row">
                        <div class="col">
                            <a href="">{{array_get($teams,$match->home_id)}}</a>
                        </div><!-- /.col -->
                        <div class="col row">
                            {{$match->home_pt}}
                            <span>×</span>
                            {{$match->away_pt}}
                        </div><!-- /.col -->
                        <div class="col">
                            <a href="">{{array_get($teams,$match->away_id)}}</a>
                        </div><!-- /.col -->
                    </div><!-- /.match_card -->
                    <div class="edit_area row">
                        <div class="col">
                            <h2>{{array_get($teams,$match->home_id)}}</h2>
                            <?php
                            $goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','home')->where('team_id',$match->home_id)->get()->toArray();
                            ?>
                            <h3>得点</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>得点</th>
                                    </tr>
                                    @for($i=0;$i<20;$i++)
                                    <tr>
                                      <?php
                                      if($i>0 && !isset($goals[$i]['goal_player_id'])) break;
                                      ?>
                                      <td>{{isset($goals[$i]['time'])?$goals[$i]['time']:''}}</td>
                                      <td>{{isset($goals[$i]['goal_player_id'])?array_get($players_home['name']+[0=>'オウンゴール'],$goals[$i]['goal_player_id']):''}}</td>
                                    </tr>
                                    @endfor
                                </table>
                            </div><!-- /.box -->
                            <?php
                            $cards = \App\Cards::where('match_id',$match->id)->where('h_or_a','home')->where('team_id',$match->home_id)->get()->toArray();
                            ?>
                            <h3>警告・退場</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>警告種別</th>
                                        <th>対象選手</th>
                                    </tr>
                                    @for($i=0;$i<5;$i++)
                                    <tr>
                                      <?php
                                      if($i>0 && !isset($cards[$i]['player_id'])) break;
                                      ?>
                                      <td>{{isset($cards[$i]['time'])?$cards[$i]['time']:''}}</td>
                                      <td>{{isset($cards[$i]['color'])?array_get(['yellow'=>'警告','red'=>'退場'],$cards[$i]['color']):''}}</td>
                                      <td>{{isset($cards[$i]['player_id'])?array_get($players_home['name'],$cards[$i]['player_id']):''}}</td>
                                    </tr>
                                    @endfor
                                </table>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                        <div class="col">
                            <h2>{{array_get($teams,$match->away_id)}}</h2>
                            <?php
                            $goals = \App\Goals::where('match_id',$match->id)->where('h_or_a','away')->where('team_id',$match->away_id)->get()->toArray();
                            ?>
                            <h3>得点</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>得点</th>
                                    </tr>
                                    @for($i=0;$i<20;$i++)
                                    <tr>
                                      <?php
                                      if($i>0 && !isset($goals[$i]['goal_player_id'])) break;
                                      ?>
                                      <td>{{isset($goals[$i]['time'])?$goals[$i]['time']:''}}</td>
                                      <td>{{isset($goals[$i]['goal_player_id'])?array_get($players_away['name']+[0=>'オウンゴール'],$goals[$i]['goal_player_id']):''}}</td>
                                    </tr>
                                    @endfor
                                </table>
                            </div><!-- /.box -->
                            <?php
                            $cards = \App\Cards::where('match_id',$match->id)->where('h_or_a','away')->where('team_id',$match->away_id)->get()->toArray();
                            ?>
                            <h3>警告・退場</h3>
                            <div class="box">
                                <table>
                                    <tr>
                                        <th>時間</th>
                                        <th>警告種別</th>
                                        <th>対象選手</th>
                                    </tr>
                                    @for($i=0;$i<5;$i++)
                                    <tr>
                                      <?php
                                      if($i>0 && !isset($cards[$i]['player_id'])) break;
                                      ?>
                                      <td>{{isset($cards[$i]['time'])?$cards[$i]['time']:''}}</td>
                                      <td>{{isset($cards[$i]['color'])?array_get(['yellow'=>'警告','red'=>'退場'],$cards[$i]['color']):''}}</td>
                                      <td>{{isset($cards[$i]['player_id'])?array_get($players_away['name'],$cards[$i]['player_id']):''}}</td>
                                    </tr>
                                    @endfor
                                </table>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="remarks">
                        <h2>{{array_get($teams,$match->away_id).'得点・警告・退場 連絡'}}</h2>
                        {!!Form::textarea('away_note',$match->away_note,['size'=>'3x3'])!!}
                    </div><!-- /.remarks -->
                    
                    <div class="comment">
                        <h2>{{array_get($teams,$match->away_id).'コメント'}}</h2>
                        {!!Form::textarea('away_comment',$match->away_comment,['size'=>'3x3'])!!}
                    </div><!-- /.comment -->

                  @endif

                </div><!-- /.result -->
                                        
                <div class="btn_reg">
                    <!-- <input type="button" value="戻る"> -->
                    <input type="submit" value="登録">
                </div><!-- /.btn_reg -->
              {!!Form::close()!!}
          </div><!-- /.inner -->
      </div>
  </section>
</article>
@stop