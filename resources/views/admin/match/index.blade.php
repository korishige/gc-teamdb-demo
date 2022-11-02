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
@include('layouts.parts.error')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="clearfix"></div>
      <ol class="breadcrumb">
        <a class="btn btn-default" href="{{route('admin.match.create',['league_id'=>$league->id])}}">日程追加</a>
        <li><a href="{{route('admin.league.index')}}">大会一覧に戻る</a></li>
        <li class="active">{{$league->name or ''}}  日程一覧</li>
      </ol>

      <div class="clearfix"></div>

      <br>

      @if(isset($matchObj) && count($matchObj)>0)

        <table id="myTable" class="table table-striped jambo_table">
          <thead>
            <tr>
              <th width="130">結果入力状況</th>
              <th width="100">公開状況</th>
              <th>節</th>
              <th>試合日 開始時刻</th>
              <th>責任チーム</th>
              <th>非責任チーム</th>
              <th>会場</th>
              <th>審判チーム</th>
              <th class=" no-link last"><span class="nobr">操作</span> </th>
            </tr>
          </thead>

          <tbody>
            @foreach($matchObj as $i=>$match)
            <tr class="pointer">
              <td>
                @if($match->is_filled == 0)
                <span class="btn btn-xs btn-warning">
                  {{array_get(config('app.is_filled'),$match->is_filled)}}
                </span>
                @else
                {{array_get(config('app.is_filled'),$match->is_filled)}}
                @endif
              </td>
              <td>
                @if($match->is_publish == 0)
                  <span class="btn btn-xs btn-danger">
                    {{array_get(config('app.is_publish'),$match->is_publish)}}
                  </span>
                @elseif($match->is_publish == 1)
                    {{array_get(config('app.is_publish'),$match->is_publish)}}
                @elseif($match->is_publish == 1)
                  <span class="btn btn-xs btn-warning">
                    {{array_get(config('app.is_publish'),$match->is_publish)}}
                  </span>
                @else
                  <span class="btn btn-xs btn-dark">
                    {{array_get(config('app.is_publish'),$match->is_publish)}}
                  </span>
                @endif
              </td>
              <td>{{$match->section}}</td>
              <td>
                @if($match->is_publish != 3)
                  {{$match->match_date}} {{$match->match_time}}
                @else
                  <span class="btn btn-xs btn-dark">
                    {{array_get(config('app.is_publish'),$match->is_publish)}}
                  </span>
                @endif
              </td>
              <td>{{$match->home0->name}}</td>
              <td>{{$match->away0->name}}</td>
              <td>{{$match->place->name}}</td>
              <td>{{$match->judge->name or 'その他'}}</td>
              <td>
                <a href="{{route('admin.match.edit',['id'=>$match->id])}}" class="btn btn-primary btn-xs">編集</a>
                {{--<a href="{{route('admin.match.delete',['league_id'=>$league->id, 'id'=>$match->id])}}" class="confirm btn btn-danger btn-xs">削除</a>--}}
              </td>
            </tr>
            @endforeach
          </tbody>

        </table>
      @else
        日程がまだ登録されていません
      @endif

  </div>
</div>
@stop
