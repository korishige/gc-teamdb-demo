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
          <li><a href="{{route('admin.warning.year',['nendo'=>$nendo])}}">チーム一覧</a></li>
          <li class="active">{{$nendo}}年度 {{$team->name}} 選手別警告・退場累計</li>
        </ol>

        {!!Form::open(['url'=>route('admin.warning.year.player',['id'=>$team->id, 'nendo'=>$nendo]),'method'=>'get','class'=>'row form-inline'])!!}
          {!!Form::hidden('id',\Input::get('id'))!!}
          {!!Form::select('school_year',config('app.schoolYearAry')+["2019年OB"=>"2019年OB"],Input::has('school_year')?Input::get('school_year'):'',['class'=>'form-control','placeholder'=>'▼学年選択'])!!}
          {!!Form::select('is_block', config('app.is_block'), Input::has('is_block')?Input::get('is_block'):'',['class'=>'form-control','placeholder'=>'▼ブロック選手選択'])!!}
          {{-- {!!Form::select('has_cards', ['0'=>'累積なし',1=>'累積あり'], Input::has('has_cards')?Input::get('has_cards'):'',['class'=>'form-control','placeholder'=>'▼累積選択'])!!} --}}
          {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'選手名検索'])!!}
          <div class="btn">
            <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:10px">
          </div><!-- /.btn -->
        {!!Form::close()!!}
      </div>

      <div class="x_panel">
        <div class="x_content">

          <h3>{{$nendo}}年度　累計警告・退場:{{count($reds) + count($yellows)}}　累計警告:{{count($yellows)}}　累計退場{{count($reds)}}</h3><br>
          @foreach($another_players as $another_player)
            <?php $another_team = \App\Teams::find($another_player->team_id); ?>
            <h4>＊　警告：{{$another_player->yellow?null:0}}{{$another_player->yellow}}　退場：{{$another_player->red?null:0}}{{$another_player->red}}　の {{$another_player->name}} 選手は現在 {{$another_team->name}} に所属しています。</h4>
          @endforeach
          <br>

          @if(isset($players) && count($players)>0)
          <table id="myTable" class="table table-striped jambo_table">
            <thead>
              <tr>
                <th>学年</th>
                <th>名前（ブロック選手★）</th>
                <th><a href="?id={{$team->id}}&sort=all">年間累計警告・退場数</a></th>
                <th><a href="?id={{$team->id}}&sort=yellow">警告</a></th>
                <th><a href="?id={{$team->id}}&sort=red">退場</a></th>
                <th class=" no-link last"><span class="nobr">操作</span> </th>
              </tr>
            </thead>

            <tbody>
              @foreach($players as $i=>$player)
              <tr class="pointer">
                <td>{{array_get(config('app.schoolYearAry'),$player->school_year)}}</td>
                <td>{{$player->name}}　@if($player->is_block)★@endif</td>
                <td>{{$player->yellow + $player->red}}</td>
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
