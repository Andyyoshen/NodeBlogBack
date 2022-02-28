<?php

include("class/dbconnect.php");

$mysql = new Mysql();
//------------------GET的資料----------------------
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	@$IisbnValueGET = $_GET["ISBNid"];
	$Data = $mysql->SelectID_Books($IisbnValueGET);
	@$IisbnValue = $Data[0]["ISBN"];
	@$VersionValue = $Data[0]["Version"];
	@$BookNameValue = $Data[0]["BookName"];
	@$AuthorValue = $Data[0]["Author"];
	@$PriceValue = $Data[0]["Price"];
	@$OutDateValue = $Data[0]["OutDate"];
}
//-------------------------------------------------
else	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$PriceValuePattenr = "/^\d+$/";
	$OutDateValuePattern = "/^\d{4}-\d{2}-\d{2}$/";
	//------------------POST的資料----------------------
	@$IisbnValue =  $_POST["IisbnValue"];
	@$VersionValue =  $_POST["VersionValue"];
	@$BookNameValue =  $_POST["BookNameValue"];
	@$AuthorValue =  $_POST["AuthorValue"];
	@$PriceValue =  $_POST["PriceValue"];
	@$OutDateValue =  $_POST["OutDateValue"];
	//-------------------------------------------------
	if ($VersionValue == "") {
		echo "<script>alert('出版社不為空') </script>";
	} else if ($BookNameValue == "") {
		echo "<script>alert('書名不為空')</script>";
	} else if ($AuthorValue == "") {
		echo "<script>alert('作者不為空')</script>";
	} else if (preg_match_all($PriceValuePattenr, $PriceValue) == 0) {
		echo "<script>alert('價格請輸入數字')</script>";
	} else if (preg_match_all($OutDateValuePattern, $OutDateValue) == 0) {
		echo "<script>alert('日期請輸入正確格式')</script>";
	}
	else {
		$VersionValue = addslashes($VersionValue);
		$BookNameValue2 = addslashes($BookNameValue);
		$AuthorValue = addslashes($AuthorValue);
		$mysql = new Mysql();
		$result =	$mysql->UpdateID_Books($IisbnValue, $VersionValue, $BookNameValue2, $AuthorValue, $PriceValue, $OutDateValue);
		if ($result == true) {
			echo "<script>window.location.href='index.php'</script>";
			exit;
		}//失敗訊息
		else{
			echo "<script>alert('錯誤')</script>";
			echo "<script>window.location.href='index.php'</script>";
			exit;
		}
	}

}
include("xhtml/Edit.html");

