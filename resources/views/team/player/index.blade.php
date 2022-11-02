@extends('layouts.team')

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function check(){
  if(window.confirm('一括削除してよろしいですか？')){ // 確認ダイアログを表示
    return true; // 「OK」時は送信を実行
  }
  else{ // 「キャンセル」時の処理
    window.alert('キャンセルされました'); // 警告ダイアログを表示
    return false; // 送信を中止
  }
}

$(function(){
  $(document).on('click','#toggle',function(){
    $('.chkbox').prop('checked', this.checked);
  });
})
</script>
@endsection

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/player.css" rel="stylesheet" type="text/css" />
@stop

@section('overlay')
<div class="content_title">
  <div class="inner">
    <h1>
      <span>選手情報</span>
      <span>PLAYER INFORMATION</span>
    </h1>
  </div><!-- /.inner -->
</div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')
<article>
  <div id="player">
    <div class="inner">
      <section>
        <div class="create row">
          <div class="col row">
            <h2>選手情報登録はこちらから</h2>
            <div class="btn">
              <a href="{{route('team.player.create')}}">選手新規登録</a>
            </div><!-- /.btn -->
          </div><!-- /.col -->

          <div class="col row inport">
            <h3>インポート</h3>
            <div class="form_area">
              {!!Form::open(['files'=>true,'url'=>route('team.player.import'),'method'=>'post','class'=>'row'])!!}
              {!!Form::file('csv')!!}
              {!!Form::submit('インポート',['class'=>'btn btn-primary'])!!}
              {!!Form::close()!!}
            </div><!-- /.btn -->
          </div><!-- /.col -->
        </div><!-- /.new_post -->
      </section>

      <section>
        <div class="search_inport">

          <h2>選手一覧</h2>

          <div class="search">
            <div class="col row narrow">
              <h3>絞り込み検索</h3>
              <?php
                $sub_teams = \App\Teams::where('organizations_id', $team->organizations_id)->lists('name', 'id');
                $sub_teams[0] = 'その他';
              ?>
              {!!Form::open(['url'=>route('team.player.index'),'method'=>'get','class'=>'row'])!!}
                {!!Form::select('team_id',$sub_teams,\Input::has('team_id')?\Input::get('team_id'):'',['class'=>'form-control','style'=>'width:15%','placeholder'=>'所属'])!!}
                {!!Form::select('school_year',$school_years,Input::has('school_year')?Input::get('school_year'):'',['class'=>'form-control','style'=>'width:15%','placeholder'=>'▼学年選択'])!!}
                {{-- {!!Form::select('is_block', config('app.is_block'), Input::has('is_block')?Input::get('is_block'):'',['class'=>'form-control','style'=>'width:15%','placeholder'=>'▼ブロック選択'])!!} --}}
                {!!Form::select('has_cards', ['0'=>'累積なし',1=>'累積あり'], Input::has('has_cards')?Input::get('has_cards'):'',['class'=>'form-control','style'=>'width:15%; margin-right: 1%;','placeholder'=>'▼累積'])!!}
                {!!Form::text('keyword',\Input::get('keyword'),['class'=>'form-control','placeholder'=>'選手名検索'])!!}
                <div class="btn">
                  <input type="submit" class="btn btn-primary" value="絞込" style="margin-top:5px">
                </div><!-- /.btn -->
              {!!Form::close()!!}
            </div><!-- /.col -->
          </div><!-- /.search -->

        </div><!-- /.search_inport -->

      </section>

      <section>

        <div class="list">
          <?php $qs = http_build_query(request()->query());?>

          {!!Form::open( ['method'=>'post', 'url'=>route('team.player.selected_delete'), 'class'=>'form-inline','onSubmit'=>'return check()'] )!!}
            <div class="head">
              <div class="number">
                <!-- 50 / 200選手 -->
              </div><!-- /.pager -->
              <div class="btn_delete">
                <button class="confirm btn btn-primary btn-xs">選択項目の一括削除</button>
                <!-- <a href="">選択項目の一括削除</a> -->
              </div><!-- /.btn_delete -->
            </div><!-- /.head -->

            {{-- <div id="block">
              <div id="term">
                <a>ブロック選手登録期間</a>
                @if(count($terms) != 0)
                @foreach ($terms as $i=>$term)
                  <table>
                    <tbody>
                      <th>期間{{$i + 1}}　{{$term->value}}</th>
                    </tbody>
                  </table>
                @endforeach
                @else
                  <br><a>現在期間が設定されていません</a>
                @endif
              </div>
            </div> --}}

            <div class="filter">
              <div class="title_bar row">
                <span>
                 <p>全選択</p>
                 <input type="checkbox" id="toggle">
               </span>
               <span><a href="?&sort=team&{{$qs}}">所属</a></span>
               <span>学年</span>
               <span>名前</span>
               <span><a href="?&sort=goals&{{$qs}}">得点</a></span>
               <span><a href="?sort=yellow&{{$qs}}">警告</a></span>
               <span><a href="?sort=red&{{$qs}}">退場</a></span>
               <span>編集</span>
             </div><!-- /.title -->

            @foreach($players as $i=>$player)
            <div class="box row">
              <div class="check">
                {!!Form::checkbox('id[]',$player->id,null,['class'=>'chkbox'])!!}
              </div><!-- /.check -->
              <div class="txt">
                <div class="top row">
                  @if($player->team_id == 0)
                    <span>その他</span>
                  @else
                    <span>{{$player->team_name}}</span>
                  @endif
                  <span>{{array_get(config('app.schoolYearAry'),$player->school_year)}}</span>
                  <span>{{$player->name}} @if($player->suspension_at)<div class="btn btn-xs btn-danger">出場停止中　消化日：{{$player->suspension_at}}</div>@endif</span>
                  <span>{{$player->goals}}</span>
                  <span>{{$player->yellow}}</span>
                  <span>{{$player->red}}</span>
                </div><!-- /.top -->
              </div><!-- /.txt -->
              <div class="btn">
                <a href="{{route('team.player.edit',['id'=>$player->id])}}">編集</a>
              </div><!-- /.btn -->
            </div><!-- /.box -->
            @endforeach

            {{--
            <div class="box row">
              <div class="check">
                <input type="checkbox" id="toggle">
              </div><!-- /.check -->
              <div class="txt">
                <div class="top row">
                  <span>1年</span>
                  <span>{{$player->name}} @if($player->is_block)<i class="fa fa-ban" style="font-size:18px;color:red"></i>@endif</span>
                  <span>1</span>
                  <span>1</span>
                  <span>10</span>
                </div><!-- /.top -->
                <div class="bottom row">
                  <div class="title">
                    累計履歴
                  </div>
                  <div class="s_half">
                    <span>前期</span>
                    <ul>
                      <li>2020年10月1日　警告1</li>
                      <li>2020年10月2日　警告1</li>
                      <li>2020年10月3日　警告1</li>
                    </ul>
                  </div><!-- /.s_half -->
                  <div class="f_half">
                    <span>後期</span>
                    <ul>
                      <li>2020年10月1日　警告1</li>
                      <li>2020年10月2日　警告1</li>
                      <li>2020年10月3日　警告1</li>
                    </ul>
                  </div><!-- /.s_half -->
                </div><!-- /.bottom -->
              </div><!-- /.txt -->
              <div class="btn">
                <a href="{{route('team.player.edit',['id'=>$player->id])}}">編集</a>
              </div><!-- /.btn -->
            </div><!-- /.box -->              
            --}}

          </div><!-- /.filter --> 

          <div class="btn row">
            <div class="pager">
              <ul>
                {!! $players->appends(Input::except('page'))->render(); !!}
              </ul>
            </div><!-- /.pager -->
          </div><!-- /.btn -->

        </form>

      </div><!-- /.list -->
    </section>

  </div><!-- /.inner -->
</div>
</article>
@endsection
