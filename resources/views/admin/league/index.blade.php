@extends('layouts.admin')

@section('content')
@include('layouts.parts.error')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <ol class="breadcrumb">
        <a class="btn btn-default" href="{{route('admin.league.create')}}">大会追加</a>
        <li class="active">大会一覧</li>
      </ol>

      {!!Form::open(['method'=>'GET','url'=>route('admin.league.index'),'class'=>'form form-horizontal form-label-left'])!!}
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-inline">
              <div class="form-group">
                {!!Form::select('convention',config('app.conventionAry'),\Input::has('convention')?\Input::get('convention'):'',['class'=>'form-control','style'=>'width:200px','placeholder'=>'大会選択'])!!}
                {!!Form::select('group_id',\App\Groups::get()->lists('name', 'id'),\Input::has('group_id')?\Input::get('group_id'):'',['class'=>'form-control','style'=>'width:200px','placeholder'=>'リーグ選択'])!!}
                {!!Form::text('year',\Input::has('year')?\Input::get('year'):'',['class'=>'form-control','style'=>'width:100px','placeholder'=>'年度'])!!}
                {!!Form::select('season',config('app.seasonAry'),\Input::has('season')?\Input::get('season'):'',['class'=>'form-control','style'=>'width:100px','placeholder'=>'期日選択'])!!}
                {!!Form::text('keyword',\Input::has('keyword')?\Input::get('keyword'):'',['class'=>'form-control','style'=>'width:300px','placeholder'=>'大会名キーワード'])!!}
                
                <span style="margin-top:5px">
                {!!Form::submit('検索',['class'=>'btn btn-info','style'=>'margin-top:5px'])!!}
                <a class="btn btn-danger" href="{{route('admin.league.index')}}" style="margin-top:5px">検索条件リセット</a>
                </span>
              </div>
            </div>
          </div>
        </div>
      {!!Form::close()!!}
    </div>

    @if(isset($leagueObj) && count($leagueObj)>0)

    <table id="myTable" class="table table-striped jambo_table">
      <thead>
        <tr>
          <th>大会</th>
          <th width=130>所属リーグ</th>
          <th>年度</th>
          <th>期日</th>
          <th>大会名称(参加チーム数)</th>
          <th>試合消化率</th>
          <th class=" no-link last"><span class="nobr">操作</span> </th>
        </tr>
      </thead>

      <tbody>
        @foreach($leagueObj as $i=>$league)
        <tr class="pointer">
          <td>{{array_get(config('app.conventionAry'),$league->convention)}}</td>
          <td>{{array_get(\App\Groups::all()->lists('name','id'),$league->group_id)}}</td>
          <td>{{$league->year}}</td>
          <td>{{array_get(config('app.seasonAry'),$league->season)}}</td>
          <td>{{$league->name}} ({{$league->team->count()}}チーム) </td>
          <td>
            <?php
            $done_cnts = $league->filled_matches()->count();
            $total = $league->matches()->count();
            if($total!=0)
              $rate = number_format($done_cnts/$total,2)*100;
            else
              $rate = '-';
            ?>
            {{$rate}}% {{$done_cnts}} / {{$total}}
          </td>
          <td>
            <a href="{{route('admin.league.edit',['id'=>$league->id])}}" class="btn btn-primary btn-xs">編集</a>
            <a href="{{route('admin.match.index',['leagues_id'=>$league->id])}}" class="btn btn-warning btn-xs">試合日程</a>
            <a href="{{route('admin.league.closing',['leagues_id'=>$league->id])}}" class="btn btn-danger btn-xs">大会締め処理</a>

            <!-- <a href="{{route('admin.league.show',['id'=>$league->id])}}" class="btn btn-success btn-xs">順位表表示</a> -->
            <!-- <a href="{{route('admin.league.delete',['id'=>$league->id])}}" class="confirm btn btn-danger btn-xs">削除</a> -->

<!--                   <a href="{{route('admin.match.create',['leagues_id'=>$league->id])}}" class="btn btn-warning btn-xs">試合結果追加</a>
            <a href="{{route('admin.match.index',['leagues_id'=>$league->id])}}" class="btn btn-warning btn-xs">試合結果表示</a>
            <a href="{{route('admin.comment.index',['league_id'=>$league->id])}}" class="btn btn-info btn-xs">コメント一覧</a>
-->                </td>
        </tr>
        @endforeach
      </tbody>

    </table>
    @else
    <div class="well">
    登録された大会がありません
    </div>
    @endif

  </div>
</div>
@endsection
