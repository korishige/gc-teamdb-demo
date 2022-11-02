					<div class="sbox">
						<h4><a href="{{route('front.league.order',['league_id'=>$league->id])}}">{{$league->name}}</a></h4>
						<div class="ibox">

						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<tr class="title">
								<td width="8%"><div align="center"></div></td>
								<td width="73%">クラブ</td>
								<td width="10%"><div align="center">試合</div></td>
								<td width="9%"><div align="center">勝点</div></td>
							</tr>
							@foreach($resultObj[$league->id] as $i=>$result)
							@if($i<5)
							<tr class="rank_{{$result->rank}}">
							  <td><div align="center">{{$result->rank}}</div></td>
							  <td>{{$result->name}}</td>
							  <td><div align="center">{{$result->match_cnt}}</div></td>
							  <td><div align="center">{{$result->win_pt}}</div></td>
							</tr>
							@endif
							@endforeach
						</table>
						
						</div>
						<div class="nav_box">
						<a href="{{route('front.league.order',['league_id'=>$league->id])}}"><img src="/img/common/icon_detail_arrow.png">全順位</a>
						<a href="{{route('front.league.table',['league_id'=>$league->id])}}"><img src="/img/common/icon_detail_arrow.png">戦績表</a>
						<a href="{{route('front.league.match',['league_id'=>$league->id])}}"><img src="/img/common/icon_detail_arrow.png">試合</a>
						</div>
						<div class="day_box">
							@if(strtotime($league->matches()->max('updated_at')))
							{{date('Y年m月d日 H:i',strtotime($league->matches()->max('updated_at')))}}
							@else
							{{$league->updated_at}}
							@endif
						</div>
						<div class="genre_box">小学生</div>
					</div>
