@extends('layouts.team')

@section('css')
  <link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
  <link href="/team/css/common.css" rel="stylesheet" type="text/css"/>
  <link href="/team/css/style.css?20210330" rel="stylesheet" type="text/css"/>
  <link href="/team/css/index.css?20210330" rel="stylesheet" type="text/css"/>
  <link href="/team/css/form.css" rel="stylesheet" type="text/css"/>
  <style>
    .btn a{
      margin-bottom: 0.5%;
    }
  </style>
@stop

@section('js')
  <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

  <script>
      $(function () {
          $.datepicker.setDefaults($.datepicker.regional["ja"]);
          $(".inputCal").datepicker({dateFormat: 'yy-mm-dd'});
      });
  </script>
  <script>
      $(function () {
          $(".alert-msg").hide(2000);
      });
      $("a.confirm").click(function (e) {
          e.preventDefault();
          thisHref = $(this).attr('href');
          if (confirm('削除して良いですか？')) {
              window.location = thisHref;
          }
      })

  </script>
@stop

@section('content')
  <article>
    <section>
      <div id="news">
        <div class="inner row">
          <div class="title">
            <h2>
              <span>NEWS</span>
              <span>運営からのお知らせ</span>
            </h2>
          </div><!-- /.title -->
          <div class="list">
            <ul>
              @if(isset($newsObj) && count($newsObj)>0)
                @foreach($newsObj as $news)
                  <li>
                    <span>{{date('Y-m-d',strtotime($news->dis_dt))}}</span>
                    <span>{{$news->title}}</span>
                    <a href="{{route('team.news.show',['id'=>$news->id])}}"></a>
                  </li>
                @endforeach
              @endif
            </ul>
            <div class="btn">
              <a href="{{route('team.news.index')}}">一覧はこちら</a>
            </div><!-- /.btn -->
          </div><!-- /.list -->
        </div><!-- /.inner -->
      </div>
    </section>

    <section><br>
      <div style="font-size: 18px; color: red;">
      @include('layouts.parts.error')
      </div>
      <br>
      <a style="font-size: 25px;" href="{{route('team.league.index')}}">警告者一覧はこちら</a>

      <div id="result">
        <div class="inner">
          <div class="title row">
            <h2>
              <span>リーグ戦結果入力</span>
              <span>LEAGUE MATCH RESULT INPUT</span>
            </h2>
            <div class="select">
              {{--
              {!!Form::open(['url'=>route('team.top'),'method'=>'get'])!!}
                  {!!Form::select('y',array_combine(range(2019,date('Y')+1), range(2019,date('Y')+1)),Input::has('y')?Input::get('y'):'',['class'=>'form-control','placeholder'=>'年選択'])!!}
                  {!!Form::select('m',array_combine(range(1,12), range(1,12)),Input::has('m')?Input::get('m'):'',['class'=>'form-control','placeholder'=>'月選択'])!!}
                  <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:5px">
              {!!Form::close()!!}
              --}}
            </div><!-- /.select -->
          </div><!-- /.title -->
          <div class="list">
            <div class="title_bar row">
              <span>日程</span>
              <span>対戦カード</span>
              <span>開催地</span>
            </div><!-- /.title_bar -->


            @if(isset($matches) && count($matches)>0)
              @foreach($matches as $match)
					  <?php
					  $params = [];
					  $home = ($match->home_id == \Session::get('team_id')) ? 'home' : 'away';
					  //                        if($home!='') $params[] = $home;
                      // 2021-06-11 試合日の２日前から入力可能に。
					  $sm = (date('U') >= date('U', strtotime($match->match_date . ' -2 days')) && date('U') <= date('U', strtotime($match->match_date . ' 17:00'))) ? 'sm home' : '';
					  // $sm = (date('U') <= date('U', strtotime($match->match_date.' '.$match->match_time)))?'sm':'';
					  //                        if($sm!='') $params[] = $sm;
					  //                        if(count($params)!=0){
					  //                            $row_params = implode(' ',$params);
					  //                        }else{
					  //                            $row_params = '';
					  //                        }
					  ?>
                <div class="box row {{$sm}}">
                  <div class="date">
                    <a style="font-weight: 900; font-size: 17px;">{{ array_get(config('app.conventionAry'),$match->leagueOne->convention) }}</a><br>
                    @if($match->is_publish != 3)
                    {{$match->match_date}}
                    ({{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}})
                    第{{$match->section or ' - '}}節 <span class="{{$home}}">{{strtoupper($home)}}</span>
                    @endif
                    {{-- <br>{{$match->match_time}} --}}
                    @if($match->is_filled) <span>試合終了</span> @endif
                    @if($match->is_publish == 2) <span>延期</span> @endif
                    @if($match->is_publish == 3) <span>未定</span> @endif
                  </div><!-- /.date -->
                  <div class="txt row">
                    <div class="match_card row">
                      {{-- {{$match->leagueOne->name}}<br>{{$match->home0->name}} vs {{$match->away0->name}} --}}
                      <span><a href="#"
                               target="_blank">{{$match->home0->name}}</a></span>
                      <span></span>
                      <span><a href="#"
                               target="_blank">{{$match->away0->name}}</a></span>
                    </div><!-- /.match_card -->
                    <div class="venue row">
                      <span>審判 : {{$match->judge->name or 'その他'}}</span>
                      <span>{{$match->place->name}}</span>
                    </div><!-- /.venue -->
                    <div class="btn<?php ($sm != 'sm home') ? ' row' : '';?>">
                        <a href="{{route('team.starter.edit',['id'=>$match->id])}}">スタメン<span>登録・印刷</span></a>
                      @if(date("U") >= date('U', strtotime($match->match_date.' 09:00')))
                        <a href="{{route('team.match.edit',['id'=>$match->id])}}">結果<br><span>入力・編集</span></a>
                      @endif
                      <a href="{{route('team.match.group_photo.edit',['id'=>$match->id])}}">集合写真<br><span>投稿・編集</span></a>
                      <a href="{{route('team.match.gallery.edit',['id'=>$match->id])}}">ギャラリー<br><span>投稿・編集</span></a>
                      <a href="{{route('team.check',['id'=>$match->id])}}">累積を確認する</a>
                      <a href="{{route('team.match.day.edit',['id'=>$match->id])}}" style="background: #ad3952;">試合日を変更する</a>
                      <a href="{{route('team.match.venue.edit',['id'=>$match->id])}}" style="background: #ad3952;">会場を変更する</a>
                    </div><!-- /.btn -->
                  </div><!-- /.txt -->
                </div><!-- /.box -->
              @endforeach
            @endif

          </div><!-- /.list -->
        </div><!-- /.inner -->

        <div class="inner">
          <div class="title row">
            <h2>
              <span>リーグ戦結果</span>
              <span>LEAGUE MATCH RESULT</span>
            </h2>
          </div><!-- /.title -->
          <div class="list">
            <div class="title_bar row">
              <span>日程</span>
              <span>対戦カード</span>
              <span>開催地</span>
            </div><!-- /.title_bar -->


            @if(isset($matches0) && count($matches0)>0)
              @foreach($matches0 as $i=>$match)
					  <?php
					  $params = [];
					  $home = ($match->home_id == \Session::get('team_id')) ? 'home' : 'away';
					  //                            if($home!='') $params[] = $home;
					  //                            if(count($params)!=0){
					  //                                $row_params = implode(' ',$params);
					  //                            }else{
					  //                                $row_params = '';
					  //                            }
					  ?>
                <div class="box row">
                  <div class="date">
                    <a style="font-weight: 900; font-size: 17px;">{{ array_get(config('app.conventionAry'),$match->leagueOne->convention) }}</a><br>
                    {{$match->match_date}}
                    ({{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}})
                    第{{$match->section or ' - '}}節 <span class="{{$home}}">{{strtoupper($home)}}</span>
                    <span>試合終了</span>
                  </div><!-- /.date -->
                  <div class="txt row">
                    <div class="match_card row">
                      {{-- {{$match->leagueOne->name}}<br>{{$match->home0->name}} {{$match->home_pt}} vs {{$match->away_pt}} {{$match->away0->name}} <span class="btn btn-xs btn-danger">試合終了</span> --}}
                      <span><a href="#"
                               target="_blank">{{$match->home0->name}}</a> {{$match->home_pt}}
                               @if($match->home_pt == $match->away_pt) (PK{{$match->home_pk}})@endif
                              </span>
                      <span></span>
                      <span>
                        @if($match->home_pt == $match->away_pt) (PK{{$match->away_pk}})@endif
                        {{$match->away_pt}}
                        <a href="#"
                                                   target="_blank">{{$match->away0->name}}</a>
                      </span>
                    </div><!-- /.match_card -->
                    <div class="venue row">
                      <span>審判 : {{$match->judge->name or 'その他'}}</span>
                      <span>{{$match->place->name}}</span>
                    </div><!-- /.venue -->
                    <div class="btn row">
                      <a href="{{route('team.match.edit',['id'=>$match->id])}}">結果<br><span>入力・編集</span></a>
                      <a href="{{route('team.match.group_photo.edit',['id'=>$match->id])}}">集合写真<br><span>投稿・編集</span></a>
                      <a href="{{route('team.match.gallery.edit',['id'=>$match->id])}}">ギャラリー<br><span>投稿・編集</span></a>
                      @if(0 && config('app.debug'))
                        <a href="{{route('team.check',['id'=>$match->id])}}">累積を確認する</a>
                      @endif
                      @if($i==0)
                        <a href="{{route('team.starter.edit',['id'=>$match->id])}}">スタメン<span>登録・印刷</span></a>
                      @endif
                    </div><!-- /.btn -->
                  </div><!-- /.txt -->
                </div><!-- /.box -->
              @endforeach
            @endif

          </div><!-- /.list -->
        </div><!-- /.inner -->

      </div>

      <div class="pager">
        {!! $matches->appends(Input::except('page'))->render(); !!}
        {{--<ul>
            <li><a href="" class="prev">&lsaquo; 前のページ</a></li>
            <li><span class="current">1</span></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li><a href="" class="next">前のページ &rsaquo;</a></li>
        </ul>--}}
      </div><!-- /.pager -->

    </section>

  </article>

@stop