//固定メニュー(nav/footer)
$(function() {
  var $win = $(window),
      $main = $('main'),
	  $wrap = $('#wrap'),
      $header = $('header'),
	  $nav = $('nav'),
      headerHeight = $header.outerHeight(),
      navPos = $nav.offset().top + headerHeight,
      fixedClass = 'is-fixed';
    $win.on('load scroll', function() {
    var value = $(this).scrollTop();
    if ( value > navPos ) {//スクロール位置がナビより大きかったら
		//var w = $(window).width();
		//var x = 640;
		//if (w >= x) {
		//} else {
			$header.addClass(fixedClass);
            $header.css({'border-bottom':'1px solid #555'});
            $header.css({"box-shadow":"3px 3px 10px #000"});
			$wrap.css({'padding-top':headerHeight});
		//}
    } else {//スクロール位置がナビより小さかったら
		//var w = $(window).width();
		//var x = 640;
		//if (w >= x) {
		//} else {
			$header.removeClass(fixedClass);
            $header.css({'border-bottom':'none'});
            $header.css({"box-shadow":"3px 3px 10px #000"});
			$wrap.css({'padding-top':'0'});
		//}
    }
  });
});