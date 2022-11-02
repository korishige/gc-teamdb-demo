//同一ページ内で＃リンクを入れる場合

$(function(){
  $('a[href^="#"]').click(function(){
    var speed = 500;
    var mt = 30;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top - mt;
    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });
});

//動作要確認　別ページへリンクしてアンカーリンクを入れる場合
$(function(){
   // #で始まるアンカーをクリックした場合に処理
   $('a[href^=#]').click(function() {
      // 余白
      var num = 100;
      // スクロールの速度
      var speed = 400; // ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "#" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top - num;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});