<?php
header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');
// $postData = file_get_contents('php://input');
// $requests = !empty($postData) ? json_decode($postData) : array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	@$ISBNid = $_POST["ISBNid"]; //取得 nickname POST 值
    @$BookFileName = $_POST["BookFileName"];
}
$txt_file = fopen('C:/xampp/htdocs/'.$BookFileName, 'r');
$BookArry = array();
while ($line = fgets($txt_file)) {
    // $encoding  = mb_detect_encoding($line, array('UTF-16','UCS-2','UTF-8','BIG5','ASCII'));
    // $str = iconv($encoding, 'UTF-8', $line);
	array_push($BookArry, $line);
}
// print_r($BookArry);
// return false;
$BootSplit = array();
$BookArryLength = count($BookArry);
$strTest = array();
$strTest = [$ISBNid];
for ($x	=	0; $x < $BookArryLength; $x++) {
	$BootSplit =  explode(",", $BookArry[$x]);
	if ($BootSplit[0] == $strTest[0]) {
		// for ($n = 0; $n < count($BootSplit); $n++) {
		// 	$BootSplit[$n] = $strTest[$n];
		// }
		$BookArry[$x] = "";
	}
}
fclose($txt_file);
file_put_contents('C:/xampp/htdocs/'.$BookFileName,'');
for($n	=	0;	$n	<	count($BookArry);	$n++){
	file_put_contents('C:/xampp/htdocs/'.$BookFileName, $BookArry[$n], FILE_APPEND);
}

$txt_file2 = fopen('C:/xampp/htdocs/'.$BookFileName, 'r');
$ShowBookArry = array();
while ($line = fgets($txt_file2)) {
	//echo $line;
	//$line = preg_replace("/\r\n|\r|\n/","",$line);
	array_push($ShowBookArry, $line);
}
//print_r($ShowBookArry);
//var_dump($ShowBookArry);
fclose($txt_file2);
//print_r($ShowBookArry);
echo json_encode($ShowBookArry);
//print_r($BookArry); //剩寫入

?>