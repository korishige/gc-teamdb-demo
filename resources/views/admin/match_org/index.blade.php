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
      <h3> {{$league->name or ''}} リーグ戦　試合結果一覧 </h3>
      <small><a class="btn btn-primary" href="{{route('admin.league.index')}}">リーグ一覧に戻る</a></small>
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

          @if(isset($matchObj) && count($matchObj)>0)

          <table id="myTable" class="table table-striped jambo_table">
            <thead>
              <tr>
                <th>試合日</th>
                <th>会場</th>
                <th>ニックネーム</th>
                <th>試合結果</th>
                <th class=" no-link last"><span class="nobr">操作</span> </th>
              </tr>
            </thead>

            <tbody>
              @foreach($matchObj as $i=>$match)
              <tr class="pointer">
                <td>{{$match->match_at}}</td>
                <td>{{$match->place}}</td>
                <td>{{$match->nickname}}</td>
                <td>
                  {{$match->home->name}} {{$match->home_pt}} - {{$match->away_pt}} {{$match->away->name}} 
                  @if($match->home_pt == $match->away_pt)
                  PK : {{$match->home_pk}} - {{$match->away_pk}}
                  @endif
                </td>
                <td>
                  <a href="{{route('admin.match.edit',['id'=>$match->id])}}" class="btn btn-primary btn-xs">編集</a>
                  <a href="{{route('admin.match.delete',['id'=>$match->id])}}" class="confirm btn btn-danger btn-xs">削除</a>
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>
          @else
          試合結果がありません
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@stop
