<?php include("header_content.php"); ?>

	<div id="content">
		<div class="inner clearfix">
			<main>
			
				<h2 class="bar">
				新規リーグ作成
				</h2>
		
			<div id="title_box" class="clearfix">
			
				<h3 class="edit">2016筑後支部U-12　トップ10リーグリーグ<br>
				FCワールド 2-1大和　の試合への試合データ修正</h3>
	
				<div id="nav_box" class="edit">
					<div id="nav_create"><a href="order.php">詳細へ戻る</a></div>
				</div>
				
			</div>
			<!-- /.title box -->

			<div class="league_input">
				<form method="POST" action="http://www.junior-soccer.jp/kyushu/fukuoka/match/update" accept-charset="UTF-8" class="form-horizontal form-label-left"><input name="_token" type="hidden" value="Z4F3WbEPxoFRBcFzxrrFnxK5BKi1Anxpqog1ltzl">
				<input name="id" type="hidden" value="1310">
				<input name="leagues_id" type="hidden" value="23">
				<div class="form-group">
					<label class="league_label">試合結果</label>
					<div class="input_area">
						<select class="form-control" style="width:200px; margin-bottom: 0px;" name="home_id"><option value="153">大川東</option><option value="154">金丸</option><option value="155">太陽</option><option value="156">レジェンド</option><option value="157">筑後</option><option value="158" selected="selected">FCワールド</option><option value="159">大和</option><option value="160">小郡東野</option><option value="161">アザレア</option><option value="162">北野</option></select>
						<input class="form-control han" style="width: 50px; margin-bottom: 0px;" name="home_pt" type="text" value="2"> ―
						<input class="form-control han" style="width: 50px; margin-bottom: 0px;" name="away_pt" type="text" value="1">
						<select class="form-control" style="width:200px; margin-bottom: 0px;" name="away_id"><option value="153">大川東</option><option value="154">金丸</option><option value="155">太陽</option><option value="156">レジェンド</option><option value="157">筑後</option><option value="158">FCワールド</option><option value="159" selected="selected">大和</option><option value="160">小郡東野</option><option value="161">アザレア</option><option value="162">北野</option></select>
						<div class="caution">※ホーム&amp;アウェーの場合は左にホームチームを選んでください。</div>
					</div>
				</div>
			
				<div class="form-group">
					<label class="league_label">試合日</label>
					<div class="input_area">
						<input placeholder="試合日を入力" class="form-control inputCal" name="match_at" type="text" value="0000-00-00">
					</div>
				</div>
			
				<div class="form-group">
					<label class="league_label">試合会場</label>
					<div class="input_area">
						<input placeholder="試合会場を入力" class="form-control" name="place" type="text" value="">
					</div>
				</div>
			
			
				<div class="form-group">
					<label class="league_label">ニックネーム</label>
					<div class="input_area">
						<input placeholder="ニックネームを入力" class="form-control" name="nickname" type="text" value="">
					</div>
				</div>
			
				<div class="form-group">
					<label class="league_label">パスワード</label>
					<div class="input_area">
						<input class="form-control" name="pass" type="text" value="">
					</div>
				</div>
			
				<div class="form-group">
					<div class="submit_area">
						<button type="submit" class="submit_btn">修正する</button>
					</div>
				</div>
			
				</form>
			</div>
			
			<h3 class="rank_comment_title mb10">この試合結果を削除する</h3>
				<form method="POST" action="http://www.junior-soccer.jp/kyushu/fukuoka/match/delete" accept-charset="UTF-8" class="form-horizontal form-label-left"><input name="_token" type="hidden" value="Z4F3WbEPxoFRBcFzxrrFnxK5BKi1Anxpqog1ltzl">
				<input name="id" type="hidden" value="1310">
				<div class="form-group">
					<label class="league_label">パスワード</label>
					<div class="input_area">
						<input class="form-control" name="pass" type="text" value="">
					</div>
				</div>
			
				<div class="form-group">
					<div class="submit_area">
						<button type="submit" class="submit_btn">削除する</button>
					</div>
				</div>
				</form>
				
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