//ロード時とリサイズ時に画面幅で要素の高さを揃える
$(window).on('load resize',function(){
	var w = $(window).width();
    var x = 640;
    if (w <= x) {
    } else {
        $('.navbox').each(function(i, box) {
			var maxHeight = 0;
			$(box).find('dl').each(function() {
				if ($(this).height() > maxHeight) maxHeight = $(this).height();
			});
			$(box).find('dl').height(maxHeight);
		});
    }
});