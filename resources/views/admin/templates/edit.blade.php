@extends('layouts.admin')

@section('content')
<style>
.x_content textarea{line-height:20px !important;}
</style>

<div class="x_panel">
	<ol class="breadcrumb">
		<li><a href="{{route('admin.top')}}">HOME</a></li>
		<li class="active">ページデザイン編集</li>
	</ol>	

	<a href="{{route('admin.template.index')}}" class="btn btn-primary">戻る</a>

	<div class="x_content">
		{!!Form::open(['url'=>route('admin.template.update', ['id' => $template->id]),'class'=>'form-horizontal form-label-left'])!!}

		<div>
			<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class="active"><a href="#about" role="tab" id="about-tab" data-toggle="tab">協会について</a> </li>
				<li role="presentation"><a href="#abstract" role="tab" id="abstract-tab" data-toggle="tab">大会概要</a> </li>
				<li role="presentation"><a href="#sponsor" role="tab" id="sponsor-tab" data-toggle="tab">スポンサー募集</a> </li>
				<li role="presentation"><a href="#goods" role="tab" id="goods-tab" data-toggle="tab">グッズ販売</a> </li>
				<li role="presentation"><a href="#live" role="tab" id="live-tab" data-toggle="tab">LIVE配信</a> </li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade" id="abstract" aria-labelledby="abstract-tab">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="alert alert-info">URL &raquo; {{config('app.url')}}abstract</div>
						<textarea class="form-control" rows="20" name="abstract">{!!$template->abstract!!}</textarea>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<input type="submit" class="btn btn-primary" value="保存">
						<h4> <span class="label label-danger">変更中のデザインは保存してください</span></h4>
					</div>
				</div>

				<div role="tabpanel" class="tab-pane fade active in" id="about" aria-labelledby="about-tab">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="alert alert-info">URL &raquo; {{config('app.url')}}about</div>
						<textarea class="form-control" rows="20" name="about">{!!$template->about!!}</textarea>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<input type="submit" class="btn btn-primary" value="保存">
						<h4> <span class="label label-danger">変更中のデザインは保存してください</span></h4>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="goods" aria-labelledby="goods-tab">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="alert alert-info">URL &raquo; {{config('app.url')}}goods</div>
						<textarea class="form-control" rows="20" name="goods">{!!$template->goods!!}</textarea>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<input type="submit" class="btn btn-primary" value="保存">
						<h4> <span class="label label-danger">変更中のデザインは保存してください</span></h4>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="sponsor" aria-labelledby="sponsor-tab">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="alert alert-info">URL &raquo; {{config('app.url')}}sponsor</div>
						<textarea class="form-control" rows="20" name="sponsor">{!!$template->sponsor!!}</textarea>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<input type="submit" class="btn btn-primary" value="保存">
						<h4> <span class="label label-danger">変更中のデザインは保存してください</span></h4>
					</div>
				</div>

				<div role="tabpanel" class="tab-pane fade" id="live" aria-labelledby="live-tab">
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="alert alert-info">URL &raquo; {{config('app.url')}}live</div>
						<textarea class="form-control" rows="20" name="live">{!!$template->live!!}</textarea>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<input type="submit" class="btn btn-primary" value="保存">
						<h4> <span class="label label-danger">変更中のデザインは保存してください</span></h4>
					</div>
				</div>

			</div>
		</div>

		{!!Form::close()!!}

	</div>
</div>

@stop