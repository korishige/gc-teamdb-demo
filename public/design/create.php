<?php include("header_content.php"); ?>

	<div id="content">
		<div class="inner clearfix">
			<main>
			
				<h2 class="bar">
				新規リーグ作成
				</h2>
		
			<div id="title_box" class="clearfix">
			
				<h3>新規リーグ作成</h3>
	
				<div id="nav_box">
					<div id="nav_top"><a href="genre.php">TOPへ戻る</a></div>
					<div id="nav_create"><a href="order.php">詳細へ戻る</a></div>
				</div>
				
			</div>
			<!-- /.title box -->

    <div id='errors' style="color:red">
            </div>

    <div class="league_input">
        <form method="POST" action="http://www.junior-soccer.jp/kyushu/fukuoka/league/store" accept-charset="UTF-8" class="form-horizontal form-label-left"><input name="_token" type="hidden" value="Z4F3WbEPxoFRBcFzxrrFnxK5BKi1Anxpqog1ltzl">
        <div class="form-group">
            <label class="league_label">支部</label>
            <div class="input_area">
                <select id="id_branch" class="form-control" name="id_branchs"><option value="*">福岡県全域</option><option value="chikugo">筑後支部</option><option value="chikuhou">筑豊支部</option><option value="chikuzen">筑前支部</option><option value="fukuoka">福岡支部</option><option value="kitakyushu">北九州支部</option><option value="other">その他</option></select>
            </div>
        </div>

        <div class="form-group">
            <label class="league_label">学年</label>
            <div class="input_area">
            <select class="form-control" name="age"><option value="U-15">U-15(中学3年)</option><option value="U-14">U-14(中学2年)</option><option value="U-13">U-13(中学1年)</option><option value="U-12">U-12(小学6年)</option><option value="U-11">U-11(小学5年)</option><option value="U-10">U-10(小学4年)</option><option value="U-9">U-9(小学3年)</option><option value="U-8">U-8(小学2年)</option><option value="U-7">U-7(小学1年)</option><option value="U-6">U-6(園児)</option></select>
            </div>
        </div>

        <div class="form-group">
            <label class="league_label">リーグ戦名称</label>
            <div class="input_area">
            <input class="form-control" placeholder="リーグ戦名称を入力" name="name" type="text">
            </div>
        </div>

        <div class="form-group">
            <label class="league_label">参加チーム</label>
            <div class="input_area">
            <input class="form-control" placeholder="参加チームを入力 「、」 区切り" style="margin-bottom:0" name="team" type="text">
                <div class="caution">※参加チームは チームA、チームB、チームC、チームD のように記載</div>
            </div>
        </div>

        <div class="form-group">
            <label class="league_label">リーグの説明</label>
            <div class="input_area">
            <textarea class="form-control" placeholder="リーグについての説明を記入" name="description" cols="50" rows="10"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="league_label">ニックネーム</label>
            <div class="input_area">
            <input class="form-control" placeholder="ニックネームを入力" name="nickname" type="text">
            </div>
        </div>

        <div class="form-group">
            <label class="league_label">パスワード</label>
            <div class="input_area">
            <input class="form-control" name="pass" type="text" value="1925"><br />※お好きな英数字を設定できます。この情報を編集する際に必要になるので必ず控えておいてください
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="submit_area">
                <button type="submit" class="submit_btn">リーグ戦を作成する</button>
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