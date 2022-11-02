@extends('layouts.admin')

@section('css')
<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
@show

@section('js')
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
		$( ".inputCal" ).datepicker({ dateFormat: 'yy-mm-dd' });

        function homept_change(){
            home_pt = $("input[name='home_pt']").val();
            away_pt = $("input[name='away_pt']").val();
            if(home_pt==away_pt){
                $("input[name='home_pk'").prop('disabled', false);
                $("input[name='away_pk'").prop('disabled', false);
            }
        };
        $(document).on("change", "input[name='home_pt']", homept_change);
        function awaypt_change(){
            home_pt = $("input[name='home_pt']").val();
            away_pt = $("input[name='away_pt']").val();
            if(home_pt==away_pt){
                $("input[name='home_pk'").prop('disabled', false);
                $("input[name='away_pk'").prop('disabled', false);
            }
        };
        $(document).on("change", "input[name='away_pt']", awaypt_change);

        home_pt = $("input[name='home_pt']").val();
        away_pt = $("input[name='away_pt']").val();
        if((home_pt == "" || away_pt == "") || (home_pt!=away_pt)){
            $("input[name='home_pk'").prop('disabled', true);
            $("input[name='away_pk'").prop('disabled', true);
        }
	});
</script>
@stop

@section('content')
	@if(Session::has('messages'))
	<div class="alert alert-success alert-msg">{{Session::get('messages')}}</div>
	@endif

<div class="x_panel">
	<div class="x_title">
		<h2>リーグ編集
			<small>{{$league->id}}</small>
			<p class="label label-info">作成日:{{$league->created_at}}</p>
			<p class="label label-success">更新日:{{$league->updated_at}}</p>
		</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.match.update'),'class'=>"form-horizontal form-label-left"])!!}
		{!!Form::hidden('leagues_id',$match->leagues_id)!!}
		{!!Form::hidden('id',$match->id)!!}
		<div class="form-group">
			<div class="form-inline">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">試合結果</label>
				{!!Form::select('home_id',$teamObj,$match->home_id,['class'=>'form-control','style'=>'width:200px'])!!}
				{!!Form::text('home_pt',$match->home_pt,['class'=>'form-control','style'=>'width:50px'])!!} ―
				{!!Form::text('away_pt',$match->away_pt,['class'=>'form-control','style'=>'width:50px'])!!}
				{!!Form::select('away_id',$teamObj,$match->away_id,['class'=>'form-control','style'=>'width:200px'])!!}
                <label class="btn btn-warning" style="margin-top:4px;margin-left:15px">PK</label>
                {!!Form::text('home_pk',Input::old('home_pk'),['class'=>'form-control','style'=>'width:50px'])!!} ―
                {!!Form::text('away_pk',Input::old('away_pk'),['class'=>'form-control','style'=>'width:50px'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">試合日</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('match_at',$match->match_at,['placeholder'=>'試合日を入力','class'=>'form-control inputCal'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">試合会場</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('place',$match->place,['placeholder'=>'試合会場を入力','class'=>'form-control'])!!}
			</div>
		</div>


		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">ニックネーム</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('nickname',$match->nickname,['placeholder'=>'ニックネームを入力','class'=>'form-control'])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">パスワード</label>
			<div class="col-md-10 col-sm-10 col-xs-12">
				{!!Form::text('pass',$match->pass,['class'=>'form-control'])!!}
			</div>
		</div>

		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
				<button type="submit" class="btn btn-success">保存</button>
			</div>
		</div>

		{!!Form::close()!!}
	</div>
</div>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 

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
@stop