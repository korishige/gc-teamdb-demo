				<h3 class="rank_comment_title mb10">このリーグの試合結果を追加する</h3>
			  <div id='errors'>
			    @include('layouts.parts.message')
			  </div>
			  
				<div class="league_input">
					{!!Form::open(['url'=>route('front.comment.store0'),'class'=>'form-horizontal form-label-left'])!!}
					{!!Form::hidden('leagues_id',$league->id)!!}
					<div class="form-group">
						<label class="league_label">試合結果<br /><span class="required">※必須</span></label>
						<div class="input_area">
							{!!Form::select('home_id',$teamObj,Input::old('home_id'),['class'=>'form-control','style'=>'width:200px; margin-bottom: 0px;'])!!}
							{!!Form::text('home_pt',Input::old('home_pt',0),['class'=>'form-control han','style'=>'width: 50px; margin-bottom: 0px;'])!!} ―
							{!!Form::text('away_pt',Input::old('away_pt',0),['class'=>'form-control han','style'=>'width: 50px; margin-bottom: 0px;'])!!}
							{!!Form::select('away_id',$teamObj,Input::old('away_id'),['class'=>'form-control','style'=>'width:200px; margin-bottom: 0px;'])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">試合日</label>
						<div class="input_area">
							{!!Form::text('match_at',Input::old('match_at'),['placeholder'=>'試合日を入力','class'=>'form-control inputCal'])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">試合会場</label>
						<div class="input_area">
							{!!Form::text('place',Input::old('place'),['placeholder'=>'試合会場を入力','class'=>'form-control'])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">試合への<br>コメント</label>
						<div class="input_area">
							{!!Form::textarea('comment',Input::old('comment'),['class'=>'form-control','rows'=>10])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">試合の画像をアップする</label>
						<div class="input_area">
							{!!Form::file('img',['class'=>'form-control'])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">動画のURLを記入する（youtubeなど）</label>
						<div class="input_area">
							{!!Form::text('mov',Input::old('mov'),['class'=>'form-control','placeholder'=>'動画URL'])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">ニックネーム</label>
						<div class="input_area">
							{!!Form::text('nickname',Input::old('nickname'),['placeholder'=>'ニックネームを入力','class'=>'form-control'])!!}
						</div>
					</div>

					<div class="form-group">
						<label class="league_label">パスワード<br /><span class="required">※必須</span></label>
						<div class="input_area">
							{!!Form::text('pass',Input::old('pass',mt_rand(1000,9999)),['class'=>'form-control2'])!!}<br />※お好きな英数字を設定できます。この情報を編集する際に必要になるので必ず控えておいてください
						</div>
					</div>

					<div class="form-group">
						<div class="submit_area">
							<button type="submit" class="submit_btn">追加</button>
						</div>
					</div>

					{!!Form::close()!!}
				</div>

				<h3 class="rank_comment_title mb10">試合に対するコメント一覧</h3>
			  @foreach($commentObj as $v)
			    @include('layouts.parts.comments')
			  @endforeach

				<div class="navi_nextback">
					{!!$commentObj->appends(Input::except('page'))->render()!!}
					<div class="clear"></div>
				</div>

				<h3 class="rank_comment_title mb10">リーグについて</h3>
				<div class="rank_comment">
					{{nl2br(e($league->description))}}
				</div>

				<h3 class="rank_comment_title mb10">当サイトリーグ表の参加・閲覧にあたっての注意事項</h3>
				<div class="rank_comment">
					<p>
						・リーグ表作成、結果の入力は誰でもご参加いただけます。<br>
						・入力内容に誤りがあった場合など運営事務局の方で変更させていただく場合もございます。<br>
						・皆様からの情報提供を元に結果を掲載しています。公式結果ではありませんので必ず公式結果をご確認ください。<br><br>
						・<span class="btn">ｺﾒﾝﾄ</span>から写真、動画、感想、結果修正依頼などを投稿できます。<br>
					</p>
				</div>