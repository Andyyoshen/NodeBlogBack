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
	$data=$ISBNid.','.$VersionName.','.$BookName.','.$Account.','.$Price.','.$OutDate; //要寫入txt的資料 
}
else{
	echo "失敗";
}
file_put_contents('C:/xampp/htdocs/'.$BookFileName,$data.PHP_EOL,FILE_APPEND);
// $line = file_get_contents('C:\xampp\htdocs\BookTextFile.txt');
$txt_file = fopen('C:/xampp/htdocs/'.$BookFileName, 'r');

$BookArry = array();
while ($line = fgets($txt_file)) {
	//echo $line;
	$line = preg_replace("/\r\n|\r|\n/","",$line);
	array_push($BookArry, $line);
}
echo json_encode($BookArry);
?>