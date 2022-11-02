@extends('layouts.admin')

@section('js')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@endsection

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.organization.index')}}">組織管理</a></li>
	  <li class="active">組織編集</li>
	</ol>

	<div class="x_title">
		<h2>組織編集</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.organization.update'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::hidden('id',$obj->id)!!}

			{!!Form::textField('name','組織名',$obj->name)!!}
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