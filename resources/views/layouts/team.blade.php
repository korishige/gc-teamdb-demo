<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="ja"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="ja"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="ja"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ja"><!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="">

<link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Teko:wght@300;400;500&display=swap" rel="stylesheet">
<link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<title>@if(isset($title)){{$title}} | @endif{{env('ASPNAME',config('app.aspnameK'))}} ver.{{Config::get('app.version')}}</title>

@yield('css')
<style>
  .stamen{
      border: 1px solid #0051ff;
      color: #0051ff !important;
      display: inline-block;
      background: #e8eff4;
      margin: 0 0 0 auto;
      margin-top: 0.5em;
      padding: 10px 10px;
      border-radius: 3px;
      font-size: 0.8em;
      line-height: 0.8em;
      text-decoration: none;
  }

  @media screen and (max-width: 768px){
      .stamen{
          border: 1px solid #0051ff;
          color: #0051ff !important;
          display: block;
          background: #e8eff4;
          margin: 0 0 0 0;
          margin-top: 0.5em;
          padding: 8px 6px;
          border-radius: 3px;
          font-size: 0.5em;
          line-height: 0.8em;
          text-decoration: none;
          width: 50%;
      }
  }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/team/js/common.js"></script>

</head>

<!-- #wrap -->
<div id="wrap">

  <header>
    <div class="inner row">
      <div class="logo">
          LEAGUE MANAGEMENT TOOLS
      </div>
      <div class="snav">
          <ul>
              <li><a href="{{route('logout')}}">ログアウト</a></li>
          </ul>
      </div><!-- /.snav -->
    </div>
    <div class="sp_nav"></div>
  </header>
  
  <div class="site_title">
      <div class="inner">
          {{-- <span><img src="/team/img/common/logo.png"></span> --}}
          <span></span>
          <?php
          // $team = \App\Teams::leftJoin('team_yearly_group', 'team_yearly_group.team_id', '=', 'teams.id')->where('yyyy',config('app.nendo'))->find(session('team_id'));
          $team = \App\Teams::find(session('team_id'));
          $sub_teams = [];
          if(\Session::get('admin')){
            $sub_teams = \App\Teams::lists('name', 'user_id');
            // $sub_teams = \App\Teams::where('organizations_id', $team->organizations_id)->lists('name', 'user_id');
          }
          ?>
          <span>{{$team->name}}　チーム管理ツール</span>
          @if(count($sub_teams) > 1)
            &nbsp;&nbsp;
            {!!Form::open(['url'=>route('login.post'),'method'=>'post','class'=>'row form-inline'])!!}
              {!!Form::hidden('flag',1)!!}
              {!!Form::select('user_id',$sub_teams,\Input::has('user_id')?\Input::get('user_id'):'',['class'=>'form-control','style'=>'width:200px','placeholder'=>'アカウント変更','onchange'=>'submit(this.form)'])!!}
            {!!Form::close()!!}

            &nbsp;&nbsp;
            @if(\Session::get('admin'))
            {!!Form::open(['url'=>route('login.post'),'method'=>'post','class'=>'row form-inline', 'name' => 'form1'])!!}
              {!!Form::hidden('flag',1)!!}
              {!!Form::hidden('user_id',1)!!}
              {{-- <button type="submit" class="stamen"><i class="fa-solid fa-file-pen"></i> 管理者ページへ</button> --}}
              <a href="javascript:form1.submit()" class="stamen"><i class="fa-solid fa-file-pen"></i> 管理者ページへ</a>
            {!!Form::close()!!}
            @endif
          @endif
      </div><!-- /.inner -->
  </div><!-- /.content_title -->
  
  <nav>
    <ul>
      <li><a href="{{route('team.top')}}" class="{{$tab_menu[1] or ''}}">TOP</a></li>
      <li><a href="{{route('team.info.edit')}}" class="{{$tab_menu[2] or ''}}">チーム情報</a></li>
      {{-- <li><a href="{{route('team.formation.index')}}" class="{{$tab_menu[3] or ''}}">チーム編成</a></li> --}}
      <li><a href="{{route('team.player.index')}}" class="{{$tab_menu[4] or ''}}">選手情報</a></li>
      <li><a href="{{route('team.league.index')}}" class="{{$tab_menu[5] or ''}}">リーグ情報</a></li>
      <li><a href="{{route('team.account.edit')}}" class="{{$tab_menu[6] or ''}}">アカウント情報</a></li>
    </ul>
  </nav>
  
  @yield('overlay')

  <div class="overlay"></div>

  <main class="contents">
    @yield('content')  
  </main>

  <footer>
    <div class="inner">
      <div class="logo">LEAGUE MANAGEMENT TOOLS</div>
      <div class="copy">&copy; Copyright ALE all right reserved.</div>
    </div><!-- /.inner -->
  </footer>

</div>
<!-- /#wrap -->

<div class="pagetop"></div>

<script src="/team/js/sp_nav.js"></script>

@yield('js')

</body>
</html>