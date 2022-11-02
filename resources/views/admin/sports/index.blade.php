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
      'bSortable':false,'aTargets':[4]
    }]
  });
});
</script>
@stop

@section('content')
<div class="x_panel">
  <div class="x_title">
    <h2>スポーツリスト <small>現在登録されているスポーツ一覧です</small></h2>
    <div class="clearfix"></div>
    <a class="btn btn-default" href="{{route('admin.sports.create')}}">スポーツ追加</a>
  </div>

  <div class="x_content">
    <div class="text-left clr10"> </div>
    @if(count($obj) > 0)
    <table id="blogList" class="table table-striped jambo_table" width="100%" border="0">
      <thead>
        <tr class="headings">
          <th>ID</th>
          <th>名称</th>
          <th>slug</th>
          <th>登録日/更新日</th>
          <th class=" no-link last"><span class="nobr">操作</span> </th>
        </tr>
      </thead>
      <tbody>
      @foreach($obj as $sports)
      <tr>
        <td>{{$sports->id}}</td>
        <td>{{$sports->name}}</td>
        <td>{{$sports->slug}}</td>
        <td>{{$sports->created_at}}<br>{{$sports->updated_at}}</td>
        <td class="">
          <a href="{{route('admin.sports.edit',['id'=>$sports->id])}}" class="btn btn-primary btn-xs">編集</a>
          <a href="{{route('admin.sports.delete',['id'=>$sports->id])}}" class="btn btn-danger btn-xs">削除</a>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
    @else
    <p>no sports</p>
    @endif
  </div>
</div>
@stop