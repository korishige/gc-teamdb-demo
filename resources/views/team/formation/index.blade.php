@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/team.css" rel="stylesheet" type="text/css" />
@stop

@section('overlay')
  <div class="content_title">
      <div class="inner">
            <h1>
                <span>チーム編成</span>
                <span>TEAM FORMATION</span>
            </h1>
      </div><!-- /.inner -->
  </div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')

<article>
  <section>
    <div id="team">
      <div class="inner">
        <div id="formation">
          <div class="edit_area">
            <div class="title">
              <h2>所属選手一覧</h2>
            </div><!-- /.title -->

            <?php
            $_org_lists = $orgs->lists('name','id')->toArray();
            $org_lists = [0=>'その他'] + $_org_lists;
            $org_lists2 = $_org_lists + [0=>'その他'];
            // dd($orgs);
            ?>

            @if(isset($players) && count($players)>0)
              {!!Form::open( ['method'=>'post', 'url'=>route('team.formation.update'), 'class'=>'form-inline'] )!!}
                <div class="btn_save">
                  <span>変更を保存する</span>
                  <span><input class="btn btn-primary" type="submit" value="保存"></span>
                </div><!-- /.btn -->

                <table>
                  <tr>
                    <th>学年</th>
                    <th>選手名</th>
                    <th>配属</th>
                  </tr>
                  @foreach($players as $i=>$player)
                  <tr class="pointer">
                    <td>{{array_get(config('app.schoolYearAry'),$player->school_year)}}</td>
                    <td>
                      {{$player->name}} @if($player->is_block)<i class="fa fa-ban" style="font-size:18px;color:red"></i>@endif @if($player->suspension_at)<div class="btn btn-xs btn-danger">出場停止中</div>@endif<br>
                    </td>
                    <td>
                      {{-- @if(!$player->is_block) --}}
                      {!!Form::select('teams['.$player->id.']',$org_lists,$player->team_id)!!}
                      {{-- @endif --}}
                    </td>
                  </tr>
                  @endforeach
                </table>
              {!!Form::close()!!}
            @else
              <div class="well">
              登録された選手がいません
              </div>
            @endif

          </div><!-- /.edit_area -->

          <div class="list_area">
            <div class="title">
              <h2>チーム別</h2>
            </div><!-- /.title -->

            <div class="btn_sc">
              <ul>
                @foreach($org_lists2 as $id => $name)
                <li><a href="#team{{$id}}">{{$name}}</a></li>
                @endforeach
              </ul>
            </div><!-- /.btn_sc -->

            <div class="list_group">
              @foreach($org_lists2 as $id => $name)
              <div id="team{{$id}}" class="col">
                <h3>{{$name}}チーム 所属選手</h3>
                <ul>
                  <?php
                  $_players = \App\Players::where('organizations_id',$team->organizations_id)->where('team_id',$id)->where('school_year','<',2000)->orderBy('is_block','desc')->orderBy('school_year','desc')->get();
                  ?>
                  @foreach($_players as $p)
                  <li>{{$p->name}}</li>
                  @endforeach
                </ul>
              </div>
              @endforeach
            </div><!-- /.list_group -->
          </div><!-- /.list_area -->

        </div>

      </div><!-- /.inner -->
    </div>
  </section>
</article>
@endsection
