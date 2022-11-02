@extends('layouts.admin')
@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
@stop

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
		<a class="btn btn-default" href="{{route('admin.organization.create')}}">組織追加</a>
		<li class="active">組織一覧</li>
	</ol>

	<div class="x_content">
		<div class="text-left clr10"> </div>
		@if(count($obj) > 0)
		<table id="blogList" class="table table-striped jambo_table" width="100%" border="0">
			<thead>
				<tr class="headings">
					<th>ID</th>
					<th>組織名</th>
					<th>更新日</th>
					<th class=" no-link last"><span class="nobr">操作</span> </th>
				</tr>
			</thead>
			<tbody>
				@foreach($obj as $organization)
				<tr>
					<td>{{$organization->id}}</td>
					<td>
						{{$organization->name}}
					</td>
					<td>{{date('Y-m-d',strtotime($organization->updated_at))}}</td>
					<td class="">
						<a href="{{route('admin.organization.edit',['id'=>$organization->id])}}" class="btn btn-primary btn-xs">編集</a>
						<a href="{{route('admin.organization.delete',['id'=>$organization->id])}}" class="btn btn-danger btn-xs confirm">削除</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<p>no organization</p>
		@endif
	</div>
</div>
@stop