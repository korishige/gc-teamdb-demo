@extends('layouts.admin')

@section('css')
<link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
@show

@section('js')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@endsection

@section('content')
<div class="x_panel">
    <ol class="breadcrumb">
      <li><a href="{{route('admin.team.index')}}">チーム一覧</a></li>
      <li class="active">{{$team->name}} 情報編集</li>
    </ol>
    
	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.team.update'),'class'=>"form-horizontal form-label-left"])!!}
		<input type="hidden" name="id" value="{{$team->id}}">

		<?php
		$groups = \App\Groups::get()->lists('name', 'id');
		?>
        {{-- {!!Form::staticField('group_id','所属リーグ',array_get($groups, $team->group_id),['style'=>'width:200px'])!!} --}}
		{!!Form::selectField('group_id','所属リーグ',$groups, $team->group_id,['style'=>'width:200px'])!!}


		<?php
		$orgs = \App\Organizations::get()->lists('name', 'id');
		?>
        {!!Form::selectField('organizations_id','組織名称',$orgs, $team->organizations_id,['class'=>'form-control organization','style'=>'width:300px'])!!}

		{!!Form::textField('name','チーム名',$team->name,['style'=>'width:350px'])!!}

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2 col-xs-12">設立年</label>
			<div class="col-md-1 col-sm-1 col-xs-12">
				<div class="input-group">
					<span class="input-group-addon">西暦</span>
					{!!Form::text('year',$team->year,['class'=>'form-control'])!!}
					<span class="input-group-addon">年</span>
				</div>
			</div>
		</div>

        {{--
        <div class="form-group">
          <label for="id-field-zip" class="control-label col-md-2 col-sm-2 col-xs-12">郵便番号<span class="req">*</span></label>
          <div class="col-md-10 col-sm-10 col-xs-12">
            <input class="form-control col-md-10 col-sm-10 col-xs-12" id="id-field-zip" placeholder="123-4567" onKeyUp="AjaxZip3.zip2addr(this,'','pref_id','add1');" name="zip" type="text" value="{{old('zip')}}">
            <p>郵便番号を入力すると自動で番地の前までの住所が入力されます</p>
          </div>
        </div>
        --}}

		{!!Form::selectField('pref_id','都道府県',config('app.prefAry'),$team->pref_id)!!}
		{!!Form::textField('add1','市区町村',$team->add1)!!}
		{!!Form::textField('add2','以降の住所',$team->add2)!!}
		{!!Form::textField('tel','TEL',$team->tel)!!}

		<div class="form-group">
			<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">エンブレム画像(500x500px目安）</label>
			<div class="col-sm-10">
				@if($team->emblem_img)
				<img src="/upload/100_crop/{{$team->emblem_img}}">
				<input type="checkbox" value="1" name="emblem_img_delete">写真削除
				@endif
				{!!Form::file('emblem_img')!!}
			</div>
		</div>

		<div class="form-group">
			<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">集合写真(1000x750px目安）</label>
			<div class="col-sm-10">
				@if($team->group_img)
				<img src="/upload/100/{{$team->group_img}}">
				<input type="checkbox" value="1" name="group_img_delete">写真削除
				@endif
				{!!Form::file('group_img')!!}
			</div>
		</div>

		{!!Form::textField('manager','チーム監督',$team->manager)!!}
		{!!Form::textField('coach','チームコーチ',$team->coach)!!}
		{!!Form::textareaField('policy','指導方針や目標',$team->policy,['size'=>'30x3'])!!}
		{!!Form::textareaField('record','過去の主な実績',$team->record,['size'=>'30x5'])!!}
		{!!Form::textField('url_school','学校HP URL',$team->url_school)!!}
		{!!Form::textField('url_team','チームHP URL',$team->url_team)!!}
		{!!Form::textField('url_blog','ブログURL',$team->url_blog)!!}
		{!!Form::textField('url_facebook','Facebook URL',$team->url_facebook)!!}
		{!!Form::textField('url_twitter','Twitter URL',$team->url_twitter)!!}
		{!!Form::textField('url_instagram','Instagram URL',$team->url_instagram)!!}

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

<link href="//cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="/js/summernote.min.js"></script>
<script src="/js/summernote-ja-JP.js"></script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    lang: 'ja-JP', // default: 'en-US'
    height: 200,
    callbacks: {
        onImageUpload: function(files) {
            sendFile(files[0]);
        },
    }
  });

    function sendFile(file) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: "POST",
            url: "//ffa.tkss.xyz/upimg.php",
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