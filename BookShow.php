<?php
header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');
// $line = file_get_contents('C:\xampp\htdocs\BookTextFile.txt');
$txt_file = fopen('C:\xampp\htdocs\BookTextFile.txt', 'r');
$BookArry = array();
while ($line = fgets($txt_file)) {
	$encoding  = mb_detect_encoding($line, array('UTF-16','UCS-2','UTF-8','BIG5','ASCII'));
       // echo $encoding;
    $str = iconv($encoding, 'UTF-8', $line);
	$line = preg_replace("/\r\n|\r|\n/","",$str);
	array_push($BookArry, $line);
}
fclose($txt_file);
echo json_encode($BookArry);


?>