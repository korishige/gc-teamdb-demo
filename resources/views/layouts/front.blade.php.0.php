<!DOCTYPE HTML>
<html>
<head>
  <title>{{$cfg->name}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <meta name="description" content="{{$cfg->description}}">
  <meta name="keyword" content="{{$cfg->keyword}}">
  <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

  <!-- Favicons -->
  <link rel="shortcut icon" href="/images/favicon.png">
  <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-touch-icon-114x114.png">

  <!-- CSS -->
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/style-responsive.css">
  <link rel="stylesheet" href="/css/animate.min.css">
  <link rel="stylesheet" href="/css/vertical-rhythm.min.css">
  <link rel="stylesheet" href="/css/owl.carousel.css">
  <link rel="stylesheet" href="/css/magnific-popup.css"> 
  <link rel="stylesheet" href="/css/style-sakamachi.css">        

  <!--
  <link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
  -->
</head>
<body class="appear-animate">

  <!-- Page Loader -->        
  <!--
  <div class="page-loader">
    <div class="loader">Loading...</div>
  </div>
  -->
  <!-- End Page Loader -->

  <!-- Page Wrap -->
  <div class="page" id="top">
    <!-- Home Section -->
    <section class="home-section bg-light-alfa-70 parallax-2 fixed-height-small" data-background="/images/basic/soccer_field.jpg" id="home" style="background-image: url(/images/basic/soccer_field.jpg); background-position: 50% -26px;">
      <div class="js-height-parent container" style="height: 500px;">

        <!-- Hero Content -->
        <div class="home-content">
          <div class="home-text">

            <h1 class="hs-line-8 no-transp font-alt mb-50 mb-xs-30">
              対戦相手/試合会場/人員補充の悩みを解決します
            </h1>

            <h2 class="hs-line-11 font-alt mb-50 mb-xs-30">
              ソーレ!コーチの為のマッチングサイト
            </h2>

            <div class="local-scroll mb-40">
              <a href="#ctop" class="btn btn-mod btn-mod-success btn-large btn-round">募集一覧</a>
              <a href="/entry/create#ent_form" class="btn btn-mod btn-mod-warning btn-large btn-round">募集する</a>
            </div>
            <!-- sign up CTA -->
            <div class="local-scroll">
                <a href="/register" class="btn btn-mod btn-border btn-circle btn-large mb-20">無料会員登録して今すぐ対戦相手を募集</a>
            </div>
            <div class="local-scroll">
                <a href="/login" class=" ">会員ログインはこちらから</a>
            </div>
            <!-- End sign up CTA -->
          </div>
        </div>
        <!-- End Hero Content -->

      </div>
    </section>
    <!-- End Home Section --> 

    <!-- Navigation panel -->
    <nav class="main-nav transparent stick-fixed">
      <div class="full-wrapper relative clearfix">
        <!-- Logo ( * your text or image into link tag *) -->
        <div class="nav-logo-wrap local-scroll">
          <a href="/" class="logo">
            <img src="/images/basic/logo-main.png" alt="" />
          </a>
        </div>
        <div class="mobile-nav">
          <i class="fa fa-bars"></i>
        </div>

        <!-- Main Menu -->
        <div class="inner-nav desktop-nav">
          <ul class="clearlist">
            <li> <a href="/" class="mn-has-sub active">Home </a> </li>
            {{--
            <li> <a href="#" class="mn-has-sub">日付から探す </a> </li>
            <li> <a href="#" class="mn-has-sub">場所から探す </a> </li>
            <li> <a href="#" class="mn-has-sub">競技から探す </a> </li>
            --}}
            <li> <a href="/about" class="mn-has-sub">このサイトについて </a> </li>
            <li><a>&nbsp;</a></li>
            <!-- Search -->
            <li>
              <a href="#" class="mn-has-sub"><i class="fa fa-search"></i> Search</a>
              <ul class="mn-sub">
                <li>
                  <div class="mn-wrap">
                    {!!Form::open(['url'=>'/','class'=>'form','method'=>'get'])!!}
                      <div class="search-wrap">
                        <button class="search-button animate" type="submit" title="Start Search">
                          <i class="fa fa-search"></i>
                        </button>
                        <input type="hidden" name="pref" value="*">
                        <input type="text" name="keyword" class="form-control search-field" placeholder="Search...">
                      </div>
                    {!!Form::close()!!} 
                  </div>
                </li>
              </ul>
            </li>
            <!-- End Search -->
          </ul>
        </div>
        <!-- End Main Menu -->
      </div>
    </nav>
    <!-- End Navigation panel -->


    <!-- entry -->
    <section class="page-section" id="about">
      <div class="container relative">
        <!-- Row -->
        <a id="ctop"></a>
        <div class="row">
          <!-- Col -->
          <div class="col-sm-8">
            @if(!Input::has('pref'))
            <h2 class="section-title font-alt mb-40 mb-sm-40">エントリー一覧 </h2>
            <!-- Nav Tabs -->
            <div class="align-center mb-20 mb-xs-20">
              <ul class="nav nav-tabs tpl-minimal-tabs animate">
                <li class="active">
                  <a href="#mini-one" data-toggle="tab" aria-expanded="true">新着</a>
                </li>
                <li class="">
                  <a href="#mini-two" data-toggle="tab" aria-expanded="false">直前情報</a>
                </li>
                <li class="">
                  <a href="#mini-three" data-toggle="tab" aria-expanded="false">カテゴリー</a>
                </li>
                <li class="">
                  <a href="#mini-four" data-toggle="tab" aria-expanded="false">種目</a>
                </li>                                                                  
              </ul>
            </div>
            @endif
            <!-- End Nav Tabs -->

            <!-- Tab panes -->
            @yield('contents')
          </div><!-- End Col -->

          <!-- Sidebar -->
          <div class="col-sm-4 col-md-3 col-md-offset-1 sidebar">
            <!-- Widget 詳細検索 -->
            <div class="widget">
                <h5 class="widget-title font-alt">エントリを検索</h5>
                <div class="widget-body">
                    {!!Form::open(['url'=>route('front.index'),'method'=>'GET'])!!}
                        <div class="mb-40">
                            <div class="mb-20 mb-md-10">
                                {!!Form::text('keyword',Input::has('keyword')?Input::get('keyword'):old('keyword'),['class'=>'form-control input-md','placeholder'=>'キーワードを入力'])!!}<!-- Name -->
                            </div>
                            <div class="mb-20 mb-md-10">
                                {!!Form::select('class',$def['sports'],Input::has('sports')?Input::get('sports'):old('sports'),['class'=>'form-control input-md','placeholder'=>'スポーツを選択'])!!}
                            </div>
                            <div class="mb-20 mb-md-10">
                                {!!Form::select('pref',$def['pref'],Input::has('pref')?Input::get('pref'):old('pref'),['class'=>'form-control input-md'])!!}
                            </div>
                            {{--
                            <div class="mb-20 mb-md-10">
                                {!!Form::text('date',Input::has('date')?Input::get('date'):old('date'),['class'=>'form-control input-md','placeholder'=>'日時を入力'])!!}
                            </div>
                            --}}
                            <div class="mb-20 mb-md-10">
                                <input class="btn btn-info btn-block" type="submit" value="検索">
                            </div>
                        </div>
                    {!!Form::close()!!}
                </div>
            </div>
          </div>
          <!-- End Sidebar -->

        </div> <!-- End Row -->

      </div> <!--\.container-->
    </section><!-- End About Section -->

    <hr class="mt-0 mb-0 "/>
    <hr class="mt-0 mb-0"/>
    <hr class="mt-0 mb-0 "/>
    <hr class="mt-0 mb-0 "/>

    <!-- Newsletter Section -->
    <!--<section class="small-section bg-gray-lighter">
      <div class="container relative">

        <form class="form align-center" id="mailchimp">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">

              <div class="newsletter-label font-alt">
                　ジュニアサッカーの最新情報をソーレ！メルマガで
              </div>

              <div class="mb-20">
                <input placeholder="メールアドレスを入力" class="newsletter-field form-control input-md round mb-xs-10" type="email" pattern=".{5,100}" required/>

                <button type="submit" class="btn btn-mod btn-medium btn-round mb-xs-10">
                  メルマガを登録する
                </button>
              </div>

              <div class="form-tip">
                <i class="fa fa-info-circle"></i>登録解除はこちらから
              </div>

              <div id="subscribe-result"></div>

            </div>
          </div>
        </form>

      </div>
    </section>-->
    <!-- End Newsletter Section -->

  </div>
  <!-- End Page Wrap -->


  <!-- Foter -->
  <footer class="page-section bg-gray-lighter footer pb-60">
    <div class="container">
      <!-- Footer Logo -->
      <div class="local-scroll mb-30 wow fadeInUp" data-wow-duration="1.5s"> <a href="#top"><img src="/images/basic/logo-bottom.png" width="78" height="36" alt="" /></a> </div>
      <!-- End Footer Logo -->
      <!-- Social Links -->
      <div class="footer-social-links mb-110 mb-xs-60">
        <a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
<!--         <a href="#" title="Behance" target="_blank"><i class="fa fa-behance"></i></a>
        <a href="#" title="LinkedIn+" target="_blank"><i class="fa fa-linkedin"></i></a>
        <a href="#" title="Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a>
 -->      </div>
      <!-- End Social Links -->
      <!-- Footer Text -->
      <div class="footer-text">
        <!-- Copyright -->
        <div class="footer-copy font-alt"> <a href="http://themeforest.net/user/theme-guru/portfolio" target="_blank">&copy; Green Card .Inc 2015</a>. </div>
        <!-- End Copyright -->
        <div class="footer-made"> Made with love for every great children. </div>
      </div>
      <!-- End Footer Text -->
    </div>
    <!-- Top Link -->
    <div class="local-scroll"> <a href="#top" class="link-to-top"><i class="fa fa-caret-up"></i></a> </div>
    <!-- End Top Link -->
  </footer>
  <!-- End Foter -->
  <!-- JS -->
  <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="/js/bootstrap.min.js"></script>        
  <script type="text/javascript" src="/js/SmoothScroll.js"></script>
  <script type="text/javascript" src="/js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="/js/jquery.localScroll.min.js"></script>
  <script type="text/javascript" src="/js/jquery.viewport.mini.js"></script>
  <script type="text/javascript" src="/js/jquery.countTo.js"></script>
  <script type="text/javascript" src="/js/jquery.appear.js"></script>
  <script type="text/javascript" src="/js/jquery.sticky.js"></script>
  <script type="text/javascript" src="/js/jquery.parallax-1.1.3.js"></script>
  <script type="text/javascript" src="/js/jquery.fitvids.js"></script>
  <script type="text/javascript" src="/js/owl.carousel.min.js"></script>
  <script type="text/javascript" src="/js/isotope.pkgd.min.js"></script>
  <script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
  <script type="text/javascript" src="/js/jquery.magnific-popup.min.js"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
  <script type="text/javascript" src="/js/gmap3.min.js"></script>
  <script type="text/javascript" src="/js/wow.min.js"></script>
  <script type="text/javascript" src="/js/masonry.pkgd.min.js"></script>
  <script type="text/javascript" src="/js/jquery.simple-text-rotator.min.js"></script>
  <script type="text/javascript" src="/js/all.js"></script>
  <script type="text/javascript" src="/js/contact-form.js"></script>
  <script type="text/javascript" src="/js/jquery.ajaxchimp.min.js"></script>        
  <!--[if lt IE 10]><script type="text/javascript" src="js/placeholder.js"></script><![endif]-->

</body>

</html>
