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
  <ol class="breadcrumb">
    <li><a href="{{route('admin.league.index')}}">リーグ一覧</a></li>
    <li class="active">コメント一覧</li>
  </ol>

  <div class="page-title">
    <div class="title_left">
      <h3> コメント一覧 </h3>
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

          @if(isset($commentObj) && count($commentObj)>0)

          <table id="myTable" class="table table-striped jambo_table">
            <thead>
              <tr>
                <th>リーグ戦名称</th>
                <th>ニックネーム</th>
                <th>コメント</th>
                <th class=" no-link last"><span class="nobr">操作</span> </th>
              </tr>
            </thead>

            <tbody>
              @foreach($commentObj as $i=>$comment)
              <tr class="pointer">
                <td>{{$league->name}}
                @if($comment->mov!='')
                <a href="{{$comment->mov}}" target="_blank" class="btn btn-danger btn-xs">動画リンク</a>
                @endif
                </td>
                <td>{{$comment->nickname}}</td>
                <td>
                @if($comment->img!='')
                <img src="/uploads/100/{{$comment->img}}">
                @endif
                {{nl2br(e($comment->comment))}}
                </td>
                <td>
                  <a href="{{route('admin.comment.edit',['id'=>$comment->id])}}" class="btn btn-primary btn-xs">編集</a>
                  <a href="{{route('admin.comment.delete',['id'=>$comment->id])}}" class="confirm btn btn-danger btn-xs">削除</a>
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>
          @else
          コメントがありません
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@stop
