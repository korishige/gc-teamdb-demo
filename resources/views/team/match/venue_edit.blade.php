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
        {!!Form::open(['url'=>route('team.match.venue.update'),'class'=>"form-horizontal form-label-left"])!!}
        {!!Form::hidden('id',$match->id)!!}

       <h1 style="color: red; font-size: 18px;">※選択肢に目的の会場がない場合は
        @if($match->leagueOne->convention == 0)
        <a style="color: red" href="https://www.bluewave-boost.com/contact">こちら</a>
        @elseif($match->leagueOne->convention == 1)
        <a style="color: red" href="https://www.bluewave-netto.com/contact">こちら</a>
        @else
        <a style="color: red" href="https://www.bluewave-shudo.com/contact">こちら</a>
        @endif
        からお問合せください。</h1>
        <br><br>

          <div class="match_card row" style="font-size: 20px">
            <div class="col">
            </div><!-- /.col -->
            <div class="col row">
                <h2>{{$match->venue->name}}</h2>
                <span>　➡︎　</span>
                {!!Form::selectField('place_id', null,\App\Venue::all()->lists('name','id'),$match->place_id,['style'=>'width:300px'])!!}

            </div><!-- /.col -->
            <div class="col">
            </div><!-- /.col -->
          </div><!-- /.match_card -->

          <div class="btn_reg">
              <!-- <input type="button" value="戻る"> -->
              <input type="submit" value="変更">
          </div><!-- /.btn_reg -->
        {!!Form::close()!!}
      </div><!-- /.inner -->
    </div>
  </section>
</article>
@stop
