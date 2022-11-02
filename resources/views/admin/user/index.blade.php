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
  <div class="clearfix"></div>
  <ol class="breadcrumb">
    <li class="active">ユーザ管理</li>
  </ol>

  <div class="x_content">
        <div class="text-left clr10">
        </div>
        @if(count($userObj) > 0)
        <table id="blogList" class="table table-striped jambo_table" width="100%" border="0">
          <thead>
            <tr class="headings">
              <th>ID</th>
              <th>チーム名</th>
              <th>都道府県</th>
              <th>Email</th>
              <th>登録日/更新日</th>
              <th class=" no-link last"><span class="nobr">操作</span> </th>
            </tr>
          </thead>
          <tbody>
          @foreach($userObj as $user)
          <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>
              @if($user->pref_id!=0)
                {{$user->pref->name}}
              @else
                <div class="btn btn-xs btn-danger">未設定</div>
              @endif
            </td>
            <td>{{$user->email}}</td>
            <td>{{date("Y-m-d",strtotime($user->created_at))}} / {{date("Y-m-d",strtotime($user->updated_at))}}</td>
            <td class="">
              <a href="{{route('admin.user.edit',['id'=>$user->id])}}" class="btn btn-primary btn-xs">編集</a>
              <a href="{{route('admin.user.delete',['id'=>$user->id])}}" class="btn btn-danger btn-xs">削除</a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        @else
        <p>no user</p>
        @endif
  </div>
</div>
@stop