<?php include("header_content.php"); ?>

	<div id="content">
		<div class="inner clearfix">
			<main>
			
				<h2 class="bar">
				新規リーグ作成
				</h2>
		
			<div id="title_box" class="clearfix">
			
				<h3 class="comment">2016筑後支部U-12　トップ10リーグリーグ<br>
				FCワールド 2-1大和　の試合へのコメント</h3>
	
				<div id="nav_box" class="comment">
					<div id="nav_create"><a href="order.php">詳細へ戻る</a></div>
				</div>
				
			</div>
			<!-- /.title box -->

 		<div class="league_input">
			<form method="POST" action="http://www.junior-soccer.jp/kyushu/fukuoka/comment/store" accept-charset="UTF-8" class="form-horizontal form-label-left" enctype="multipart/form-data"><input name="_token" type="hidden" value="Z4F3WbEPxoFRBcFzxrrFnxK5BKi1Anxpqog1ltzl">
				<input name="leagues_id" type="hidden" value="23">
				<input name="match_id" type="hidden" value="1310">

				<div class="form-group">
					<label class="league_label">試合への<br>コメント</label>
					<div class="input_area">
						<textarea class="form-control" rows="10" name="comment" cols="50"></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">試合の画像をアップする</label>
					<div class="input_area">
						<input class="form-control" name="img" type="file">
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">動画のURLを記入する（youtubeなど）</label>
					<div class="input_area">
						<input class="form-control" placeholder="動画URL" name="mov" type="text">
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">ニックネーム</label>
					<div class="input_area">
						<input placeholder="ニックネームを入力" class="form-control" name="nickname" type="text">
					</div>
				</div>

				<div class="form-group">
					<label class="league_label">パスワード</label>
					<div class="input_area">
						<input class="form-control" name="pass" type="text" value="9817">
				</div>
				</div>

				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="submit_area">
						<button type="submit" class="submit_btn">コメントを投稿する</button>
					</div>
				</div>

			</form>
		</div>
				
			</main>
			
			<aside>
			
				<div class="search_box">
				
					<h2><img src="img/common/search_title.png" alt="リーグ戦情報絞り込み検索"></h2>
					
					<form>
						<dl>
							<dt>ジャンル</dt><dd><select name=""></select></dd>
							<dt>地域選択</dt><dd><select name=""></select></dd>
							<dt>年　齢</dt><dd><select name=""></select></dd>
						</dl>
						<input type="button" value="検　索">
					</form>
				
				</div>
				<!-- /.search box -->
				
				<div class="bnr_box">			
				<img src="img/index/bnr_make.png">
				<img src="img/index/bnr_post.png">
				</div>
			
			</aside>
		</div>
	</div>
	
<?php include("footer.php"); ?>