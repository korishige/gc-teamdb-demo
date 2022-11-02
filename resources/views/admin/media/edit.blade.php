@extends('layouts.admin')

@section('content')
<div class="x_panel">
	<div class="x_title">
		<h2>パーツ設定 <a class="btn btn-default btn-xs" href="/admin/parts">パーツ一覧に戻る</a></h2>
		<div class="clearfix"></div>
	</div>

  @if(Session::has('errors'))
  <div class="alert alert-danger" role="alert">
  @foreach(Session::get('errors')->all() as $msg)
  {{$msg}}<br>
  @endforeach
  </div>
  @endif

  @if(Session::get('msg'))
  <div class="alert alert-success">{{Session::get('msg')}}</div>
  @endif

  <div class="alert alert-danger" id="ajaxmsg" style="display:none"></div>

	<div class="x_content">
		<br>
    {{Form::open(['url'=>'/admin/parts/edit','class'=>'form-horizontal form-label-left','method'=>'post'])}}

			<input type="hidden" name="id" value="@if(isset($parts->id)){{$parts->id}}@else 0 @endif">

      {{Form::textField('name','パーツ名',$parts->name)}}
      {{Form::textField('slug','slug(英数字)',$parts->slug)}}
      {{Form::textareaField('tag','タグの中身',$parts->tag,['rows'=>15])}}

			<div class="ln_solid"></div>
			<div class="form-group">
				<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-2">
					<button type="submit" class="btn btn-success">保存</button>
				</div>
			</div>
    {{Form::close()}}
	</div>
</div>
@stop