@extends('layouts.admin')

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.wanted.index')}}">募集管理</a></li>
	  <li class="active">募集追加</li>
	</ol>
	
	<div class="x_title">
		<h2>募集追加</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.wanted.store'),'class'=>'form-horizontal form-label-left'])!!}

			{!!Form::textField('t_name','チーム名',old('t_name'))!!}
			{!!Form::selectField('sports_id','競技名',$sportsAry,old('sports_id'))!!}
			{!!Form::selectField('pref_id','都道府県',['*'=>'選択']+$def['pref']->toArray(),old('pref_id'),['id'=>'pref_id'])!!}
			{!!Form::selectField('branch_id','エリア',$branchAry,old('branch_id'),['id'=>'branch_id'])!!}
			
			{!!Form::textField('title','タイトル',old('title'))!!}
			{!!Form::textareaField('t_mokuhyo','チーム目標',old('t_mokuhyo'),['rows'=>2,'placeholder'=>'○○大会優勝　楽しくサークルをなど'])!!}
			{!!Form::textField('active_place','活動場所',old('active_place'),['placeholder'=>'○○体育館など'])!!}
			{!!Form::textField('active_time','活動時間',old('active_time'),['placeholder'=>'毎週月曜日19:00～21:00'])!!}
			{!!Form::textareaField('t_member','構成メンバー',old('t_member'),['rows'=>2,'placeholder'=>'男性10人、女性5人など'])!!}
			{!!Form::textareaField('t_average','平均年齢',old('t_average'),['rows'=>2,'placeholder'=>'20、30代が中心。男女半々くらい'])!!}
			{!!Form::textField('url','サークルURL',old('url'),['placeholder'=>'http://hoge.com/'])!!}
			{!!Form::textField('pr','PR',old('pr'))!!}
			{!!Form::textareaField('pr2','PR(長文)',old('pr2'),['rows'=>2])!!}
			{!!Form::textField('pr_movie','PR動画',old('pr_movie'),['placeholder'=>'youtubeなどの動画URLを入力'])!!}

			{!!Form::textareaField('target_person','こんな人を探してます',old('target_person'),['rows'=>2,'placeholder'=>'男女問わず、○○できる人、経験者、初心者、楽しく参加できる人など'])!!}
			{!!Form::textareaField('target_age','募集年齢',old('target_age'),['rows'=>2,'placeholder'=>'18歳～30歳くらいまで'])!!}

			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-2">
					<button type="submit" class="btn btn-success">保存</button>
				</div>
			</div>

		{!!Form::close()!!}
	</div>
</div>
@stop

@section('js')

@endsection