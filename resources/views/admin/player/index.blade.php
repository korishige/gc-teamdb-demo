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
          <li><a href="{{route('admin.team.index')}}">チーム一覧</a></li>
          <li class="active">{{$team->name}} 選手管理</li>
        </ol>

        {!!Form::open(['url'=>route('admin.team.player.index'),'method'=>'get','class'=>'row form-inline'])!!}
          {!!Form::hidden('id',\Input::get('id'))!!}
          {!!Form::select('school_year',config('app.schoolYearAry')+["2019年OB"=>"2019年OB"],Input::has('school_year')?Input::get('school_year'):'',['class'=>'form-control','placeholder'=>'▼学年選択'])!!}
          {!!Form::select('is_block', config('app.is_block'), Input::has('is_block')?Input::get('is_block'):'',['class'=>'form-control','placeholder'=>'▼ブロック選手選択'])!!}
          {!!Form::select('has_cards', ['0'=>'累積なし',1=>'累積あり'], Input::has('has_cards')?Input::get('has_cards'):'',['class'=>'form-control','placeholder'=>'▼累積選択'])!!}
          {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'選手名検索'])!!}
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
                <th>学年</th>
                <th>名前</th>
                <th><a href="?id={{$team->id}}&sort=goals">得点</a></th>
                <th><a href="?id={{$team->id}}&sort=yellow">警告</a></th>
                <th><a href="?id={{$team->id}}&sort=red">退場</a></th>
                <th class=" no-link last"><span class="nobr">操作</span> </th>
              </tr>
            </thead>

            <tbody>
              @foreach($players as $i=>$player)
              <tr class="pointer">
                <td>{{array_get(config('app.schoolYearAry'),$player->school_year)}}</td>
                <td>{{$player->name}}</td>
                <td>{{$player->goals}}</td>
                <td>{{$player->yellow}}</td>
                <td>{{$player->red}}</td>
                <td>
                  <a href="{{route('admin.team.player.edit',['id'=>$player->id])}}" class="btn btn-primary btn-xs">編集</a>
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>
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
