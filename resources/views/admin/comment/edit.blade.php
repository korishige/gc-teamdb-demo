@extends('layouts.admin')

@section('content')

@if(Session::has('msg'))
<div class="alert alert-success alert-msg">{{Session::get('msg')}}</div>
@endif

<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.league.index')}}">リーグ一覧</a></li>
	  <li><a href="{{route('admin.comment.index',['league_id'=>$league->id])}}">コメント一覧</a></li>
	  <li class="active">コメント編集</li>
	</ol>

	<div class="x_title">
		<h2>コメント編集
			<small>{{$comment->id}}</small>
			<p class="label label-info">作成日:{{$comment->created_at}}</p>
			<p class="label label-success">更新日:{{$comment->updated_at}}</p>
		</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.comment.update'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::hidden('id',$comment->id)!!}
			{!!Form::hidden('leagues_id',$league->id)!!}
			{!!Form::hidden('match_id',$match->id)!!}

			<div class="form-group">
				<label class="league_label">試合へのコメント</label>
				<div class="input_area">
					{!!Form::textarea('comment',$comment->comment,['class'=>'form-control','rows'=>10])!!}
				</div>
			</div>

			<div class="form-group">
				<label class="league_label">試合の画像をアップする</label>
				<div class="input_area">
					@if($comment->img!='')
					<img src="/uploads/100/{{$comment->img}}">
					{!!Form::hidden('img_del',0)!!}
					{!!Form::checkbox('img_del',1)!!}既存画像を削除する
					@endif
					{!!Form::file('img',['class'=>'form-control'])!!}
				</div>
			</div>

			<div class="form-group">
				<label class="league_label">動画のURLを記入する（youtubeなど）</label>
				<div class="input_area">
					{!!Form::text('mov',$comment->mov,['class'=>'form-control','placeholder'=>'動画URL'])!!}
				</div>
			</div>

			<div class="form-group">
				<label class="league_label">ニックネーム</label>
				<div class="input_area">
					{!!Form::text('nickname',$comment->nickname,['placeholder'=>'ニックネームを入力','class'=>'form-control'])!!}
				</div>
			</div>

			<div class="form-group">
				<label class="league_label">パスワード</label>
				<div class="input_area">
					{!!Form::text('pass',$comment->pass,['class'=>'form-control'])!!}
				</div>
			</div>

			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="submit_area">
					<button type="submit" class="submit_btn">コメントを変更する</button>
				</div>
			</div>

		{!!Form::close()!!}
	</div>
</div>
@stop