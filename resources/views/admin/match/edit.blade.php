@extends('layouts.admin')

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
        <li><a href="{{route('admin.match.index',['league_id'=>$match->leagueOne->id])}}">{{$match->leagueOne->name}} 日程</a>
        <li class="active">日程編集</li>
    </ol>

	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.match.update'),'class'=>"form-horizontal form-label-left"])!!}
		{!!Form::hidden('leagues_id',$match->leagues_id)!!}
		{!!Form::hidden('id',$match->id)!!}

        {!!Form::rbinline('is_filled','結果入力状況',config('app.is_filled'),$match->is_filled)!!}
        {!!Form::rbinline('is_publish','公開状況',config('app.is_publish'),$match->is_publish)!!}

    {!!Form::selectField('home_id','責任チーム',$teamObj,$match->home_id,['style'=>'width:300px'])!!}
    {!!Form::selectField('away_id','非責任チーム',$teamObj,$match->away_id,['style'=>'width:300px'])!!}

		{{--
    <div class="form-group">
			<div class="form-inline">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">試合結果</label>
				{!!Form::select('home_id',$teamObj,$match->home_id,['class'=>'form-control','style'=>'width:200px'])!!}
				{!!Form::text('home_pt',$match->home_pt,['class'=>'form-control','style'=>'width:50px'])!!} ―
				{!!Form::text('away_pt',$match->away_pt,['class'=>'form-control','style'=>'width:50px'])!!}
				{!!Form::select('away_id',$teamObj,$match->away_id,['class'=>'form-control','style'=>'width:200px'])!!}
			</div>
		</div>
    --}}

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-12">節</label>
          <div class="col-md-10 col-sm-10 col-xs-12">
            {!!Form::text('section',$match->section,['placeholder'=>'節を入力','class'=>'form-control','style'=>'width:100px'])!!}
          </div>
        </div>

            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">試合日</label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    {!!Form::text('match_date',$match->match_date,['placeholder'=>'試合日を入力','class'=>'form-control inputCal','style'=>'width:100px'])!!}
                </div>
            </div>

        <div class="form-group">
          <label class="control-label col-md-2 col-sm-2 col-xs-12">開始時間</label>
          <div class="col-md-10 col-sm-10 col-xs-12">
            {!!Form::text('match_time',$match->match_time,['placeholder'=>'試合開示時刻を入力','class'=>'form-control','style'=>'width:100px', 'placeholder'=>'11:00のように記載'])!!}
          </div>
        </div>

        {!!Form::selectField('place_id','試合会場',\App\Venue::all()->lists('name','id'),$match->place_id,['style'=>'width:300px'])!!}

        {!!Form::selectField('judge_id','審判',\App\Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy',config('app.nendo_backend'))->get()->lists('name','id'),$match->judge_id,['style'=>'width:300px','placeholder'=>'その他'])!!}

		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</div>

		{!!Form::close()!!}
	</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

<script src="/css/summernote-ja-JP.js"></script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    lang: 'ja-JP' // default: 'en-US'
  });
});
</script>
@stop