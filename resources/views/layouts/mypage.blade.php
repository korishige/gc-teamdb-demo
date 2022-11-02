<!DOCTYPE HTML>
<html>
<head>
	<title>{{$cfg->name}}</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{{$cfg->description}}">
	<meta name="keyword" content="{{$cfg->keywords}}">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.10.4.min.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/adm/fonts/css/font-awesome.min.css">
	<link rel="shortcut icon" href="/img/favicon/favicon.ico">
</head>
<body>

	<header>
	  <div class="navbar navbar-default navbar-fixed-top">
	    <div class="container">
	      <div class="navbar-header">
	        <a href="{{env('URL')}}" class="navbar-brand">{{env('FQDN')}}</a>
	        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
	      </div>
	      <div class="navbar-collapse collapse" id="navbar-main">
	        <ul class="nav navbar-nav">
	          <li><a href="{{config('app.url')}}"></a></li>
	          <li><a href="{{route('front.mypage.index')}}">ダッシュボード</a></li>
	          <li><a href="{{route('front.wanted.create')}}">新規募集</a></li>
	          <li><a href="{{route('front.mypage.edit')}}">プロフィール変更</a></li>
	          {{--
	          <li class="dropdown active">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Demo <span class="caret"></span></a>
	            <ul class="dropdown-menu" role="menu">
	              <li><a href="./bootstrap-ja.html">Japanese Page</a></li>
	              <li><a href="./bootstrap.html">English Page</a></li>
	            </ul>
	          </li>
	          <li><a href="//github.com/NKMR6194/Umi/releases">Download</a></li>
	          <li><a href="//github.com/windyakin/Honoka/wiki">Wiki</a></li>
	          --}}
	        </ul>
					<ul class="nav navbar-nav navbar-right">
	        	<li><a href="{{route('logout')}}">ログアウト</a></li>
	        </ul>
	      </div>
      </div>
	  </div>
	</header>

	<!-- .container -->
	<div class="container" style="margin-top:100px">
		<!-- .content: content(main column + sidebar) -->
		<div class="row content">
			<!-- .main: main column -->
			<div class="col-md-10 col-md-offset-1">
				@yield('contents')
			</div>
			<!-- /.main -->
		</div>
		<!-- /.content -->
	</div>
	<!-- /.container  -->

	<footer>
		<div class="container">
			{{--
			<div class="github-star-button text-center"><iframe src="https://ghbtns.com/github-btn.html?user=NKMR6194&repo=proconist.net&type=star&count=true" frameborder="0" scrolling="0" width="160px" height="20px"></iframe></div>
			--}}
			<div class="copyright text-center">&copy; 2016- グリーンカード株式会社</div>
		</div>
	</footer>

	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>

  <script>
    $(function(){
      $(".alert-msg").hide(3000);
	    $("a.confirm").click(function(e){
	      e.preventDefault();
	      thisHref  = $(this).attr('href');
	      if(confirm('削除して良いですか？')) {
	        window.location = thisHref;
	      }
	    })
    });
  </script>

  @yield('js')

	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
	<script>
		$(function() {
			$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
			$( ".inputCal" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>

	<script src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
	<script>
	// Twitter
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p='https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
	</script>
</body>
</html>
