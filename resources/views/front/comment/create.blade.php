@extends('layouts.front1',['title'=>config('app.aspnameK')])

@section('contents')
<div id="content">
	<div class="inner clearfix">
		<main>
			
			<h2 class="bar"> コメント投稿 </h2>
			
			<div id="title_box" class="clearfix">
				
				<h3 class="comment"> {{$league->name}}リーグ<br>
					@if($match->match_at!='0000-00-00')
					{{date('m月d日',strtotime($match->match_at))}}<br>
					@endif
					{{$match->home->name}}{{$match->home_pt}}-{{$match->away_pt}}{{$match->away->name}}　の試合へのコメント
				</h3>
				
				<div id="nav_box" class="comment">
					<div id="nav_create"><a href="{{route('front.league.match',['id'=>$league->id])}}">詳細へ戻る</a></div>
				</div>
				
			</div>
			<!-- /.title box -->

		<div class="league_input">
			{!!Form::open(['files'=>true,'url'=>route('front.comment.store'),'class'=>'form-horizontal form-label-left'])!!}
				{!!Form::hidden('leagues_id',$league->id)!!}
				{!!Form::hidden('match_id',$match->id)!!}

				<div class="form-group">
					<label class="league_label">試合への<br>コメント</label>
					<div class="input_area">
						{!!Form::textarea('comment',Input::old('comment'),['class'=>'form-control','rows'=>10])!!}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">試合の画像をアップする</label>
					<div class="input_area">
						{!!Form::file('img',['class'=>'form-control'])!!}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">動画のURLを記入する（youtubeなど）</label>
					<div class="input_area">
						{!!Form::text('mov',Input::old('mov'),['class'=>'form-control','placeholder'=>'動画URL'])!!}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">ニックネーム</label>
					<div class="input_area">
						{!!Form::text('nickname',Input::old('nickname'),['placeholder'=>'ニックネームを入力','class'=>'form-control'])!!}
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">パスワード</label>
					<div class="input_area">
						{!!Form::text('pass',Input::old('pass',mt_rand(1000,9999)),['class'=>'form-control'])!!}
				</div>
				</div>

				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="submit_area">
						<button type="submit" class="submit_btn">コメントを投稿する</button>
					</div>
				</div>

			{!!Form::close()!!}
		</div>
			
		</main>
		
		<aside>
			@include('layouts.parts.side')
		</aside>
	</div>
</div>
@endsection