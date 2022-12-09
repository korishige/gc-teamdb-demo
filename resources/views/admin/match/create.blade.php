@extends('layouts.admin',['title'=>"日程追加"])

@section('css')
<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
@show

@section('js')
<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
		$( ".inputCal" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>
@stop

@section('content')

@include('layouts.parts.error')
<div class="x_panel">
  <ol class="breadcrumb">
    <li><a href="{{route('admin.league.index')}}">大会一覧</a></li>
    <li><a href="{{route('admin.match.index',['leagues_id'=>$league_id])}}"> {{$league->name}} {{array_get(\App\Groups::get()->lists('name', 'id'),$league->group_id)}} 日程</a></li>
    <li class="active">日程追加</li>
  </ol>

	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.match.store'),'class'=>"form-horizontal form-label-left"])!!}
		{!!Form::hidden('leagues_id',$league_id)!!}
    
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12">節</label>
      <div class="col-md-10 col-sm-10 col-xs-12">
        {!!Form::text('section',Input::old('section'),['placeholder'=>'節を入力','class'=>'form-control','style'=>'width:100px'])!!}
      </div>
    </div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">試合日</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('match_date',Input::old('match_date'),['placeholder'=>'試合日を入力','class'=>'form-control inputCal','style'=>'width:150px'])!!}
			</div>
		</div>

    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12">開始時間</label>
      <div class="col-md-10 col-sm-10 col-xs-12">
        {!!Form::text('match_time',Input::old('match_time')?Input::old('match_time'):'10:00',['placeholder'=>'試合開示時刻を入力','class'=>'form-control','style'=>'width:100px', 'placeholder'=>'11:00のように記載'])!!}
      </div>
    </div>

    
    {!!Form::selectField('place_id','試合会場',\App\Venue::whereIn('pref_id', $prefs)->lists('name','id'),old('place_id'),['style'=>'width:300px'])!!}
    <?php 
    // $place = \App\Venue::where('pref_id', $pref->organizations_id)->lists('name', 'id');
     
    ?>


    {!!Form::selectField('home_id','責任チーム',$teams,old('home_id'),['style'=>'width:300px'])!!}
    {!!Form::selectField('away_id','非責任チーム',$teams,old('away_id'),['style'=>'width:300px'])!!}

    {!!Form::selectField('judge_id','審判',\App\Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy',config('app.nendo_backend'))->get()->lists('name','id'),old('judge_id'),['style'=>'width:300px','placeholder'=>'その他'])!!}

		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" name="pending" value="0" class="btn btn-success">保存</button>
				<button type="submit" name="pending" value="1" class="btn btn-warning">日時未定で保存する</button>
			</div>
		</div>

		{!!Form::close()!!}
	</div>

          @if(isset($matchObj) && count($matchObj)>0)

          <table id="myTable" class="table table-striped jambo_table">
            <thead>
              <tr>
                <th>試合日時</th>
                <th>対戦</th>
                <th>審判</th>
                <th>会場</th>
              </tr>
            </thead>

            <tbody>
              @foreach($matchObj as $i=>$match)
              <tr class="pointer">
                <td width=30>{{$match->match_date}} {{$match->match_time}}</td>
                <td>
                  @if($match->home_pt == NULL or $match->away_pt == NULL)
                  {{$match->home0->name}}　vs　{{$match->away0->name}}
                  @else
                  {{$match->home0->name}}　{{$match->home_pt}} - {{$match->away_pt}}　{{$match->away0->name}}
                  @endif
                </td>
                <td>{{$match->judge->name or 'その他'}}</td>
                <td>{{$match->place->name}}</td>
              </tr>
              @endforeach
            </tbody>

          </table>
          @else
          日程はまだ入力されていません
          @endif

</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>

{{--
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

<script src="/css/summernote-ja-JP.js"></script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    lang: 'ja-JP' // default: 'en-US'
  });
});
</script>
--}}
@stop