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

<link href="//fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">

<title>{{$page_title}}</title>

<link href="/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<link href="/css/style.css" rel="stylesheet" type="text/css" />
@yield('css')

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/common.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162177859-20"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162177859-20');
</script>


</head>

<body>
<!-- #wrap -->
<div id="wrap">

    <header>
        <div class="inner row">
            <div class="logo">
                <a href="{{route('front.index')}}">
                    <h1>
                        <span>
                            {{-- <img src="/img/common/logo.png"> --}}
                        </span>
                        <span>Blue Wave League {{config('app.nendo')}} ～熱冬～ 公式サイト</span>
                    </h1>
                </a>
            </div>
            <div class="snav">
                <ul>
                    <li><a href="{{route('front.contact')}}">お問合せ</a></li>
                    <li><a href="{{route('login')}}">ログイン</a></li>
                </ul>
                {{--
                <div class="search">
                    <span></span>
                    <div class="box">
                        <form action="#">
                            <input type="text">
                            <input type="submit" value="検索">
                        </form>
                    </div><!-- /.box -->
                </div><!-- /.search -->
                --}}
            </div><!--/.menu-->
        </div>
        <div class="sp_nav"></div>
    </header>

    <nav>
        <div class="search">
            <div class="box">
                <form action="search.html">
                    <input type="text">
                    <input type="btn" value="検索">
                </form>
            </div><!-- /.box -->
        </div><!-- /.search_box -->
        <div class="snav">
            <ul>
                <li><a href="{{route('front.contact')}}">お問合せ</a></li>
                <li><a href="{{route('login')}}">ログイン</a></li>
            </ul>
        </div><!-- /.login -->
        <ul>
            <?php
                $nav = [];
                foreach(['top','schedule','order','team','news','result','gallery','about'] as $k){
                    if($k==$nav_on){
                        $nav[$k] = ' class=on';
                    }else{
                        $nav[$k] = '';
                    }
                }
		        $hgroup = App\Groups::where('convention', config('app.convention'))->first();
            ?>
            <li><a href="{{route('front.index')}}" {{$nav["top"]}}>TOP</a></li>
            <li><a href="{{route('front.schedule.index')}}" {{$nav["schedule"]}}>日　程</a></li>
            <li><a href="{{route('front.order.index',['group_id'=>$hgroup->id])}}" {{$nav["order"]}}>順　位</a></li>
            <li><a href="{{route('front.team.index')}}" {{$nav["team"]}}>参加チーム</a></li>
            <li><a href="{{route('front.news.index')}}" {{$nav["news"]}}>お知らせ</a></li>
            <li><a href="{{route('front.result.index')}}" {{$nav["result"]}}>結果速報</a></li>
            <li><a href="{{route('front.gallery.index')}}" {{$nav["gallery"]}}>ギャラリー</a></li>
            <li><a href="{{route('front.about')}}" {{$nav["about"]}}>関連情報</a></li>
        </ul>
    </nav>

    <div class="overlay"></div>
