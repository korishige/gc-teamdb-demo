$(window).on('load', function() {
  var headerheight = $('header').height();
  var heightplus = 30;
  var headerheight = headerheight + heightplus;
  var url = $(location).attr('href');
  if(url.indexOf("?id=") != -1){
  var id = url.split("?id=");
  var $target = $('#' + id[id.length - 1]);
    if($target.length){
      var pos = $target.offset().top - headerheight;
      $("html, body").animate({scrollTop:pos}, 1000);
    }
  }
});