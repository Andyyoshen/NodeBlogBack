<?php
 header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');
if ($_FILES["file"]["error"] > 0)
 {
 echo "Error: " . $_FILES["file"]["error"] . "<br />";
 }
else
 {
    $fileName = $_FILES["file"]["name"];
    $type = $_FILES["file"]["type"];
    $size = ($_FILES["file"]["size"] / 1024)." kb" ;
    $tmp_name =  $_FILES["file"]["tmp_name"] ;
    // echo "Upload: " .$fileName . "<br />";
    // echo "Type: " . $type . "<br />";
    // echo "Size: " . $size. " Kb<br />";
    // echo "Stored in: " . $tmp_name."<br />";
    move_uploaded_file($tmp_name,"C:/xampp/htdocs/".$fileName);
    $txt_file = fopen('C:/xampp/htdocs/'.$fileName, 'r') ;
    // var_dump( $txt_file);
    $BookArry = array();
    while ($line = fgets($txt_file)) {
        $encoding  = mb_detect_encoding($line, array('UTF-16','UCS-2','UTF-8','BIG5','ASCII'));
       // echo $encoding;
        $str = iconv($encoding, 'UTF-8', $line);
        $line = preg_replace("/\r\n|\r|\n/","",$str);
         //echo $line;
        array_push($BookArry, $line);
    }
    fclose($txt_file);
   //var_dump($BookArry);
    echo json_encode($BookArry,JSON_UNESCAPED_UNICODE);
    //echo "success";
  }
?>