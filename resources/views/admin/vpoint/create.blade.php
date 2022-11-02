@extends('layouts.admin',['title'=>"勝ち点設定追加"])

@section('css')
<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
@show

@section('js')
<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
@stop

@section('content')

<div id='errors' style="color:red">
    @include("layouts.parts.message")
</div>

<div class="x_panel">
	<div class="x_title">
		<h2>勝ち点設定追加</h2>
		<div class="clearfix"></div>
	  <small><a class="btn btn-primary" href="{{route('admin.vpoint.index')}}">勝ち点設定一覧に戻る</a></small>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.vpoint.store'),'class'=>"form-horizontal form-label-left"])!!}
    {!!Form::textField('name','設定名称',old('name'),['placeholder'=>'設定名称を入力'])!!}

    {!!Form::textField('win','勝ち(win)',old('win'))!!}

    {!!Form::textField('lose','負け(lose)',old('lose'))!!}
    {!!Form::textField('draw','引き分け(draw)',old('draw'))!!}
    {!!Form::textField('pk_win','PK勝ち(pk_win)',old('pk_win'))!!}
    {!!Form::textField('pk_lose','PK負け(pk_lose)',old('pk_lose'))!!}

    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2 col-xs-12">ソート</label>
      <div class="col-md-10 col-sm-10 col-xs-12">
        {!!Form::text('sort',Input::has('sort')?Input::old('sort'):'win_pt desc,get_lose desc,get_pt desc,league_teams.id asc',['class'=>'form-control'])!!}
        通常のソート設定：win_pt desc,get_lose desc,get_pt desc,league_teams.id asc
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