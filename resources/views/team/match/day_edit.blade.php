@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/team.css" rel="stylesheet" type="text/css" />
<style>
  #red {
    background: #b84f45;
    border: 1px solid #b84f45;
    width: 20%;
    padding: 1em;
    border-radius: 5px;
    letter-spacing: 10px;
    color: #fff;
    margin-left: 5px;
  }

  #red:hover {
    color: #b84f45;
    background: white;
  }

</style>
@stop

@section('overlay')
<div class="content_title">
  <div class="inner">
    <h1>
      <span>試合日時変更</span>
      <span>CHANGE MATCH DAY</span>
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
        {!!Form::open(['url'=>route('team.match.day.update'),'class'=>"form-horizontal form-label-left"])!!}
        {!!Form::hidden('id',$match->id)!!}

          <div class="match_card row" style="font-size: 20px">
            <div class="col">
            </div><!-- /.col -->
            <div class="col row">
                <h2>{{date('n月j日',strtotime($match->match_date))}}（{{array_get(Config::get('app.week'),date('w',strtotime($match->match_date)))}}）</h2>
                <span>➡︎　</span>
                {!!Form::date('match_date',$match->match_date,['class'=>'form-control inputCal','style'=>'width:150px'])!!}
            </div><!-- /.col -->
            <div class="col">
            </div><!-- /.col -->
        </div><!-- /.match_card -->

        <br>

        <div class="match_card row" style="font-size: 20px">
          <div class="col">
          </div><!-- /.col -->
          <div class="col row">
              <h2>{{$match->match_time}}</h2>
              <span>　➡︎　</span>
              {!!Form::time('match_time',$match->match_time,['class'=>'form-control inputCal','style'=>'width:150px', 'step' => '600'])!!}
          </div><!-- /.col -->
          <div class="col">
          </div><!-- /.col -->
      </div><!-- /.match_card -->

          <div class="btn_reg">
              <!-- <input type="button" value="戻る"> -->
              <input type="submit" value="日時を変更">
              <button id="red" type="submit" name="is_publish" value="2">延期に設定</button>
          </div><!-- /.btn_reg -->
        {!!Form::close()!!}
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop