<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="ja"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="ja"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="ja"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ja"><!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{$Gcfg->description}}">
<meta name="keywords" content="{{$Gcfg->keywords}}">
<title>{{$title}}</title>
<link href="/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/css/style.css" rel="stylesheet" type="text/css" />

<link href="/css/genre.css" rel="stylesheet" type="text/css" />
<link href="/css/detail.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="/css/jquery.bxslider.min.css"/>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script>
$(document).ready(function() {
  var pagetop = $('.pagetop');
    $(window).scroll(function () {
       if ($(this).scrollTop() > 100) {
            pagetop.fadeIn();
       } else {
            pagetop.fadeOut();
            }
       });
       pagetop.click(function () {
           $('body, html').animate({ scrollTop: 0 }, 500);
              return false;
   });
});
</script>

</head>

<body>
<!-- #container -->
<div id="container">

	<header>
	
		<div class="inner">
			
		<div class="header_logo">
			<a href="{{route('front.index')}}"><img src="/img/common/logo.png" border="0"></a>
		</div>
		
		<div class="header_nav">
			<div class="nav_create"><a href="{{route('front.league.create')}}">リーグ戦をつくる</a></div>
			<div class="nav_edit"><a href="{{route('front.league.index')}}">リーグ戦に投稿する</a></div>
		</div>
		
		</div>

	</header>

	<div id="content_title">
		<div class="inner"><h1>{{$sports->name or ''}}　リーグ情報</h1></div>
	</div>