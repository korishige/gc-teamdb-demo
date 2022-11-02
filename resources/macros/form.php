<?php

Validator::extend('ascii_alpha', function($attribute, $value, $parameters) {
  return preg_match('/^[a-zA-Z]+$/', $value);
});

Form::macro('cbinline',function($name,$label=null,$values=null,$val,$attributes=[]){
  $html = '';
  foreach($values as $k=>$v){
    $check = ($val==$k)?'checked':'';
    $html .= sprintf("<label class='checkbox-inline'><input type='checkbox' name='%s' id='%s' value='%s'%s>%s</label>",$name,$name.'-'.$k,$k,$check,$v);
  }
  return fieldWrapper($name, $label, $html);
});

Form::macro('cbinline2',function($name,$label=null,$values=null,$val,$attributes=[]){
  $html = '';
  foreach($values as $k=>$v){
    // dd($values);
    $check = ($val==$v)?'checked':'';
    $html .= sprintf("<label class='checkbox-inline'><input type='checkbox' name='%s' id='%s' value='%s'%s>%s</label>",$name,$name.'-'.$k,$k,$check,$v);
  }
  return fieldWrapper($name, $label, $html);
});

Form::macro('rbinline',function($name,$label=null,$values=null,$val,$attributes=[]){
  $html = '';
  foreach($values as $k=>$v){
    $check = ($val==$k)?'checked':'';
    $html .= sprintf("<label class='radio-inline'><input type='radio' name='%s' id='%s' value='%s'%s>%s</label>",$name,$name.'-'.$k,$k,$check,$v);
  }
  return fieldWrapper($name, $label, $html);
});

Form::macro('rb',function($name,$values,$val){
 $markup="";
 foreach($values as $key=>$value){
   $markup.='<div class="radio">'."\n";
   $markup.='<input type="radio"';
   $markup.=' name='.$name;
   $markup.=' value='.$key;
   if($val==$key){
     $markup.=' checked';
   }
   $markup.='> '.$value."\n";
   $markup.='</div>'."\n";
 }
 return $markup;
});

Form::macro('staticField', function($name, $label = null, $value = null, $attributes = [], $suffix='', $prefix='')
{
  $element = '<p class="form-control-static">'.$prefix.' '.$value.' '.$suffix.'</p>';

  return fieldWrapper($name, $label, $element);
});

Form::macro('mailField', function($name, $label = null, $value = null, $attributes = [])
{
  $element = Form::email($name, $value, fieldAttributes($name, $attributes));

  return fieldWrapper($name, $label, $element);
});

Form::macro('textField', function($name, $label = null, $value = null, $attributes = [], $suffix = '')
{
  $element = Form::text($name, $value, fieldAttributes($name, $attributes));

  return fieldWrapper($name, $label, $element, $suffix);
});

Form::macro('textareaField', function($name, $label = null, $value = null, $attributes = [])
{
  $element = Form::textarea($name, $value, fieldAttributes($name, $attributes));

  return fieldWrapper($name, $label, $element);
});

Form::macro('selectField', function($name, $label = null, $options, $value = null, $attributes = [])
{
  $element = Form::select($name, $options, $value, fieldAttributes($name, $attributes));

  return fieldWrapper($name, $label, $element);
});

Form::macro('selectMultipleField', function($name, $label = null, $options, $value = null, $attributes = [])
{
  $attributes = array_merge($attributes, ['multiple' => true]);
  $element = Form::select($name, $options, $value, fieldAttributes($name, $attributes));

  return fieldWrapper($name, $label, $element);
});

Form::macro('checkboxField', function($name, $label = null, $value = 1, $checked = null, $attributes = [])
{
  $attributes = array_merge(['id' => 'id-field-' . $name], $attributes);

  $out = '<div class="checkbox';
  $out .= fieldError($name) . '">';
  $out .= '<label>';
  $out .= Form::checkbox($name, $value, $checked, $attributes) . ' ' . $label;
  $out .= '</div>';

  return $out;
});

function fieldWrapper($name, $label, $element,$suffix=' ')
{
  $out = '<div class="form-group';
  $out .= fieldError($name) . '">';
  $out .= fieldLabel($name, $label);
  $out .= '<div class="col-sm-12 col-xs-12 col-md-10">'.$element.$suffix.'</div>';
  $out .= '</div>';

  return $out;
}

function fieldError($field)
{
  $error = '';

  if ($errors = Session::get('errors'))
  {
    $error = $errors->first($field) ? ' has-error' : '';
  }

  return $error;
}

function fieldLabel($name, $label)
{
  if (is_null($label)) return '';

  $name = str_replace('[]', '', $name);

  $out = '<label for="id-field-' . $name . '" class="control-label col-md-2 col-sm-12 col-xs-12">';
  $out .= $label . '</label>';

  return $out;
}

function fieldAttributes($name, $attributes = [])
{
  $name = str_replace('[]', '', $name);

  return array_merge(['class' => 'form-control col-md-10 col-sm-12 col-xs-12', 'id' => 'id-field-' . $name], $attributes);
}

