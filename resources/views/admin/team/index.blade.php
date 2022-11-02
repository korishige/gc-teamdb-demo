@extends('layouts.admin')

@section('content')
<div class="">
  @include('layouts.parts.error')

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="clearfix"></div>
        <ol class="breadcrumb">
          <a class="btn btn-default" href="{{route('admin.team.create')}}">チーム追加</a>
          <li class="active">チーム一覧</li>
        </ol>

        {!!Form::open(['url'=>route('admin.team.index'),'method'=>'get'])!!}
          <div class="form-inline">
            <div class="form-group">
            {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'チーム名検索'])!!}
            </div>
            <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:5px">
          </div>
        {!!Form::close()!!}
      </div>

      {!! $teams->appends(Input::except('page'))->render(); !!}
      
      @if(isset($teams) && count($teams)>0)

      <table id="myTable" class="table table-striped jambo_table">
        <thead>
          <tr>
            <th width=130>所属リーグ</th>
            <th>チーム名</th>
            {{-- <th>ブロック選手数</th> --}}
            <th>警告者数</th>
            <th>ログインID</th>
            <th>監督名</th>
            <th class=" no-link last"><span class="nobr">操作</span> </th>
          </tr>
        </thead>
        <tbody>
          @foreach($teams as $i=>$team)
          <?php $cards = \App\Cards::where('team_id', $team->id)->get(); ?>
          <tr class="pointer">
            <td>{{$team->group->name or ''}}</td>
            <td>{{$team->name}} @if(!$team->user->is_active)<span class="btn btn-xs btn-danger">未認証</span>@endif</td>
            {{-- <td>{{$team->block_players()}}</td> --}}
            <td>{{count($cards)}}</td>
            <td>{{$team->user->email}}</td>
            <td>{{$team->manager}}</td>
            <td>
              <a href="{{route('admin.team.edit',['id'=>$team->id])}}" class="btn btn-primary btn-xs">編集</a>
              <a href="{{route('admin.team.player.index',['id'=>$team->id])}}" class="btn btn-info btn-xs">選手一覧</a>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
      @else
      登録されたチームがありません
      @endif

    </div>
  </div>

</div>
@endsection
