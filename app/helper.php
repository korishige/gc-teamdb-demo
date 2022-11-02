<?php
// use DB;

function leagueOrder($league_id)
{
	$league = DB::table('leagues')->where('id', $league_id)->first();
	$vpoint = DB::table('v_point_settings')->where('id', $league->v_point_settings_id)->first();
	//$league->is_closed
	if (0) {
	} else {
		$resultObj = DB::select('select
(
select count(*)+1 from (
	select team_id
		,coalesce(sum((home_pt>away_pt)*' . $vpoint->win . ' +(home_pt=away_pt)*' . $vpoint->draw . '+(home_pt<away_pt)*' . $vpoint->lose . '+(home_pt = away_pt and coalesce(home_pk,0) > coalesce(away_pk,0))*' . $vpoint->pk_win . ' + (home_pt=away_pt and coalesce(home_pk,0)<coalesce(away_pk,0))*' . $vpoint->pk_lose . '),0) as 勝ち点
		,coalesce(sum(home_pt) - sum(away_pt),0) as 得失点差
		,coalesce(sum(home_pt),0) as 得点
	from (
		select home_id as team_id,home_pt,away_pt,home_pk,away_pk from matches where leagues_id=' . $league_id . ' and is_filled=1
		union all select away_id as team,away_pt,home_pt,away_pk,home_pk from matches where leagues_id=' . $league_id . ' and is_filled=1
	) as sub1 group by team_id order by 勝ち点 desc, 得失点差 desc, 得点 desc
) as sub2
where 
	勝ち点>(@a:=coalesce(sum((home_pt>away_pt)*' . $vpoint->win . ' +(home_pt=away_pt)*' . $vpoint->draw . '+(home_pt<away_pt)*' . $vpoint->lose . '+(home_pt = away_pt and coalesce(home_pk,0) > coalesce(away_pk,0))*' . $vpoint->pk_win . ' + (home_pt=away_pt and coalesce(home_pk,0)<coalesce(away_pk,0))*' . $vpoint->pk_lose . '),0))
	or ( 勝ち点=@a and 得失点差>@b:=coalesce((sum(home_pt) - sum(away_pt)),0))
	or ( 勝ち点=@a and 得失点差=@b and 得点>coalesce(sum(home_pt),0))
) as rank
,name
,league_teams.team_id
,league_teams.leagues_id
,coalesce(sum((home_pt>away_pt)*' . $vpoint->win . ' +(home_pt=away_pt)*' . $vpoint->draw . '+(home_pt<away_pt)*' . $vpoint->lose . '+(home_pt = away_pt and coalesce(home_pk,0) > coalesce(away_pk,0))*' . $vpoint->pk_win . ' + (home_pt=away_pt and coalesce(home_pk,0)<coalesce(away_pk,0))*' . $vpoint->pk_lose . '),0) as win_pt
,coalesce(count(sub.team_id),0) as match_cnt
,coalesce(sum(home_pt>away_pt),0) as win_cnt
,coalesce(sum(home_pt=away_pt),0) as draw_cnt
,coalesce(sum(home_pt<away_pt),0) as lose_cnt
,coalesce(sum(home_pk>away_pk),0) as pk_win_cnt
,coalesce(sum(home_pk<away_pk),0) as pk_lose_cnt
,coalesce(sum(home_pt),0) as get_pt
,coalesce(sum(away_pt),0) as lose_pt
,coalesce(sum(home_pt) - sum(away_pt),0) as get_lose
from (
	select home_id as team_id,home_pt,away_pt,home_pk,away_pk from matches where leagues_id=' . $league_id . ' and is_filled=1
	union all select away_id as team,away_pt,home_pt,away_pk,home_pk from matches where leagues_id=' . $league_id . ' and is_filled=1
) as sub
right join league_teams on sub.team_id=league_teams.team_id
where league_teams.leagues_id = ' . $league_id . '
group by league_teams.team_id
order by rank;
');
	}

	//   if(1){
	//   $resultObj = DB::select('select
	// (select count(*)+1
	// from (
	// select team_id
	// ,sum((home_pt>away_pt)*'.$vpoint->win.' +(home_pt=away_pt)*'.$vpoint->draw.'+(home_pt<away_pt)*'.$vpoint->lose.'+(home_pt = away_pt and coalesce(home_pk,0) > coalesce(away_pk,0))*'.$vpoint->pk_win.' + (home_pt=away_pt and coalesce(home_pk,0)<coalesce(away_pk,0))*'.$vpoint->pk_lose.') as 勝ち点
	// ,sum(home_pt) - sum(away_pt) as 得失点差
	// ,sum(home_pt) as 得点
	// from (
	// select home_id as team_id,home_pt,away_pt,home_pk,away_pk from matches where leagues_id='.$league_id.' and is_filled=1
	// union all select away_id as team,away_pt,home_pt,away_pk,home_pk from matches where leagues_id='.$league_id.' and is_filled=1
	// ) as sub1
	// group by team_id
	// ) as sub2
	// where 
	// 勝ち点>(@a:=coalesce(sum((home_pt>away_pt)*'.$vpoint->win.' +(home_pt=away_pt)*'.$vpoint->draw.'+(home_pt<away_pt)*'.$vpoint->lose.'+(home_pt = away_pt and coalesce(home_pk,0) > coalesce(away_pk,0))*'.$vpoint->pk_win.' + (home_pt=away_pt and coalesce(home_pk,0)<coalesce(away_pk,0))*'.$vpoint->pk_lose.'),0))
	// or ( 勝ち点=@a and 得失点差>@b:=coalesce((sum(home_pt) - sum(away_pt)),0))
	// or ( 勝ち点=@a and 得失点差=@b and 得点>coalesce(sum(home_pt),0))
	// ) as rank
	// ,name
	// ,league_teams.team_id
	// ,league_teams.leagues_id
	// ,coalesce(sum((home_pt>away_pt)*'.$vpoint->win.' +(home_pt=away_pt)*'.$vpoint->draw.'+(home_pt<away_pt)*'.$vpoint->lose.'+(home_pt = away_pt and coalesce(home_pk,0) > coalesce(away_pk,0))*'.$vpoint->pk_win.' + (home_pt=away_pt and coalesce(home_pk,0)<coalesce(away_pk,0))*'.$vpoint->pk_lose.'),0) as win_pt
	// ,coalesce(count(sub.team_id),0) as match_cnt
	// ,coalesce(sum(home_pt>away_pt),0) as win_cnt
	// ,coalesce(sum(home_pt=away_pt),0) as draw_cnt
	// ,coalesce(sum(home_pt<away_pt),0) as lose_cnt
	// ,coalesce(sum(home_pt),0) as get_pt
	// ,coalesce(sum(away_pt),0) as lose_pt
	// ,coalesce(sum(home_pt) - sum(away_pt),0) as get_lose
	// from (
	// select home_id as team_id,home_pt,away_pt,home_pk,away_pk from matches where leagues_id='.$league_id.' and is_filled=1
	// union all select away_id as team,away_pt,home_pt,away_pk,home_pk from matches where leagues_id='.$league_id.' and is_filled=1
	// ) as sub
	// right join league_teams on sub.team_id=league_teams.team_id
	// where league_teams.leagues_id = '.$league_id.'
	// group by league_teams.team_id
	// order by '.$vpoint->sort.';
	// ');  

	//   }else{
	//   $resultObj = DB::select('select
	// (select count(*)+1
	// from (
	// select team_id
	// ,sum((home_pt>away_pt)*3 +(home_pt=away_pt)) as 勝ち点
	// ,sum(home_pt) - sum(away_pt) as 得失点差
	// ,sum(home_pt) as 得点
	// from (
	// select home_id as team_id,home_pt,away_pt from matches where leagues_id='.$league_id.'
	// union all select away_id as team,away_pt,home_pt from matches where leagues_id='.$league_id.'
	// ) as sub1
	// group by team_id
	// ) as sub2
	// where 
	// 勝ち点>(@a:=coalesce(sum((home_pt>away_pt)*3 +(home_pt=away_pt)),0))
	// or ( 勝ち点=@a and 得失点差>@b:=coalesce((sum(home_pt) - sum(away_pt)),0))
	// or ( 勝ち点=@a and 得失点差=@b and 得点>coalesce(sum(home_pt),0))
	// ) as rank
	// ,name
	// ,league_teams.id
	// ,league_teams.leagues_id
	// ,coalesce(sum((home_pt>away_pt)*3 +(home_pt=away_pt)),0) as win_pt
	// ,coalesce(count(sub.team_id),0) as match_cnt
	// ,coalesce(sum(home_pt>away_pt),0) as win_cnt
	// ,coalesce(sum(home_pt=away_pt),0) as draw_cnt
	// ,coalesce(sum(home_pt<away_pt),0) as lose_cnt
	// ,coalesce(sum(home_pt),0) as get_pt
	// ,coalesce(sum(away_pt),0) as lose_pt
	// ,coalesce(sum(home_pt) - sum(away_pt),0) as get_lose
	// from (
	// select home_id as team_id,home_pt,away_pt from matches where leagues_id='.$league_id.'
	// union all select away_id as team,away_pt,home_pt from matches where leagues_id='.$league_id.'
	// ) as sub
	// right join league_teams on sub.team_id=league_teams.id
	// where league_teams.leagues_id = '.$league_id.'
	// group by league_teams.id
	// order by win_pt desc,get_lose desc,get_pt desc,league_teams.id asc;
	// ');  
	//   }
	return $resultObj;
}

function sortByKey($key_name, $sort_order, $array)
{
	foreach ($array as $key => $value) {
		$standard_key_array[$key] = $value->$key_name;
	}

	array_multisort($standard_key_array, $sort_order, $array);

	return $array;
}

function upfileDelete($upfile)
{
	$upDir = config('app.upDir', public_path() . "/upload");
	$writeDir = array('original', 100, 300, '100_crop', '300_crop');
	foreach ($writeDir as $v) {
		$folder = $upDir . '/' . $v;
		unlink($folder . "/" . $upfile);
	}
}

function upmovieDelete($upfile)
{
	$upDir = config('app.upDir', public_path() . "/upload");
	$writeDir = array('movie');
	foreach ($writeDir as $v) {
		$folder = $upDir . '/' . $v;
		unlink($folder . "/" . $upfile);
	}
}

function imageOrientation($filename, $orientation)
{
	//画像ロード
	$image = imagecreatefromjpeg($filename);

	//回転角度
	$degrees = 0;
	switch ($orientation) {
		case 1:		//回転なし（↑）
			return;
		case 8:		//右に90度（→）
			$degrees = 90;
			break;
		case 3:		//180度回転（↓）
			$degrees = 180;
			break;
		case 6:		//右に270度回転（←）
			$degrees = 270;
			break;
		case 2:		//反転　（↑）
			$mode = IMG_FLIP_HORIZONTAL;
			break;
		case 7:		//反転して右90度（→）
			$degrees = 90;
			$mode = IMG_FLIP_HORIZONTAL;
			break;
		case 4:		//反転して180度なんだけど縦反転と同じ（↓）
			$mode = IMG_FLIP_VERTICAL;
			break;
		case 5:		//反転して270度（←）
			$degrees = 270;
			$mode = IMG_FLIP_HORIZONTAL;
			break;
	}
	//反転(2,7,4,5)
	if (isset($mode)) {
		$image = imageflip($image, $mode);
	}
	//回転(8,3,6,7,5)
	if ($degrees > 0) {
		$image = imagerotate($image, $degrees, 0);
	}
	//保存
	ImageJPEG($image, $filename);
	//メモリ解放
	imagedestroy($image);
}

function uploadFile($upfile)
{

	$img = '';

	$upDir = config('app.upDir', public_path() . "/upload");
	$writeDir = array('original', 100, 300, '100_crop', '300_crop');
	if (!file_exists($upDir)) {
		mkdir($upDir, 0777);
		chmod($upDir, 0777);
	}
	if (!is_writable($upDir)) {
		dd(getcwd() . '/' . $upDir . ' に書き込み権限がありません');
	}
	foreach ($writeDir as $v) {
		if (!file_exists($upDir . '/' . $v)) {
			mkdir($upDir . '/' . $v, 0777);
			chmod($upDir . '/' . $v, 0777);
		}
	}

	if (isset($upfile)) {
		$key = str_random(30);
		//$key = md5(sha1(uniqid(mt_rand(), true)));
		$name = $key . '.' . $upfile->getClientOriginalExtension();
		$upload = $upfile->move($upDir . '/original', $name);

		$file_path = $upDir . '/original/' . $name;
		try {
			// EXIFデータに不備がある画像があるため、この場合は、処理しないように。
			$exif_data = exif_read_data($file_path);
			if (isset($exif_data['Orientation'])) {
				imageOrientation($file_path, $exif_data['Orientation']);
			}
		} catch (Exception $e) {;
		}

		// 画像かどうかのチェック
		$w = Image::make($upDir . '/original/' . $name)->width();
		$h = Image::make($upDir . '/original/' . $name)->height();
		foreach ($writeDir as $dir) {
			if ($dir == 'original') {;
			} elseif (preg_match('/(\d+?)_crop/', $dir, $match)) {
				Image::make($upDir . '/original/' . $name)->fit($match[1])->save($upDir . "/$dir/" . $name);
			} else {
				if ($w > $h) {
					Image::make($upDir . '/original/' . $name)->resize($dir, null, function ($constraint) {
						$constraint->aspectRatio();
					})->save($upDir . "/$dir/" . $name);
				} else {
					Image::make($upDir . '/original/' . $name)->resize(null, $dir, function ($constraint) {
						$constraint->aspectRatio();
					})->save($upDir . "/$dir/" . $name);
				}
			}
		}
		$img = $name;
		return ['id' => $key, 'name_file' => $name, 'title' => $upfile->getClientOriginalName()];
	}
}

function uploadMovie($upfile)
{

	$img = '';

	$upDir = config('app.upDir', public_path() . "/upload");
	$writeDir = array('original', 100, 300, '100_crop', '300_crop');
	if (!file_exists($upDir)) {
		mkdir($upDir, 0777);
		chmod($upDir, 0777);
	}
	if (!is_writable($upDir)) {
		dd(getcwd() . '/' . $upDir . ' に書き込み権限がありません');
	}
	foreach ($writeDir as $v) {
		if (!file_exists($upDir . '/' . $v)) {
			mkdir($upDir . '/' . $v, 0777);
			chmod($upDir . '/' . $v, 0777);
		}
	}

	if (isset($upfile)) {
		$key = str_random(30);
		//$key = md5(sha1(uniqid(mt_rand(), true)));
		$name = $key . '.' . $upfile->getClientOriginalExtension();
		$upload = $upfile->move($upDir . '/movie', $name);

		$file_path = $upDir . '/movie/' . $name;
		$img = $name;

		return ['id' => $key, 'name_file' => $name, 'title' => $upfile->getClientOriginalName()];
	}
}


function isMobile()
{
	if (!isset($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT'] == '')
		return 1;
	$useragents = array(
		'iPhone', // Apple iPhone
		'iPod', // Apple iPod touch
		'iPad', // Apple iPod touch
		'Android', // 1.5+ Android
		'dream', // Pre 1.5 Android
		'CUPCAKE', // 1.5+ Android
		'blackberry9500', // Storm
		'blackberry9530', // Storm
		'blackberry9520', // Storm v2
		'blackberry9550', // Storm v2
		'blackberry9800', // Torch
		'webOS', // Palm Pre Experimental
		'incognito', // Other iPhone browser
		'webmate' // Other iPhone browser
	);
	$pattern = '/' . implode('|', $useragents) . '/i';
	return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

// key:urlの配列
function multi_curl_get_url($urlList)
{

	$TIMEOUT = 10; //10秒

	$mh = curl_multi_init();

	$headers = array(
		//"HTTP/1.0",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
		"Accept-Encoding:gzip ,deflate",
		"Accept-Language:ja,en-US;q=0.8,en;q=0.6",
		//"Connection:keep-alive",
		"User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36"
	);


	foreach ($urlList as $u) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_REFERER, $u);

		curl_setopt($ch, CURLOPT_URL, $u);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt_array($ch, array(
		//     CURLOPT_URL            => $u,
		//     CURLOPT_RETURNTRANSFER => true,
		//     CURLOPT_TIMEOUT        => $TIMEOUT,
		//     CURLOPT_CONNECTTIMEOUT => $TIMEOUT,
		// ));
		curl_multi_add_handle($mh, $ch);
	}

	do {
		$stat = curl_multi_exec($mh, $running); //multiリクエストスタート
	} while ($stat === CURLM_CALL_MULTI_PERFORM);
	if (!$running || $stat !== CURLM_OK) {
		throw new RuntimeException('リクエストが開始出来なかった。マルチリクエスト内のどれか、URLの設定がおかしいのでは？');
	}

	do switch (curl_multi_select($mh, $TIMEOUT)) { //イベントが発生するまでブロック

		case -1: //selectに失敗。ありうるらしい。 https://bugs.php.net/bug.php?id=61141
			usleep(10); //ちょっと待ってからretry。ここも別の処理を挟んでもよい。
			do {
				$stat = curl_multi_exec($mh, $running);
			} while ($stat === CURLM_CALL_MULTI_PERFORM);
			continue 2;

		case 0:  //タイムアウト -> 必要に応じてエラー処理に入るべきかも。
			continue 2; //ここではcontinueでリトライします。

		default: //どれかが成功 or 失敗した
			do {
				$stat = curl_multi_exec($mh, $running); //ステータスを更新
			} while ($stat === CURLM_CALL_MULTI_PERFORM);

			do if ($raised = curl_multi_info_read($mh, $remains)) {
				//変化のあったcurlハンドラを取得する
				$info = curl_getinfo($raised['handle']);
				//echo "$info[url]: $info[http_code]\n";
				$key = $info['url'];
				$response = curl_multi_getcontent($raised['handle']);

				if ($response === false) {
					//エラー。404などが返ってきている
					echo 'ERROR!!!', PHP_EOL;
				} else {
					//正常にレスポンス取得
					//echo $response, PHP_EOL;
					$ret[$key] = $response;
				}
				curl_multi_remove_handle($mh, $raised['handle']);
				curl_close($raised['handle']);
			} while ($remains);
			//select前に全ての処理が終わっていたりすると
			//複数の結果が入っていることがあるのでループが必要

	} while ($running);
	//echo 'finished', PHP_EOL;
	curl_multi_close($mh);
	return $ret;
}

// 取得順の配列
function multi_curl_get_order($urlList)
{

	$TIMEOUT = 10; //10秒

	$mh = curl_multi_init();

	$headers = array(
		//"HTTP/1.0",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
		"Accept-Encoding:gzip ,deflate",
		"Accept-Language:ja,en-US;q=0.8,en;q=0.6",
		//"Connection:keep-alive",
		"User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36"
	);


	foreach ($urlList as $u) {
		$ch = curl_init();
		// curl_setopt( $ch,CURLOPT_FOLLOWLOCATION,true);
		// curl_setopt( $ch,CURLOPT_MAXREDIRS,10);
		// curl_setopt( $ch,CURLOPT_AUTOREFERER,true);

		curl_setopt($ch, CURLOPT_URL, $u);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt_array($ch, array(
		//     CURLOPT_URL            => $u,
		//     CURLOPT_RETURNTRANSFER => true,
		//     CURLOPT_TIMEOUT        => $TIMEOUT,
		//     CURLOPT_CONNECTTIMEOUT => $TIMEOUT,
		// ));
		curl_multi_add_handle($mh, $ch);
	}

	do {
		$stat = curl_multi_exec($mh, $running); //multiリクエストスタート
	} while ($stat === CURLM_CALL_MULTI_PERFORM);
	if (!$running || $stat !== CURLM_OK) {
		throw new RuntimeException('リクエストが開始出来なかった。マルチリクエスト内のどれか、URLの設定がおかしいのでは？');
	}

	do switch (curl_multi_select($mh, $TIMEOUT)) { //イベントが発生するまでブロック

		case -1: //selectに失敗。ありうるらしい。 https://bugs.php.net/bug.php?id=61141
			usleep(10); //ちょっと待ってからretry。ここも別の処理を挟んでもよい。
			do {
				$stat = curl_multi_exec($mh, $running);
			} while ($stat === CURLM_CALL_MULTI_PERFORM);
			continue 2;

		case 0:  //タイムアウト -> 必要に応じてエラー処理に入るべきかも。
			continue 2; //ここではcontinueでリトライします。

		default: //どれかが成功 or 失敗した
			do {
				$stat = curl_multi_exec($mh, $running); //ステータスを更新
			} while ($stat === CURLM_CALL_MULTI_PERFORM);

			do if ($raised = curl_multi_info_read($mh, $remains)) {
				//変化のあったcurlハンドラを取得する
				$info = curl_getinfo($raised['handle']);
				//echo "$info[url]: $info[http_code]\n";
				//$key = $info['url'];
				$key = array_search($info['url'], $urlList);
				$response = curl_multi_getcontent($raised['handle']);

				if ($response === false) {
					//エラー。404などが返ってきている
					echo 'ERROR!!!', PHP_EOL;
				} else {
					//正常にレスポンス取得
					//echo $response, PHP_EOL;
					$ret[$key] = $response;
				}
				curl_multi_remove_handle($mh, $raised['handle']);
				curl_close($raised['handle']);
			} while ($remains);
			//select前に全ての処理が終わっていたりすると
			//複数の結果が入っていることがあるのでループが必要

	} while ($running);
	//echo 'finished', PHP_EOL;
	curl_multi_close($mh);
	return $ret;
}


function curl_get_contents($url, $timeout = 10)
{

	$headers = array(
		//"HTTP/1.0",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
		"Accept-Encoding:gzip ,deflate",
		"Accept-Language:ja,en-US;q=0.8,en;q=0.6",
		//"Connection:keep-alive",
		"User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36"
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt( $ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function ImgUrlExtraction($textAry = [])
{
	$pattern = '/(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)\.(jpg|jpeg|gif|png)/i';
	foreach ($textAry as $v) {
		$matches = array();
		preg_match_all($pattern, $v, $matches, PREG_SET_ORDER);
		foreach ($matches as $val) {
			$headers = @get_headers($val[0]);
			if (strpos($headers[0], 'OK'))
				return $val[0];
		}
	}
	return NULL;
}

function multi_curl_get2($urlList)
{

	$TIMEOUT = 10; //10秒

	$mh = curl_multi_init();

	$headers = array(
		//"HTTP/1.0",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
		"Accept-Encoding:gzip ,deflate",
		"Accept-Language:ja,en-US;q=0.8,en;q=0.6",
		//"Connection:keep-alive",
		"User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36"
	);


	foreach ($urlList as $u) {
		$ch = curl_init();
		// curl_setopt( $ch,CURLOPT_FOLLOWLOCATION,true);
		// curl_setopt( $ch,CURLOPT_MAXREDIRS,10);
		// curl_setopt( $ch,CURLOPT_AUTOREFERER,true);

		curl_setopt($ch, CURLOPT_URL, $u);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt_array($ch, array(
		//     CURLOPT_URL            => $u,
		//     CURLOPT_RETURNTRANSFER => true,
		//     CURLOPT_TIMEOUT        => $TIMEOUT,
		//     CURLOPT_CONNECTTIMEOUT => $TIMEOUT,
		// ));
		curl_multi_add_handle($mh, $ch);
	}

	do {
		$stat = curl_multi_exec($mh, $running); //multiリクエストスタート
	} while ($stat === CURLM_CALL_MULTI_PERFORM);
	if (!$running || $stat !== CURLM_OK) {
		throw new RuntimeException('リクエストが開始出来なかった。マルチリクエスト内のどれか、URLの設定がおかしいのでは？');
	}

	do switch (curl_multi_select($mh, $TIMEOUT)) { //イベントが発生するまでブロック

		case -1: //selectに失敗。ありうるらしい。 https://bugs.php.net/bug.php?id=61141
			usleep(10); //ちょっと待ってからretry。ここも別の処理を挟んでもよい。
			do {
				$stat = curl_multi_exec($mh, $running);
			} while ($stat === CURLM_CALL_MULTI_PERFORM);
			continue 2;

		case 0:  //タイムアウト -> 必要に応じてエラー処理に入るべきかも。
			continue 2; //ここではcontinueでリトライします。

		default: //どれかが成功 or 失敗した
			do {
				$stat = curl_multi_exec($mh, $running); //ステータスを更新
			} while ($stat === CURLM_CALL_MULTI_PERFORM);

			do if ($raised = curl_multi_info_read($mh, $remains)) {
				//変化のあったcurlハンドラを取得する
				$info = curl_getinfo($raised['handle']);
				//echo "$info[url]: $info[http_code]\n";
				$key = $info['url'];
				//$key = array_search($info['url'],$urlList);
				$response = curl_multi_getcontent($raised['handle']);

				if ($response === false) {
					//エラー。404などが返ってきている
					echo 'ERROR!!!', PHP_EOL;
				} else {
					//正常にレスポンス取得
					//echo $response, PHP_EOL;
					$ret[$key] = $response;
				}
				curl_multi_remove_handle($mh, $raised['handle']);
				curl_close($raised['handle']);
			} while ($remains);
			//select前に全ての処理が終わっていたりすると
			//複数の結果が入っていることがあるのでループが必要

	} while ($running);
	//echo 'finished', PHP_EOL;
	curl_multi_close($mh);
	return $ret;
}

function multi_curl_get($urlList)
{

	$resList = array(); // 接続情報の一覧

	$headers = array(
		//"HTTP/1.0",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
		"Accept-Encoding:gzip ,deflate",
		"Accept-Language:ja,en-US;q=0.8,en;q=0.6",
		//"Connection:keep-alive",
		"User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36"
	);

	$handle = curl_multi_init();
	$length = count($urlList);
	foreach ($urlList as $url) {
		$res = curl_init($url);

		curl_setopt($res, CURLOPT_HTTPHEADER, $headers);
		// CURLOPT_RETURNTRANSFER=true
		//   ->  curl_multi_getcontent()の返り値で結果を受け取る
		curl_setopt($res, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($res, CURLOPT_HEADER, 0);

		curl_multi_add_handle($handle, $res);

		$resList[] = $res;
	}
	//var_dump($resList);

	$isRunning = null;
	do {
		curl_multi_exec($handle, $isRunning);
		//usleep(100);
	} while ($isRunning);

	$htmlTextList = array();
	foreach ($resList as $key => $res) {
		$htmlTextList[$key] = curl_multi_getcontent($res);
	}

	// リソースの破棄
	foreach ($resList as $res) {
		curl_multi_remove_handle($handle, $res);
		curl_close($res);
	}

	curl_multi_close($handle);

	// 取得結果を返す
	return $htmlTextList;
}
