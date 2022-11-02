@extends('layouts.admin')

@section('content')

@include('layouts.parts.message')
<div class="x_panel">
	<div class="x_title">
		<h2>サイト設定 <small>サイト全体の設定です</small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['class'=>'form-horizontal form-label-left','url'=>'/admin/config'])!!}
			{!!Form::textField('name','サイト名 <span class="label label-info">name</span>',$cfg->name)!!}
			{!!Form::textField('s_name','サイト名（短） <span class="label label-info">s_name',$cfg->s_name)!!}
			{!!Form::textField('description','meta description <span class="label label-info">description</span>',$cfg->description)!!}
			{!!Form::textField('keyword','meta keyword <span class="label label-info">keyword</span>',$cfg->keyword)!!}
			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2">
					<button type="submit" class="btn btn-primary">保存</button>
				</div>
			</div>
		{!!Form::close()!!}
	</div>
</div>

@stop