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

<title>@if(isset($title)){{$title}} | @endif{{env('ASPNAME',config('app.aspnameK'))}} ver.{{Config::get('app.version')}}</title>

@yield('css')

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
    </div>
    <div class="sp_nav"></div>
  </header>
  
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