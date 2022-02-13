<?php
header('Content-Type: application/json; charset=UTF-8'); //設定資料類型為 json，編碼 utf-8
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With,Origin,Content-Type,Cookie,Accept');
// $postData = file_get_contents('php://input');
// $requests = !empty($postData) ? json_decode($postData) : array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	@$ISBNid = $_POST["ISBNid"]; //取得 nickname POST 值
	@$VersionName = $_POST["VersionName"]; //取得 nickname POST 值
	@$BookName = $_POST["BookName"]; //取得 nickname POST 值
	@$Account = $_POST["Account"]; //取得 nickname POST 值
	@$Price = $_POST["Price"]; //取得 nickname POST 值
	@$OutDate = $_POST["OutDate"]; //取得 nickname POST 值
	@$BookFileName = $_POST["BookFileName"];
	//echo	$data;
}

//return false;
$txt_file = fopen('C:/xampp/htdocs/'.$BookFileName, 'r') ;
$BookArry = array();
while ($line = fgets($txt_file)) {
	array_push($BookArry, $line);
}
$BootSplit = array();
$BookArryLength = count($BookArry);
$strTest = array();
$strTest = [$ISBNid, $VersionName, $BookName, $Account, $Price, $OutDate."\r\n"];
for ($x	=	0; $x < $BookArryLength; $x++) {
	$BootSplit =  explode(",", $BookArry[$x]);
	if ($BootSplit[0] == $strTest[0]) {
		for ($n = 0; $n < count($BootSplit); $n++) {
			if($n == 5){
				
				$BootSplit[$n] = $strTest[$n];
			}
			$BootSplit[$n] = $strTest[$n];
		}
		$BookArry[$x] = implode(",", $BootSplit);
	}
}
file_put_contents('C:/xampp/htdocs/'.$BookFileName,'');
for($n	=	0;	$n	<	count($BookArry);	$n++){
	file_put_contents('C:/xampp/htdocs/'.$BookFileName, $BookArry[$n], FILE_APPEND);
}
fclose($txt_file);
$txt_file2 = fopen('C:/xampp/htdocs/'.$BookFileName, 'r');
$ShowBookArry = array();
while ($line = fgets($txt_file2)) {
	//echo $line;
	//$line = preg_replace("/\r\n|\r|\n/","",$line);
	array_push($ShowBookArry, $line);
}
//var_dump($ShowBookArry);
fclose($txt_file2);
echo json_encode($ShowBookArry);
//print_r($BookArry); //剩寫入

?>