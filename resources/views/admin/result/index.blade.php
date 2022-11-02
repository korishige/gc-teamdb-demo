@extends('layouts.admin')

@section('content')
@include('layouts.parts.error')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="clearfix"></div>
      <ol class="breadcrumb">
        <li class="active">試合結果一覧</li>
      </ol>

      <div class="clearfix"></div>

      {!! $matches->appends(Input::except('page'))->render(); !!}

      {!!Form::open(['method'=>'GET','url'=>route('admin.result.index'),'class'=>'form form-horizontal form-label-left'])!!}
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-1">
            <div class="form-inline">
              <div class="form-group">
                {!!Form::select('group_id',\App\Groups::get()->lists('name', 'id'),\Input::has('group_id')?\Input::get('group_id'):'',['class'=>'form-control','style'=>'width:200px','placeholder'=>'リーグ選択'])!!}
                {!!Form::text('year',\Input::has('year')?\Input::get('year'):'',['class'=>'form-control','style'=>'width:100px','placeholder'=>'年度'])!!}
                {!!Form::select('season',config('app.seasonAry'),\Input::has('season')?\Input::get('season'):'',['class'=>'form-control','style'=>'width:100px','placeholder'=>'期日選択'])!!}
                {!!Form::text('keyword',\Input::has('keyword')?\Input::get('keyword'):'',['class'=>'form-control','style'=>'width:300px','placeholder'=>'大会名キーワード'])!!}
                
                <span style="margin-top:5px">
                {!!Form::submit('検索',['class'=>'btn btn-info','style'=>'margin-top:5px'])!!}
                <a class="btn btn-danger" href="{{route('admin.result.index')}}" style="margin-top:5px">検索条件リセット</a>
                </span>
              </div>
            </div>
          </div>
        </div>
      {!!Form::close()!!}

      <br>

      @if(isset($matches) && count($matches)>0)

      <table id="myTable" class="table table-striped jambo_table">
        <thead>
          <tr>
            <th>試合名</th>
            <th>責任校</th>
            <th width="130">更新状況</th>
            <th width="100">配信状況</th>
            <th width="130">試合日時</th>
            <th width="150">更新日時</th>
            {{--<th>会場</th>
            <th>審判チーム</th>--}}
            <th class=" no-link last"><span class="nobr">操作</span> </th>
          </tr>
        </thead>

        <tbody>
          @foreach($matches as $i=>$match)
          <tr class="pointer">
            <td>{{$match->leagueOne->name}} {{array_get(\App\Groups::get()->lists('name', 'id'),$match->leagueOne->group_id)}} {{array_get(config('app.seasonAry'),$match->leagueOne->season)}}<br>第{{$match->section}}節 {{$match->home0->name}} vs {{$match->away0->name}}</td>
            <td>{{$match->home0->name}}</td>
            <td>{{array_get(config('app.is_filled'),$match->is_filled or 0)}}</td>
            <td>{{array_get(config('app.is_publish'),$match->is_publish or 0)}}</td>
            <td>{{$match->match_date}} {{$match->match_time}}</td>
            <td>{{$match->updated_at}}</td>
            {{--
            <td>{{$match->place->name}}</td>
            <td>{{$match->judge->name}}</td>
            --}}
            <td>
              <!-- <a href="{{route('admin.match.edit',['league_id'=>$match->leagueOne->id, 'id'=>$match->id])}}" class="btn btn-primary btn-xs">編集</a> -->
              <a href="{{route('admin.result.edit',['id'=>$match->id])}}" class="btn btn-primary btn-xs">結果編集</a>
              @if(config('app.debug'))
              <a href="{{route('admin.result.group_photo.edit',['id'=>$match->id])}}" class="btn btn-info btn-xs">集合写真</a>
              <a href="{{route('admin.result.gallery.edit',['id'=>$match->id])}}" class="btn btn-default btn-xs">ギャラリー</a>
              @endif
              {{--<a href="{{route('admin.match.delete',['league_id'=>$league->id, 'id'=>$match->id])}}" class="confirm btn btn-danger btn-xs">削除</a>--}}
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
      @else
      該当する試合がありません
      @endif

  </div>
</div>
@stop
