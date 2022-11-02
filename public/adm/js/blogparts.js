$(function(){
  function onSetup(e){
    var n = $(".num").val();
    var d = $(".design:checked").val();
    var s = $(".size").val();
    $(".blogparts-output").html("&lt;div id=\"manb_parts\" class=\"manb_parts\"></div>\n&lt;script src=\"http://fatego-an.com/blogparts?design="+d+"&num="+n+"&size="+s+"\">&lt;/script>");
    $("#blogparts").html("<div id=\"manb_parts\" class=\"manb_parts\"></div>\n<script src=\"http://fatego-an.com/blogparts?design="+d+"&num="+n+"&size="+s+"\"></script>");
  };
  $(document).on('change','.num,.size,.design',function(){
    onSetup();
  });
  onSetup();
});
