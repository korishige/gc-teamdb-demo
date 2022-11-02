@extends('layouts.admin')

@section('content')
<div class="">
  @include('layouts.parts.error')

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="clearfix"></div>
        <ol class="breadcrumb">
          <li class="active">{{$nendo}}年度 チーム別警告・退場累計</li>
        </ol>

        {!!Form::open(['url'=>route('admin.warning.year',['nendo'=>$nendo]),'method'=>'get','class'=>'form-inline'])!!}
          <div class="form-inline">
            <div class="form-group">
            {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'チーム名検索'])!!}
            </div>
            <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:5px">
          </div>
        {!!Form::close()!!}

        {!!Form::open(['url'=>route('admin.warning.year'),'method'=>'get','class'=>'form-inline'])!!}
          <div class="form-inline">
            <div class="form-group">
              {!!Form::select('nendo',['2021' => '2021','2022' => '2022'],\Input::has('nendo')?\Input::get('nendo'):'',['class'=>'form-control','style'=>'width:200px','placeholder'=>'年度変更','onchange'=>'submit(this.form)'])!!}
            </div>
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
            <th>年間累計警告・退場数</th>
            <th>警告</th>
            <th>退場</th>
            <th class=" no-link last"><span class="nobr">操作</span> </th>
          </tr>
        </thead>
        <tbody>
          @foreach($teams as $i=>$team)
          <?php
            $reds = \App\Cards::where('team_id', $team->id)->where('color', 'red')->where('nendo', $nendo)->get();
            $yellows = \App\Cards::where('team_id', $team->id)->where('color', 'yellow')->where('nendo', $nendo)->get();
          ?>
          <tr class="pointer">
            <td>{{$team->group->name or ''}}</td>
            <td>{{$team->name}} @if(!$team->user->is_active)<span class="btn btn-xs btn-danger">未認証</span>@endif</td>
            <td>{{count($reds) + count($yellows)}}</td>
            <td>{{count($yellows)}}</td>
            <td>{{count($reds)}}</td>
            <td>
              <a href="{{route('admin.warning.year.player',['id'=>$team->id, 'nendo'=>$nendo])}}" class="btn btn-info btn-xs">選手別警告数</a>
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
