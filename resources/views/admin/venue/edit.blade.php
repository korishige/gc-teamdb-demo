@extends('layouts.admin')

@section('js')
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
@endsection

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
	  <li><a href="{{route('admin.venue.index')}}">会場管理</a></li>
	  <li class="active">会場編集</li>
	</ol>

	<div class="x_title">
		<h2>会場編集</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<br>
		{!!Form::open(['files'=>true,'url'=>route('admin.venue.update'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::hidden('id',$obj->id)!!}

			{!!Form::textField('name','会場名',$obj->name)!!}
	        <div class="form-group">
	          <label for="id-field-zip" class="control-label col-md-2 col-sm-2 col-xs-12">郵便番号<span class="req">*</span></label>
	          <div class="col-md-10 col-sm-10 col-xs-12">
	            <input class="form-control col-md-10 col-sm-10 col-xs-12" id="id-field-zip" placeholder="123-4567" onKeyUp="AjaxZip3.zip2addr(this,'','pref_id','add1');" name="zip" type="text" value="{{$obj->zip}}">
	            <p>郵便番号を入力すると自動で番地の前までの住所が入力されます</p>
	          </div>
	        </div>
			{!!Form::selectField('pref_id','都道府県',config('app.prefAry'),$obj->pref_id)!!}
			{!!Form::textField('add1','市区町村',$obj->add1)!!}
			{!!Form::textField('add2','以降の住所',$obj->add2)!!}
			{!!Form::textareaField('access','アクセス',$obj->access, ['size'=>'3x3'])!!}
			{!!Form::textField('tel','電話番号',$obj->tel)!!}
			{!!Form::textField('url','URL',$obj->url)!!}
			{!!Form::textField('parking','駐車場',$obj->parking)!!}
			{!!Form::textareaField('note','メモ',$obj->note, ['size'=>'3x3'])!!}

			<div class="form-group">
				<label for="id-field-name" class="control-label col-md-2 col-sm-2 col-xs-12">写真</label>
				<div class="col-sm-10">
					@if($obj->img)
					<img src="/upload/100/{{$obj->img}}">
					<input type="checkbox" value="1" name="img_delete">写真削除
					@endif
					{!!Form::file('img')!!}
				</div>
			</div>

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