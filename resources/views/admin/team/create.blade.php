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
	$(".inputCal2").datetimepicker({step: 30,minTime:'06:00',maxTime:'20:30',format:'Y-m-d H:i'});
});
</script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@stop

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
		<li><a href="{{route('admin.team.index')}}">チーム一覧</a></li>
		<li class="active">チーム追加</li>
	</ol>
	
	<div class="x_title">
		<h2>チーム追加</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		@include('layouts.parts.message')
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.team.store'),'class'=>'form-horizontal form-label-left'])!!}

			{!!Form::textField('name','チーム名',old('name'))!!}

			<?php
			$groups = \App\Groups::where('id', '<>', 28)->get()->lists('name', 'id');
			foreach ($groups as $key => $group) {
				$g = \App\Groups::find($key);
				$gs[$key] = $group . '(' . config('app.conventionAry')[$g->convention] . ')';
			}
			?>
			
			{!!Form::selectField('group_id','所属グループ',$gs, ['style'=>'width:200px'])!!}

			{!!Form::textField('email','ID',old('email'))!!}

			{!!Form::textField('password','パスワード',old('password'))!!}

			{!!Form::textField('password_confirmation','パスワード(確認)', old('password_confirmation'))!!}


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