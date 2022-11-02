@extends('layouts.admin')

@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3> メディア管理 <small></small></h3>
		</div>
	</div>
	<div class="clearfix"></div>

	@if(Session::has('msg'))
	<div class="alert alert-success alert-msg">{{Session::get('msg')}}</div>
	@endif

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
				{{Form::open(['url'=>'/admin/media','files'=>true,'class'=>'form-horizontal form-label-left','method'=>'post'])}}
				@for($i=0;$i<5;$i++)
					{{Form::file("upfile[$i]",['style'=>'line-height:30px'])}}
				@endfor
				{{Form::submit('アップロード',['class'=>'btn btn-primary'])}}
				{{Form::close()}}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					@if(isset($media) && count($media)>0)
					@foreach($media as $m)
					<div class="col-md-55">
						<div class="thumbnail">
							<div class="image view view-first">
								<img style="width: 100%; display: block;" src="/uploads/300/{{$m->name}}" alt="{{$m->title}}">
								<div class="mask no-caption">
									<div class="tools tools-bottom">
										<a href="/uploads/300/{{$m->name}}" target="_blank"><i class="fa fa-link"></i></a>
										<!--<a href="#"><i class="fa fa-pencil"></i></a>-->
										<a href="/admin/media/del/{{$m->id}}" class="confirm"><i class="fa fa-times"></i></a>
									</div>
								</div>
							</div>
							<div class="caption">
								<p><strong>{{$m->title}}</strong> <a href="/admin/media/del/{{$m->id}}" class="confirm"><i class="fa fa-times"></i></a></p>
								<p>
									<a href="/uploads/org/{{$m->name}}" target="_blank">ORG</a>
									<a href="/uploads/100/{{$m->name}}" target="_blank">100</a>
									<a href="/uploads/300/{{$m->name}}" target="_blank">300</a>
									<a href="/uploads/100_crop/{{$m->name}}" target="_blank">100C</a>
									<a href="/uploads/300_crop/{{$m->name}}" target="_blank">300C</a>
								</p>

							</div>
						</div>
					</div>
					@endforeach
					@else
					メディアがありません
					@endif
				</div>
			</div>
		</div>
	</div>

</div>
@stop
