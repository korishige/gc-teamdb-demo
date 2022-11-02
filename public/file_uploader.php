<?php
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        $name = md5(rand(100, 200));
        $ext = explode('.', $_FILES['file']['name']);
        $filename = $name . '.' . $ext[1];
        $destination = './upload_brief/' . $filename;
        $location = $_FILES["file"]["tmp_name"];
        move_uploaded_file($location, $destination);
        echo 'http://ffa.tkss.xyz/upload_brief/' . $filename;
    }
    else
    {
      echo  $message = 'uploading is false error:  '.$_FILES['file']['error'];
    }
}