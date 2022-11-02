@extends('layouts.admin')

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.sports.index')}}">スポーツ管理</a></li>
	  <li class="active">スポーツ追加</li>
	</ol>
	
	<div class="x_title">
		<h2>スポーツ追加</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.sports.store'),'class'=>'form-horizontal form-label-left'])!!}

			{!!Form::textField('name','競技名',old('name'))!!}
			{{--
			{!!Form::selectField('category_id','カテゴリ',$def['pref'],old('category_id'))!!}
			--}}
			{!!Form::textField('slug','スラグ(英数字名称)',old('slug'))!!}

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