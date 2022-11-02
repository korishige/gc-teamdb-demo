@extends('layouts.plain')

@section('content')
<div class="x_panel">
    <ol class="breadcrumb">
      <a class="btn btn-default" href="{{route('login')}}">ログインに戻る</a>
      <li class="active">チーム情報登録</li>
    </ol>
    
	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('regist.completed'),'class'=>"form-horizontal form-label-left"])!!}

		{!!Form::staticField('email','メールアドレス',$user_input['email'])!!}

		<?php
		$groups = \App\Groups::get()->lists('name', 'id');
		?>
		{!!Form::staticField('group_id','所属リーグ',array_get($groups, $team->group_id))!!}

		{!!Form::staticField('name','チーム名',$team->name)!!}

        {!!Form::staticField('year','設立年',$team->year)!!}

		{!!Form::staticField('pref_id','都道府県',array_get(config('app.prefAry'),$team->pref_id))!!}
		{!!Form::staticField('add1','市区町村',$team->add1)!!}
		{!!Form::staticField('add2','以降の住所',$team->add2)!!}
		{!!Form::staticField('tel','TEL',$team->tel)!!}

		<div class="form-group">
			<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">エンブレム画像(500x500px目安）</label>
			<div class="col-sm-10">
				@if(isset($team->emblem_img))
				<img src="/upload/100/{{$team->emblem_img}}">
				@endif
			</div>
		</div>

		<div class="form-group">
			<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">集合写真(1000x750px目安）</label>
			<div class="col-sm-10">
				@if(isset($team->group_img))
				<img src="/upload/100/{{$team->group_img}}">
				@endif
			</div>
		</div>

		{!!Form::staticField('manager','チーム監督',$team->manager)!!}
		{!!Form::staticField('coach','チームコーチ',$team->coach)!!}
		{!!Form::staticField('policy','指導方針や目標',$team->policy,['size'=>'30x3'])!!}
		{!!Form::staticField('record','過去の主な実績',$team->record,['size'=>'30x5'])!!}
		{!!Form::staticField('url_school','学校HP URL',$team->url_school)!!}
		{!!Form::staticField('url_team','チームHP URL',$team->url_team)!!}
		{!!Form::staticField('url_blog','ブログURL',$team->url_blog)!!}
		{!!Form::staticField('url_facebook','Facebook URL',$team->url_facebook)!!}
		{!!Form::staticField('url_twitter','Twitter URL',$team->url_twitter)!!}
		{!!Form::staticField('url_instagram','Instagram URL',$team->url_instagram)!!}

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
@stop