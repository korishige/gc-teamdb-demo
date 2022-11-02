  <div class="result_list_box">
    <div class="result_list_box_date">
      <?php
        $time = strtotime($v->updated_at);
      ?>
      {{date('m月d日',$time)}}
      @if($time>strtotime("-1 week"))
      <br><span class="icon_new">NEW</span>
      @endif
    </div>
    <div class="result_list_box_img">
      @if($v->img=='')
      <img src="http://placehold.it/100x?text=no+image">
      @else
      <img src="/uploads/100/{{$v->img}}" width="58">
      @endif
    </div>
    <div class="match_list_box_text">
    <h3>{{$v->match->home->name}}　{{$v->match->home_pt}}-{{$v->match->away_pt}}　{{$v->match->away->name}}</h3>
    <p>{{$v->comment}}</p><p></p></div>
    <div class="result_list_box_icon">
      <span class="icon_item">
      @if($v->img=='')
      <a href="#">画像を見る</a>
      @else
      <a href="/uploads/original/{{$v->img}}" target="_blank">画像を見る</a>
      @endif
      </span><br><br>
      <span class="icon_item">
      @if($v->mov=='')
      <a href="#">動画を見る</a>
      @else
      <a href="{{$v->mov}}" target="_blank">動画を見る</a>
      @endif
      </span><br><br>
      @if(Config::get('app.debug'))
      <span class="icon_item" style="background: #ff9900;">
      <a href="{{route('front.comment.edit',['id'=>$v->id])}}">修正・削除</a></span><br><br>
      @endif
    </div>
    <div class="clear"></div>
  </div>
