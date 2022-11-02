//スマホスライドメニュー
//$(function(){
//    $("header .sp_nav").on("click", function(){
//        $('header .snav').slideToggle();
//    });
//});

//検索窓
$(function(){
    $("header .snav .search span").on("click", function(){
        $('header .snav .search .box').slideToggle();
    });
});

//ページトップナビ
$(function(){
	//ページトップへのスクロール
	$('.pagetop').click(function () {
		//id名#pagetopがクリックされたら、以下の処理を実行
		$("html,body").animate({scrollTop:0},"300");
	});
	//ページトップの出現
    $('.pagetop').hide();
    $(window).scroll(function () {
        if($(window).scrollTop() > 0) {
            $('.pagetop').fadeIn("slow");
        } else {
            $('.pagetop').fadeOut("slow");
        }
    });
});