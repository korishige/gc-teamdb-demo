@extends('layouts.admin')

@section('content')
<div class="x_panel">
  <ol class="breadcrumb">
    <li><a href="{{route('admin.user.index')}}">ユーザ管理</a></li>
    <li class="active">編集</li>
  </ol>

<!-- 	<div class="x_title">
		<h2>ユーザ情報編集 <small>　</small></h2>
		<div class="clearfix"></div>
	</div>
 -->
	<div class="x_content">
		<br>
		{!!Form::open(['url'=>route('admin.user.update'),'class'=>'form-horizontal form-label-left'])!!}
			{!!Form::hidden('id',$userObj->id)!!}

			{!!Form::staticField('oauth','認証形式',$userObj->oauth)!!}

			{!!Form::textField('name','名前',$userObj->name)!!}
			{!!Form::textField('nickname','ニックネーム',$userObj->nickname)!!}

			@if(Session::get('role')=='admin')
			{!!Form::rbinline('role','権限',['admin'=>'管理者','user'=>'ユーザ'],$userObj->role)!!}
			{!!Form::rbinline('is_active','状態',[0=>'無効',1=>'有効'],$userObj->is_active)!!}
			@endif

			{!!Form::selectField('pref_id','都道府県',Config::get('app.prefAry'),$userObj->pref_id)!!}
			@if($userObj->oauth=='email')
			{!!Form::textField('email','Eメール(ログイン時利用)',$userObj->email)!!}
			{!!Form::textField('password','パスワード',$userObj->password)!!}
			@endif

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