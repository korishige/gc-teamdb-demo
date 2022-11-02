@extends('layouts.admin')

@section('content')
@include('layouts.parts.error')

<div class="x_panel">
    <ol class="breadcrumb">
        <li>{{$match->leagueOne->name}} </li>
        <li>第{{$match->section}}節 {{$match->match_date.' '.$match->match_time}}開始 {{array_get($teamObj,$match->home_id)}} vs {{array_get($teamObj,$match->away_id)}}</li>
        <li class="active">集合写真 投稿</li>
    </ol>

	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.result.group_photo.update'),'class'=>"form-horizontal form-label-left"])!!}
		{!!Form::hidden('id',$match->id)!!}

    <div class="form-group">
      <label for="id-field-name" class="control-label col-md-2 col-sm-12 col-xs-12">ホームチーム写真</label>
      <div class="col-sm-10 col-sm-12 col-xs-12">
        @if($match->home_photo)
        <img src="/upload/300/{{$match->home_photo}}">
        <input type="checkbox" value="1" name="home_photo_delete">写真削除
        @endif
        {!!Form::file('home_photo')!!}
      </div>
    </div>

    <div class="form-group">
      <label for="id-field-name" class="control-label col-md-2 col-sm-12 col-xs-12">アウェイチーム写真</label>
      <div class="col-sm-10 col-sm-12 col-xs-12">
        @if($match->away_photo)
        <img src="/upload/300/{{$match->away_photo}}">
        <input type="checkbox" value="1" name="away_photo_delete">写真削除
        @endif
        {!!Form::file('away_photo')!!}
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
@stop