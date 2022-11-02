@extends('layouts.admin')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3> {{$league->name}} リーグ戦順位表 </h3>
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

          @if(count($resultObj)>0)

          <table id="myTable" class="table table-striped jambo_table">
            <thead>
              <tr>
                <th>順位</th>
                <th>チーム名</th>
                <th>勝点</th>
                <th>試合数</th>
                <th>勝数</th>
                <th>引分</th>
                <th>負数</th>
                <th>得点</th>
                <th>失点</th>
                <th>得失点差</th>
              </tr>
            </thead>

            <tbody>
              @foreach($resultObj as $i=>$result)
              <tr class="pointer">
                <td>{{$result->rank}}</td>
                <td>{{$result->name}}</td>
                <td>{{$result->win_pt}}</td>
                <td>{{$result->match_cnt}}</td>
                <td>{{$result->win_cnt}}</td>
                <td>{{$result->draw_cnt}}</td>
                <td>{{$result->lose_cnt}}</td>
                <td>{{$result->get_pt}}</td>
                <td>{{$result->lose_pt}}</td>
                <td>{{$result->get_lose}}</td>
              </tr>
              @endforeach
            </tbody>

          </table>
          @else
          リーグ戦がありません
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@stop
