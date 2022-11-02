@extends('layouts.admin')

@section('js')
<script>
  $(function(){
    $(document).on('click','button.confirm',function(){
      if(confirm('削除して良いですか？')) return true;
    });
  })
</script>
@stop

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3> リーグ戦 勝ち点設定一覧 </h3>
      <small><a class="btn btn-primary" href="{{route('admin.vpoint.create')}}">勝ち点設定追加</a></small>
    </div>
  </div>
  <div class="clearfix"></div>

  @if(Session::has('msg'))
  <div class="alert alert-success alert-msg">{{Session::get('msg')}}</div>
  @endif

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="x_panel">
        <div class="x_content">

          @if(isset($vpointObj) && count($vpointObj)>0)

          <table id="myTable" class="table table-striped jambo_table">
            <thead>
              <tr>
                <th>名称</th>
                <th>win</th>
                <th>lose</th>
                <th>draw</th>
                <th>pk_win</th>
                <th>pk_lose</th>
                <th>sort</th>
                <th class=" no-link last"><span class="nobr">操作</span> </th>
              </tr>
            </thead>

            <tbody>
              @foreach($vpointObj as $i=>$vpoint)
              <tr class="pointer">
                <td>{{$vpoint->name}}</td>
                <td>{{$vpoint->win}}</td>
                <td>{{$vpoint->lose}}</td>
                <td>{{$vpoint->draw}}</td>
                <td>{{$vpoint->pk_win}}</td>
                <td>{{$vpoint->pk_lose}}</td>
                <td>{{$vpoint->sort}}</td>
                <td>
                  <a href="{{route('admin.vpoint.edit',['id'=>$vpoint->id])}}" class="btn btn-primary btn-xs">編集</a>
                  <!-- <a href="{{route('admin.vpoint.delete',['id'=>$vpoint->id])}}" class="confirm btn btn-danger btn-xs">削除</a> -->
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>
          @else
          勝ち点加点設定がありません
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@stop
