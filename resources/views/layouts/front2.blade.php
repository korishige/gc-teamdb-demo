<!DOCTYPE HTML>
<html>
<head>
  <title>{{$cfg->name}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <meta name="description" content="{{$cfg->description}}">
  <meta name="keyword" content="{{$cfg->keyword}}">
  <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
  <!-- OGP Settings -->
  <meta property="og:title" content="{{$cfg->name}}">
  <meta property="og:type" content="website">
  <meta property="og:description" content="{{$cfg->description}}">
  <meta property="og:url" content="{{$cfg->url}}">
  <meta property="og:image" content="{{$cfg->url}}img/ogp.png">
  <meta property="og:site_name" content="{{$cfg->name}}">
  <meta property="og:email" content="{{$cfg->contactEmail}}">
  <meta name="twitter:card" content="summary_large_image">

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

    @yield('contents')

  </div>
  <!-- End Page Wrap -->


  <!-- Foter -->
  <footer class="page-section bg-gray-lighter footer pb-60">
    <div class="container">
      <!-- Footer Logo -->
      <div class="local-scroll mb-30 wow fadeInUp" data-wow-duration="1.5s"> <a href="#top"><img src="/images/basic/logo-bottom.png" width="78" height="36" alt="" /></a> </div>
      <!-- End Footer Logo -->
      <!-- Social Links -->
      <div class="footer-social-links mb-110 mb-xs-60"> <a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a> <a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a> <a href="#" title="Behance" target="_blank"><i class="fa fa-behance"></i></a> <a href="#" title="LinkedIn+" target="_blank"><i class="fa fa-linkedin"></i></a> <a href="#" title="Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a> </div>
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
