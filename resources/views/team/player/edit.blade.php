@extends('layouts.team')

@section('css')
  <link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
  <link href="/team/css/common.css" rel="stylesheet" type="text/css"/>
  <link href="/team/css/style.css" rel="stylesheet" type="text/css"/>
  <link href="/team/css/form.css" rel="stylesheet" type="text/css"/>
  <link href="/team/css/player.css" rel="stylesheet" type="text/css"/>
  <link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css"/>
  <style>
      span.required {
          color: red;
          font-size: 11px;
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
@stop

@section('overlay')
  <div class="content_title">
    <div class="inner">
      <h1>
        <span>選手情報</span>
        <span>PLAYER INFORMATION</span>
      </h1>
    </div><!-- /.inner -->
  </div><!-- /.content_title -->
@stop

@section('content')

  @include('layouts.parts.error')
  <article>
    <div id="player">
      <div class="inner">
        <div id="create">
          {!!Form::open(['files'=>true,'url'=>route('team.player.update'),'class'=>'form-horizontal form-label-left'])!!}
          {!!Form::hidden('id',$player->id)!!}
          <div class="box">

            <h2>選手名<span>必須</span></h2>
            {!!Form::text('name',$player->name,['class'=>'w30'])!!}

            <h2>ブロック選手</h2>
            @if($block_term == 0)
              {!!Form::select('is_block',config('app.is_block'), $player->is_block,['class'=>'w30', 'disabled'])!!}
              {!!Form::hidden('is_block',$player->is_block)!!}
            @else
              {!!Form::select('is_block',config('app.is_block'), $player->is_block,['class'=>'w30'])!!}
              {{--!!Form::select('is_block',config('app.is_block'), $player->is_block,['class'=>'w30','disabled'=>true])!!--}}
            @endif

            <h2>生年月日<span>必須</span></h2>

            {!!Form::text('birthday',$player->birthday,['class'=>'w30 form-control inputCal'])!!}


            <h2>学年</h2>
            {!!Form::select('school_year',config('app.schoolYearAry'),$player->school_year,['class'=>"width:100px",'style'=>'width:100px'])!!}

            <h2>ポジション</h2>
			  <?php
			  foreach (config('app.positionAry') as $key => $val) {
				  printf("<input type='radio' name='position' value='%s' %s>%s", $key, ($player->position == $key) ? 'checked' : '', $val);
			  }
			  ?>

            <h2>出身地</h2>
            {!!Form::select('birthplace',config('app.prefAry')+[99=>'その他'],$player->birthplace,['class'=>'w20'])!!}


            <h2>出身チーム</h2>
            {!!Form::text('related_team',$player->related_team,['class'=>'w30'])!!}

            <h2>利き足</h2>
			  <?php
			  foreach (config('app.pivotAry') as $key => $val) {
				  printf("<input type='radio' name='pivot' value='%s' %s>%s", $key, ($player->pivot == $key) ? 'checked' : '', $val);
			  }
			  ?>

            <h2>身長</h2>
            {!!Form::text('height',$player->height,['class'=>'w20'])!!}
            <span>cm</span>

            <h2>体重</h2>

            {!!Form::text('weight',$player->weight,['class'=>'w20'])!!}
            <span>kg</span>

            <h2>今年の目標</h2>

            {!!Form::text('goal',$player->goal)!!}

            <h2>選手写真</h2>
            @if($player->img)
              <img src="/upload/100/{{$player->img}}">
              <input type="checkbox" value="1" name="img_delete">写真削除
            @endif
            {!!Form::file('img')!!}

            <h2>過去の得点数</h2>

            <table>
              <tr>
                <th>大会名</th>
                <th style="padding: 0px 20px">得点数</th>
              </tr>
              <?php
              $goals = \App\Goals::selectRaw('league_id, count(*) cnt')->where('goal_player_id',$player->id)->groupBy('league_id')->get();
              ?>
              @foreach($goals as $goal)
                <tr>
                  <td>{{$goal->league->name}}</td>
                  <td style="padding: 20px 30px">{{$goal->cnt}}</td>
                </tr>
              @endforeach
            </table>

            <div class="ln_solid"></div>

          </div><!-- /.box -->

          <div class="btn_reg">
            <input type="button" value="戻る" onclick="javascript:history.back();">
            <input type="submit" value="登録">
          </div><!-- /.btn_reg -->

          </form>

        </div><!-- /.create -->

      </div><!-- /.inner -->
    </div>
  </article>
@endsection