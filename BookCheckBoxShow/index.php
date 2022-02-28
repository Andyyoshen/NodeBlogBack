<?php
include("class/dbconnect.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(empty($_POST["DeleteData"])){
		if (empty($_POST["ExportWayName"])) {
			echo "<script>alert('請選則匯出方式')</script>";
		} else if ($_POST["ExportWayName"] == 'ExportValueNormal' && empty($_POST["ExportIsbnName"])) {
			echo "<script>alert('請選則匯出項目')</script>";
		} else {
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.ms-excel');
			$today = date('Y-m-d');
			$fileName = 'BookManager' . $today . '.csv';
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
		}
	}
	



	// if (!empty($_POST["ExportWayName"])) {

	// 	if($_POST["ExportWayName"] == "ExportValueNormal"){
	// 		if(empty($_POST["ExportIsbnName"])){
	// 			echo "<script>alert('請選取項目')</script>";
	// 		}
	// 		else{
	// 			header('Content-Description: File Transfer');
	// 			header('Content-Type: application/vnd.ms-excel');
	// 			$today = date('Y-m-d');
	// 			$fileName = 'BookManager' . $today . '.csv';
	// 			header('Content-Disposition: attachment; filename="' . $fileName . '"');
	// 			header('Expires: 0');
	// 			header('Cache-Control: must-revalidate');
	// 			header('Pragma: public');
	// 		}
	// 	}
	// 	else if($_POST["ExportWayName"] == "ExportValueAll"){
	// 		header('Content-Description: File Transfer');
	// 		header('Content-Type: application/vnd.ms-excel');
	// 		$today = date('Y-m-d');
	// 		$fileName = 'BookManager' . $today . '.csv';
	// 		header('Content-Disposition: attachment; filename="' . $fileName . '"');
	// 		header('Expires: 0');
	// 		header('Cache-Control: must-revalidate');
	// 		header('Pragma: public');
	// 	}

	// }
}





header("Content-Type:text/html; charset=utf-8");


$mysql = new Mysql();
function export($data)
{
	$Fp = fopen('php://output', 'a+');
	$header = "ISBN" . "," . "出版社" . "," . "書名" . "," . "作者" . "," . "定價" . "," . "發行日";
	fwrite($Fp, $header . "\n");
	$Box = array();
	foreach (@$data as $value => $key) {
		$key = str_replace('"', '""', $key);
		foreach ($key as $temp => $StrData) {
			array_push($Box, "\"" . $StrData . "\"");
		}
		$FinalBox = implode(",", $Box);
		fwrite($Fp, $FinalBox . "\n");
		$Box = array();
	}
	fclose($Fp);
	exit;
}
@$page = $_GET["Page"];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	@$BookSortAndDirection = $_GET["BookSortAndDirection"];
	@$cutToArry = explode(":", $BookSortAndDirection);
}

//-------------------------------------------------------------
$NumData = $mysql->GetRow_Books();
$per = 4; //每頁顯示項目數量
$LastPage = ceil($NumData / $per); //取得不小於值的下一個整數
// if($page > $LastPage){
// 	$page = $LastPage;
// 	echo "<script>alert('over')</script>";
// } not yet
if (is_null(@$page)) { //假如$_GET["page"]未設置
	$page = 1; //則在此設定起始頁數
} else {
	$page = intval($page); //確認頁數只能夠是數值資料
}
$start = ($page - 1) * $per; //每一頁開始的資料序號

//--------------------------------------------------------------






if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	@$BookSortAndDirection = $_POST["BookSortAndDirection"];
	// @$cutToArry = explode(":", $BookSortAndDirection);
	@$ISBN = $_POST["DeleteData"];
	@$ExportValueAll = $_POST["ExportValueAll"];
	@$ExportValueThisPage = $_POST["ExportValueThisPage"];
	@$ExportValueNormal = $_POST["ExportValueNormal"];
	@$ExportIsbnName = $_POST["ExportIsbnName"];
	@$page = $_POST["Page"];
	$NumData = $mysql->GetRow_Books();
	$per = 4; //每頁顯示項目數量

	//-------------------------------------------------------------
	$NumData = $mysql->GetRow_Books();
	$per = 4; //每頁顯示項目數量
	$LastPage = ceil($NumData / $per); //取得不小於值的下一個整數
	if (is_null(@$page)) { //假如$_GET["page"]未設置
		$page = 1; //則在此設定起始頁數
	} else {
		$page = intval($page); //確認頁數只能夠是數值資料
	}
	$start = ($page - 1) * $per; //每一頁開始的資料序號

	//--------------------------------------------------------------
	if(empty($ISBN)){
		if (!empty($_POST["ExportWayName"])) {
			if ($_POST["ExportWayName"] == "ExportValueAll") {		//匯出全部
				@$ExportArry = explode(",", $ExportIsbnName);
				$data = $mysql->Export_Books($_POST["ExportWayName"], null, $BookSortAndDirection);
	
				export($data);
			}
			if ($_POST["ExportWayName"] == "ExportValueThisPage") {			//匯出這一頁
				$data = $mysql->ExportThisPage($start, $per, $BookSortAndDirection);
				export($data);
			}
	
			if ($_POST["ExportWayName"] == "ExportValueNormal") {		//匯出選取項目
	
				if (!empty($_POST["ExportIsbnName"])) {
					@$ExportArry = explode(",", $ExportIsbnName);
					$data = $mysql->Export_Books($_POST["ExportWayName"], $ExportArry, $BookSortAndDirection);
	
					export($data);
				}
			}
		}
	}
	
	if (!empty($ISBN)) {
		$mysql->DeleteID_Books($ISBN);
	}
}

// echo "--------------";
// var_dump($page);
$showBook = $mysql->GetPageLimit_Books($start, $per, $BookSortAndDirection);
// $showBook = $mysql->SortID_Books($cutToArry[0], $cutToArry[1]);
include("xhtml/index.html");
