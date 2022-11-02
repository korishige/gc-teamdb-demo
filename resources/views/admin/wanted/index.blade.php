@extends('layouts.admin')
@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
<style>
th{
white-space: nowrap;
}
</style>
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
    <h2>募集リスト <small>現在登録されている募集一覧です</small></h2>
    <div class="clearfix"></div>
    {{--<a class="btn btn-default" href="{{route('admin.wanted.create')}}">募集追加</a>--}}
  </div>

  <div class="x_content">
    <div class="text-left clr10"> </div>
    @if(count($obj) > 0)
    <table class="table table-striped jambo_table" width="100%" border="0">
      <thead>
        <tr class="headings">
          <th>ID</th>
          <th>募集タイトル</th>
          <th>都道府県/エリア</th>
          <th>ユーザ情報</th>
          <th width=400>PR</th>
          <th>更新日</th>
          <th class=" no-link last"><span class="nobr">操作</span> </th>
        </tr>
      </thead>
      <tbody>
      @foreach($obj as $wanted)
      <tr>
        <td>{{$wanted->id}}</td>
        <td>{{$wanted->title}}</td>
        <td>{{$wanted->pref->name}} @if($wanted->branch_id!=''){{$wanted->branch->name}}@endif</td>
        <td>{{$wanted->user->nickname}}</td>
        <td>{{$wanted->pr}}</td>
        <td>{{$wanted->updated_at}}</td>
        <td class="">
          <a href="{{route('admin.wanted.edit',['id'=>$wanted->id])}}" class="btn btn-primary btn-xs">編集</a>
          <a href="{{route('admin.wanted.delete',['id'=>$wanted->id])}}" class="btn btn-danger btn-xs">削除</a>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
    @else
    <p>no wanted</p>
    @endif
  </div>
</div>
@stop