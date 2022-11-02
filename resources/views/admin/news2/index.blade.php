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
    <a class="btn btn-default" href="{{route('admin.news2.create')}}">外部向けお知らせ追加</a>
    <li class="active">外部向けお知らせ一覧</li>
  </ol>

  <div class="x_content">
    <div class="text-left clr10"> </div>
    @if(count($obj) > 0)
    <table id="blogList" class="table table-striped jambo_table" width="100%" border="0">
      <thead>
        <tr class="headings">
          <th width="50">ID</th>
          <th width="100">ステータス</th>
          <th>タイトル</th>
          <th>本文</th>
          <th width="200">登録日/更新日</th>
          <th width="100" class=" no-link last"><span class="nobr">操作</span> </th>
        </tr>
      </thead>
      <tbody>
      @foreach($obj as $news)
      <tr>
        <td>{{$news->id}}</td>
        <td>{{array_get(config('app.is_publish'),$news->is_publish)}}</td>
        <td>{{$news->title}}</td>
        <td>{!!nl2br(e($news->body))!!}</td>
        <td>{{date('Y-m-d',strtotime($news->created_at))}} / {{date('Y-m-d',strtotime($news->updated_at))}}</td>
        <td class="">
          <a href="{{route('admin.news2.edit',['id'=>$news->id])}}" class="btn btn-primary btn-xs">編集</a>
          <a href="{{route('admin.news2.delete',['id'=>$news->id])}}" class="btn btn-danger btn-xs confirm">削除</a>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
    @else
    <p>no news</p>
    @endif
  </div>
</div>
@stop