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
          出場停止消化日編集ページ
        </ol>

      <div class="x_panel">
        <div class="x_content">

          <a style="font-size: 20px;">{{$player->name}}選手</a><br><br>
          <a style="font-size: 20px;">出場停止消化日：{{$player->suspension_at}}</a><br><br>

          {!!Form::open(['url'=>route('admin.warning.update'),'class'=>"form-horizontal form-label-left"])!!}
          {!!Form::hidden('id',$player->id)!!}
          <div class="form-row">
            <div class="col-md-3 mb-1">
              <input type="datetime-local" name="suspension_at" class="form-control">
            </div>
            <div class="col-md-2 mb-1">
              <button type="submit" class="btn btn-success">保存</button>
            </div>
          </div>
          {!!Form::close()!!}
          <br>
          <a href="{{route('admin.warning.index')}}"><button class="btn btn-primary">警告者一覧に戻る</button></a>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
