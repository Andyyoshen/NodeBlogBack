<?php
include("class/dbconnect.php");
@$ExportBookSort = $_POST["selectedBookSort"];
@$ExportSortDirection = $_POST["selectedSortDirection"];
@$ExportArry = explode(",",$_POST["ExportIsbnName"]);

$mysql = new Mysql();
$data = $mysql->Export_Books($ExportArry,$ExportBookSort,$ExportSortDirection);

if(is_null($data)){
	echo '<script>alert("沒有任何資料可以匯出")</script>';
	echo "<script>window.location.href='index.php'</script>";
	exit;
}
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
$today = date('Y-m-d');
$fileName = 'BookManager' . $today . '.csv';
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header("Content-Type:text/html; charset=utf-8");

function export($data)
{
	$Fp = fopen('php://output', 'a+');
	$header = "ISBN" . "," . "出版社" . "," . "書名" . "," . "作者" . "," . "定價" . "," . "發行日";
	fwrite($Fp, $header . "\n");
	$Box = array();
	foreach ($data as $value => $key) {
		$key = str_replace('"', '""', $key);
		foreach ($key as $temp => $StrData) {
			array_push($Box, "\"" . $StrData . "\"");
		}
		$FinalBox = implode(",", $Box);
		fwrite($Fp, $FinalBox . "\n");
		$Box = array();
	}
	fclose($Fp);
}
export($data);
