<?php
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        //自動でランダムのURLを生成して画像フォルダに保存するスクリプト
        $name = md5(rand(100, 200));
        $ext = explode('.', $_FILES['file']['name']);
        $filename = $name . '.' . $ext[1];
        $destination = './upload2/' . $filename;
        $location = $_FILES["file"]["tmp_name"];
        move_uploaded_file($location, $destination);
        echo '/upload2/' . $filename;
    }
    else
    {
      echo  $message = 'uploading is false error:  '.$_FILES['file']['error'];
    }
}