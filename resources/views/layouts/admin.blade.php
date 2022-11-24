<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@if(isset($title)){{$title}} | @endif{{env('ASPNAME',config('app.aspnameK'))}} ver.{{Config::get('app.version')}}</title>

  <!-- Bootstrap core CSS -->

  <link href="/adm/css/bootstrap.min.css" rel="stylesheet">

  <link href="/adm/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="/adm/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="/adm/css/custom.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/adm/css/maps/jquery-jvectormap-2.0.1.css" />
  <link href="/adm/css/icheck/flat/green.css" rel="stylesheet">
  <link href="/adm/css/floatexamples.css" rel="stylesheet" />

  <!-- editor -->
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
  <link href="/adm/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="/adm/css/editor/index.css" rel="stylesheet">
  <!-- select2 -->
  <link href="/adm/css/select/select2.min.css" rel="stylesheet">
  <!-- switchery -->
  <link rel="stylesheet" href="/adm/css/switchery/switchery.min.css" />

  <script src="/adm/js/jquery.min.js"></script>

  <!--[if lt IE 9]>
      <script src="../assets/js/ie8-responsive-file-warning.js"></script>
      <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  @yield('css')
</head>


<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{{route('admin.top')}}" class="site_title"><i class="fa fa-futbol-o" style="border:none"></i> <span>{{Config::get('app.aspver')}}</span></a>
          </div>
          <div class="clearfix"></div>
          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="{{route('admin.top')}}"><i class="fa fa-home"></i> Home </a> </li>
                {{--<li><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i>ユーザ管理</a></li>--}}
                <li><a href="{{route('admin.league.index')}}"><i class="fa fa-calendar"></i>大会情報/日程</a></li>
                <li><a href="{{route('admin.result.index')}}"><i class="fa fa-database"></i>試合結果記事</a></li>
                <li><a href="{{route('admin.news.index')}}"><i class="fa fa-bell"></i>内部向けお知らせ</a></li>
                <li><a href="{{route('admin.news2.index')}}"><i class="fa fa-comment"></i>外部向けお知らせ</a></li>
                <li><a href="{{route('admin.organization.index')}}"><i class="fa fa-building"></i> 組織管理</a></li>
                <li><a href="{{route('admin.team.index')}}"><i class="fa fa-user"></i> チーム・選手</a></li>
                <li><a href="{{route('admin.warning.index')}}"><i class="fa fa-shield"></i> 警告者</a></li>
                <li><a href="{{route('admin.venue.index')}}"><i class="fa fa-building-o"></i> 会場</a></li>
                <li><a href="{{route('admin.option.index')}}"><i class="fa fa-cog"></i>大会設定</a></li>
                <li><a href="{{route('admin.template.index')}}"><i class="fa fa-pencil"></i>ページデザイン</a></li>
                {{--
                <li><a href="{{route('admin.config')}}"><i class="fa fa-cog"></i>サイト設定</a></li>
                <li><a href="{{route('admin.vpoint.index')}}"><i class="fa fa-thumbs-up"></i>勝ち点管理</a></li>
                --}}
                <!-- <ul class="nav child_menu" style="display: block;">
                  <li><a href="#">大会概要</a></li>
                  <li><a href="#">協会について</a></li>
                  <li><a href="#">スポンサー募集</a></li>
                  <li><a href="#">グッズ販売</a></li>
                  <li><a href="#">LIVE配信</a></li>
                </ul> -->
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  @if(Session::get('role')=='admin')
                    <span class="btn btn-danger btn-xs">管理者権限</span>
                  @else
                    <span class="btn btn-info btn-xs">一般ユーザ</span>
                  @endif
                  @if(Session::has('email')){{Session::get('email')}}@else名無し@endifさん
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="{{Config::get('app.url')}}" target="_blank">  サイト確認</a> </li>
                  <li><a href="/logout"><i class="fa fa-sign-out pull-right"></i> ログアウト</a> </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main">
        <br />
        @yield('content')

        <!-- footer content -->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <footer>
                <p class="pull-right">{{Config::get('app.copy')}} All Rights Reserved.</p>
                <div class="clearfix"></div>
              </footer>
            </div>
          </div>
        </div>
        <!-- /footer content -->
      </div>
      <!-- /page content -->
    </div>
    <!-- /main container -->
  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="/adm/js/bootstrap.min.js"></script>
  <script src="/adm/js/nicescroll/jquery.nicescroll.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="/adm/js/progressbar/bootstrap-progressbar.min.js"></script>
  <!-- icheck -->
  <script src="/adm/js/icheck/icheck.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="/adm/js/moment.min2.js"></script>
  <script type="text/javascript" src="/adm/js/datepicker/daterangepicker.js"></script>
  <!-- sparkline -->
  <script src="/adm/js/sparkline/jquery.sparkline.min.js"></script>

  <!-- tags -->
  <script src="/adm/js/tags/jquery.tagsinput.min.js"></script>

  <script src="/adm/js/custom.js"></script>

  <script>
    $(function(){
      $(".alert-msg").hide(2000);
    });
    $("a.confirm").click(function(e){
      e.preventDefault();
      thisHref  = $(this).attr('href');
      if(confirm('削除して良いですか？')) {
        window.location = thisHref;
      }
    })

  </script>

  <script>
    function change_pref(pref_id){
      $.ajax({
        type:"GET",
        url:"/api/genBranch",
        data:{pref_id}
      }).done(function(d){
        $("#branch_id").html(d);
      }).fail(function(d){
        alert("error");
      })
    }
    $(document).on('change','#pref_id',function(){
      var pref_id = $(this).val();
      change_pref(pref_id);
      $("#branch_id").show();
    })
  </script>

  @yield('js')

</body>

</html>