function fetchMultiUrl2($urls, $timeout=15, &$errorUrls=[]){

    //$startTime = microtime_float();
    $res = [];

  $mh = curl_multi_init();
  foreach ($urls as $u) {
    $ch = curl_init();
    curl_setopt_array($ch,
      array(
        CURLOPT_URL            => $u,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_CONNECTTIMEOUT => $timeout,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
        CURLOPT_FAILONERROR    => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_MAXREDIRS      => 3,
        CURLOPT_ENCODING       => 'gzip',
      )
    );
    curl_multi_add_handle($mh, $ch);
  }

  do {
      $stat = curl_multi_exec($mh, $running); //multiリクエストスタート
  } while ($stat === CURLM_CALL_MULTI_PERFORM);
  if ( ! $running || $stat !== CURLM_OK) {
      throw new RuntimeException('リクエストが開始出来なかった。マルチリクエスト内のどれか、URLの設定がおかしいのでは？');
  }

  do switch (curl_multi_select($mh, $timeout)) { //イベントが発生するまでブロック
      // 最悪$TIMEOUT秒待ち続ける。
      // あえて早めにtimeoutさせると、レスポンスを待った状態のまま別の処理を挟めるようになります。
      // もう一度curl_multi_selectを繰り返すと、またイベントがあるまでブロックして待ちます。

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
            //var_dump($raised); echo '<hr>';
              //変化のあったcurlハンドラを取得する
              $info = curl_getinfo($raised['handle']);
              //echo "{$info['url']}: {$info['http_code']}\n";
              //var_dump($info);echo '<hr>';
              $response = curl_multi_getcontent($raised['handle']);

              if ($response === false) {
                  //エラー。404などが返ってきている
                  echo 'ERROR!!!', PHP_EOL;
              } else {
                  //正常にレスポンス取得
                    //echo $response, PHP_EOL;
                    $id = array_search($info['url'],$urls);
                  $res[$id] = $response;
              }
              curl_multi_remove_handle($mh, $raised['handle']);
              curl_close($raised['handle']);
          } while ($remains);
          //select前に全ての処理が終わっていたりすると
          //複数の結果が入っていることがあるのでループが必要

  } while ($running);
  echo 'finished', PHP_EOL;
  curl_multi_close($mh);
  //echo '<hr>';
  //var_dump($res);
  //echo (microtime_float()-$startTime)."s";
  //exit;
  return $res;

}

function fetchMultiUrl($urls, $timeout = 15, &$errorUrls = []) {

  $mh = curl_multi_init();

  foreach ($urls as $key => $url) {
    $conn[$key] = curl_init($url);
    curl_setopt($conn[$key], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36');
    curl_setopt($conn[$key], CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($conn[$key], CURLOPT_FAILONERROR, 1);
    curl_setopt($conn[$key], CURLOPT_FOLLOWLOCATION, 1);
    //curl_multi_setopt($conn[$key], CURLMOPT_MAXCONNECTS, 20);

    curl_setopt($conn[$key], CURLOPT_MAXREDIRS, 3);
    curl_setopt($conn[$key], CURLOPT_ENCODING,'gzip');

    if ($timeout) {
      curl_setopt($conn[$key], CURLOPT_TIMEOUT, $timeout);
      curl_setopt($conn[$key], CURLOPT_CONNECTTIMEOUT, $timeout);
    }

    curl_multi_add_handle($mh, $conn[$key]);
  }

  // $active = null;
  // do {
  //   $mrc = curl_multi_exec($mh, $active);
  //   $info = curl_multi_info_read($mh);
  //   if (false !== $info) var_dump($info);
  // } while ($mrc == CURLM_CALL_MULTI_PERFORM);

  // while ($active and $mrc == CURLM_OK) {
  //   if (curl_multi_select($mh) != -1) {
  //     do {
  //       $mrc = curl_multi_exec($mh, $active);
  //     } while ($mrc == CURLM_CALL_MULTI_PERFORM);
  //   }
  // }
  do {
      curl_multi_exec($mh, $running);
  } while ($running);

    //データを取得
  $res = array();
  foreach ($urls as $key => $url) {
    if (($err = curl_error($conn[$key])) == '') {
      $res[$key] = curl_multi_getcontent($conn[$key]);
    } else {
      $errorUrls[$key] = $urls[$key];
    }
    curl_multi_remove_handle($mh, $conn[$key]);
    curl_close($conn[$key]);
  }
  curl_multi_close($mh);

  return $res;
}


function sendPing($host, $path, $title, $url){

    $title = htmlspecialchars($title);
    $xml =<<< PING
<?xml version="1.0"?>
<methodCall>
<methodName>weblogUpdates.ping</methodName>
<params>
<param>
<value>$title</value>
</param>
<param>
<value>$url</value>
</param>
</params>
</methodCall>
PING;

    $xmlLen = strlen($xml);

    $req =<<< REQ
POST $path HTTP/1.0
Host: $host
Content-Type: text/xml
Content-Length: $xmlLen

$xml
REQ;

    $s = @fsockopen($host, 80, $errNo, $errStr, 3);

    $res = "";
    if($s){
        fputs($s, $req);
        while(!feof($s)) {$res .= fread($s, 1024);}
    }

    return $res;
}