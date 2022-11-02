@extends('layouts.admin')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3> {{$league->name}} リーグ戦対戦表 </h3>
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
                <th></th>
                @foreach($resultObj as $result)
                <th>{{$result->name}}
                @endforeach
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($table as $row)
              <tr class="pointer">
                <td></td>
                @foreach($row as $col)
                <td>
                @foreach($col as $val)
                {{$val}}<br>
                @endforeach
                </td>
                @endforeach
                <td></td>
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
