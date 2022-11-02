@extends('layouts.admin')

@section('content')
<div class="">

  @if(Session::has('msg'))
  <div class="alert alert-success">{{Session::get('msg')}}</div>
  @endif

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <ol class="breadcrumb">
          {{-- <a href="{{route('admin.block.index')}}"><button class="btn">ブロック選手一覧</button></a> --}}
          {{-- <a href="{{route('admin.warning.index')}}"><button class="btn btn-primary">警告者一覧</button></a> --}}
          警告者一覧
        </ol>

        <a href="{{route('admin.warning.year', ['nendo' => config('app.nendo')])}}"><button class="btn btn-info">チーム別警告者</button></a>

        {!!Form::open(['url'=>route('admin.warning.index'),'method'=>'get','class'=>'row form-inline'])!!}
          {!!Form::hidden('id',\Input::get('id'))!!}
          {!!Form::select('group_id',\App\Groups::get()->lists('name', 'id'),\Input::has('group_id')?\Input::get('group_id'):'',['class'=>'form-control','style'=>'width:200px','placeholder'=>'リーグ選択'])!!}
          {!!Form::select('school_year',config('app.schoolYearAry'),Input::has('school_year')?Input::get('school_year'):'',['class'=>'form-control','placeholder'=>'▼学年選択'])!!}
          {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'チーム・選手名検索'])!!}
          <div class="btn">
            <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:10px">
          </div><!-- /.btn -->
        {!!Form::close()!!}
      </div>

      <div class="x_panel">
        <div class="x_content">

          @if(isset($players) && count($players)>0)
            <table id="myTable" class="table table-striped jambo_table">
              <thead>
                <tr>
                  <th><a href="?sort=group" style="text-decoration: none; color: white;">リーグ▼</a></th>
                  <th><a href="?sort=team" style="text-decoration: none; color: white;">チーム名▼</a></th>
                  <th><a href="?sort=school_year" style="text-decoration: none; color: white;">学年▼</a></th>
                  <th>名前</th>
                  <th><a href="?sort=yellow" style="text-decoration: none; color: white;">警告▼</a></th>
                  <th><a href="?sort=red" style="text-decoration: none; color: white;">退場▼</a></th>
                  <th><a href="?sort=suspension_at" style="text-decoration: none; color: white;">出場停止▼</a></th>
                </tr>
              </thead>

              <tbody>
                @foreach($players as $player)
                  <tr class="home">
                    <td>{{$player->group_name}}</td>
                    <td>{{$player->team_name}}</td>
                    <td>{{array_get(config('app.schoolYearAry'),$player->school_year)}}</td>
                    <td>{{$player->player_name}}</td>
                    <td>{{$player->yellow}}</td>
                    <td>{{$player->red}}</td>
                    <td>{{$player->suspension_at}}@if($player->suspension_at)&nbsp;&nbsp;<a href="{{route('admin.warning.edit',['id'=>$player->id])}}"><button class="btn btn-sm btn-primary">出場停止消化日を変更</button></a>@endif</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="btn row">
              <div class="pager">
                <ul>
                  {!! $players->appends(Input::except('page'))->render(); !!}
                </ul>
              </div><!-- /.pager -->
            </div><!-- /.btn -->
          @else
            <div class="well">
            該当する選手がいません
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
