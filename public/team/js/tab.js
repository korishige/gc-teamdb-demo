//タブ切り替え
$(document).ready(function($){
	$('.tab-btn').click(function(){
		//セレクタ設定
		var thisElm = $(this);
		var thisTabWrap = thisElm.parents('.tab-wrap');
		var thisTabBtn = thisTabWrap.find('.tab-btn');
		var thisTabContents = thisTabWrap.find('.tab-contents');
		//current class
		var currentClass = 'current';
		//js-tab-btn current 切り替え
		thisTabBtn.removeClass(currentClass);
		thisElm.addClass(currentClass);
		//クリックされた tabが何番目か取得
		var thisElmIndex =  thisTabBtn.index(this);
		//js-tab-contents 切り替え
		thisTabContents.removeClass(currentClass);
		thisTabContents.eq(thisElmIndex).addClass(currentClass);
	});
});