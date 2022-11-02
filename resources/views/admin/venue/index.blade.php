@extends('layouts.admin')
@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
@stop

@section('js')
<script>
	$(document).ready(function(){
		$('#blogList').dataTable({
			"order": [[ 0, "desc" ]],
			"pageLength": 25,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
			"stateSave": true,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
			},
			"aoColumnDefs": [ {
				'bSortable':false,'aTargets':[5]
			}]
		});
	});
</script>
@stop

@section('content')
<div class="x_panel">
	<ol class="breadcrumb">
		<a class="btn btn-default" href="{{route('admin.venue.create')}}">会場追加</a>
		<li class="active">会場一覧</li>
	</ol>

	<div class="x_content">
		<div class="text-left clr10"> </div>
		@if(count($obj) > 0)
		<table id="blogList" class="table table-striped jambo_table" width="100%" border="0">
			<thead>
				<tr class="headings">
					<th>ID</th>
					<th>会場名</th>
					<th>住所</th>
					<th>備考</th>
					<th>更新日</th>
					<th class=" no-link last"><span class="nobr">操作</span> </th>
				</tr>
			</thead>
			<tbody>
				@foreach($obj as $venue)
				<tr>
					<td>{{$venue->id}}</td>
					<td>
						@if($venue->url!='')
						<a href="{{$venue->url}}">{{$venue->name}}</a>
						@else
						{{$venue->name}}
						@endif
					</td>
					<td>
						{{array_get(config('app.prefAry'), $venue->pref_id)}}{{$venue->add1}}{{$venue->add2}}
					</td>
					<td>
						@if($venue->img!='')
						<img src="/upload/100/{{$venue->img}}">
						@endif
					</td>
					<td>{{date('Y-m-d',strtotime($venue->updated_at))}}</td>
					<td class="">
						<a href="{{route('admin.venue.edit',['id'=>$venue->id])}}" class="btn btn-primary btn-xs">編集</a>
						<a href="{{route('admin.venue.delete',['id'=>$venue->id])}}" class="btn btn-danger btn-xs confirm">削除</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<p>no venue</p>
		@endif
	</div>
</div>
@stop