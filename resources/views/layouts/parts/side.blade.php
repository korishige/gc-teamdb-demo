				<div class="search_box">
					<h2><img src="/img/common/search_title.png" alt="リーグ戦情報絞り込み検索"></h2>
					{!!Form::open(['url'=>route('front.league.index')])!!}
						<dl>
							<dt>ジャンル</dt><dd>{!!Form::select('sports',App\Sports::lists('name','slug'),null)!!}</dd>
							<dt>地域選択</dt><dd>{!!Form::select('pref',$G['pref'],null)!!}</dd>
							<dt>年　齢</dt><dd>{!!Form::select('age',config('app.ageAry'),null)!!}</dd>
						</dl>
						<input type="button" value="検　索">
					{!!Form::close()!!}
				
				</div>
				<!-- /.search box -->
				
				<div class="bnr_box">			
					<a href="{{route('front.league.create')}}"><img src="/img/index/bnr_make.png"></a>
					<a href="{{route('front.league.index')}}"><img src="/img/index/bnr_post.png"></a>
				</div>
