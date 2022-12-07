@extends('layouts.admin')

@section('css')
	<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/jquery.datetimepicker.css">
@show

@section('js')
	<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.full.min.js"></script>

	<script>
		$(function(){
			$.datetimepicker.setLocale('ja');
			$(".inputCal2").datetimepicker({step: 30,minTime:'06:00',maxTime:'20:30',format:'Y-m-d H:i',});
		});
	</script>
@stop

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.news.index')}}">外部向けお知らせ編集</a></li>
	  <li class="active">外部向けお知らせ編集</li>
	</ol>

	<div class="x_title">
		<h2>外部向けお知らせ編集</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.news2.update'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::hidden('id',$obj->id)!!}

			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-12">大会</label>
				<div class="col-md-10 col-sm-10 col-xs-12">
					{!!Form::select('convention',Config::get('app.conventionAry'),$obj->convention,['class'=>'form-control','style'=>'width:200px'])!!}
				</div>
			</div>

		<div class="form-group">
			<label for="id-field-dis_dt" class="control-label col-md-2 col-sm-12 col-xs-12">表示日時</label>
			<div class="col-sm-12 col-xs-12 col-md-10">
				<input class="form-control inputCal2" placeholder="表示日を入力" style="width:250px" name="dis_dt" value="{{date('Y-m-d H:i',strtotime($obj->dis_dt))}}">
				{{--<input class="form-control" placeholder="表示日時を入力" style="width:250px" name="dis_dt" type="datetime-local" step="1800" value="{{str_replace(' ', 'T', substr($obj->dis_dt,0,16))}}">--}}
			</div>
		</div>

			{!!Form::textField('title','タイトル',$obj->title)!!}
			{!!Form::textareaField('body','本文',$obj->body,['size'=>'30x30','class'=>'summernote'])!!}
			{!!Form::rbinline('is_publish','ステータス',config('app.is_publish'), $obj->is_publish)!!}

			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-2">
					<button type="submit" class="btn btn-success">保存</button>
				</div>
			</div>

		{!!Form::close()!!}
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="/js/summernote.min.js"></script>
<script src="/js/summernote-ja-JP.js"></script>
<script>
$(document).ready(function() {
	$('.summernote').summernote({
		height:300,
		lang: 'ja-JP', // default: 'en-US'
		callbacks: {
			onImageUpload: function(files) {
				sendFile(files[0]);
			},
		}
	}).on("summernote.enter", function(we, e) {
		$(this).summernote("pasteHTML", "<br>&#8203;");
		e.preventDefault();
	});

	function sendFile(file) {
		data = new FormData();
		data.append("file", file);
		$.ajax({
			data: data,
			type: "POST",
			url: "{{config('app.url')}}upimg.php",
			cache: false,
			contentType: false,
			processData: false,
			success: function(url) {
				console.log(url)
					//アップロードが成功した後の画像を書き込む処理
					if(url.slice(-4) == '.pdf'){
						$('.summernote').summernote('createLink', {
							text: "ファイル名を入力してください",
							url: url,
							isNewWindow: true
						});
					}else{
						$('.summernote').summernote('insertImage',url);
					}
				}
			});
	}
});
</script>
@stop