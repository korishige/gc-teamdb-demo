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

	<div class="x_content">
		@if(isset($templates) && count($templates)>0)

      <table id="myTable" class="table table-striped jambo_table" style="width: 50%; margin: 0 auto;">
        <thead>
          <tr>
            <th>大会名</th>
            <th class=" no-link last"><span class="nobr">操作</span> </th>
          </tr>
        </thead>
        <tbody>
          @foreach($templates as $i=>$template)
          <tr class="pointer">
            <td>{{config('app.conventionAry')[$template->convention]}}</td>
            <td>
              <a href="{{route('admin.template.edit',['id'=>$template->id])}}" class="btn btn-primary btn-xs">編集</a>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>

		@else
			登録されたチームがありません
		@endif

	</div>
</div>

@stop