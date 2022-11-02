window.onload = function () {
		var $vote_wrap = $('#vote_wrap');
		var $vote_box = $('.vote_box');
	
		var topbar = $("#vote_wrap").offset().top;
		var wrapheight = $("#vote_wrap").height();
		var wrapheight = wrapheight+150;
		var btnheight = $("#vote_wrap>.btn").height();
		var btnheight = btnheight+150;

		$(window).scroll(function () {

		if ($(window).scrollTop() > topbar) {
			$("#vote_wrap").css({"position": "fixed", "top": "0px"});
			if($vote_box.css('display')=='block'){
				$("#vote_wrap + dl").css({"padding-top": wrapheight});
			}else{
				$("#vote_wrap + dl").css({"padding-top": btnheight});
			}
		} else {
			$("#vote_wrap").css("position", "static");
			if($vote_box.css('display')=='block'){
				$("#vote_wrap + dl").css({"padding-top": "0px"});
			}else{
				$("#vote_wrap + dl").css({"padding-top": "0px"});
			}
		}
	});
}
$(function() {
	var $vote_wrap = $('#vote_wrap');
	var topbarheight = $("#vote_wrap").height();
	var topbarheight = topbarheight+150;
	$('#vote_wrap > .btn').click(function(){
		$('.vote_box').slideToggle(500);
		if($vote_wrap.css('height')<'10px'){
			$("#vote_wrap + dl").css({"padding-top": "0px"});
		}else{
			$("#vote_wrap + dl").css({"padding-top": "0px"});
		}

	})
});