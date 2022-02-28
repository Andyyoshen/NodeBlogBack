<?php

include("class/dbconnect.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	@$IisbnValue =  '';
	@$VersionValue =  '';
	@$BookNameValue =  '';
	@$AuthorValue =  '';
	@$PriceValue =  '';
	@$OutDateValue =  '';
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$mysql = new Mysql();
	@$IisbnValue =  $_POST["IisbnValue"];
	@$VersionValue =  $_POST["VersionValue"];
	@$BookNameValue =  $_POST["BookNameValue"];
	@$AuthorValue =  $_POST["AuthorValue"];
	@$PriceValue =  $_POST["PriceValue"];
	@$OutDateValue =  $_POST["OutDateValue"];
	$IisbnValuePattern = "/^\d{3}-\d{3}-\d{3}-\d$/";
	$PriceValuePattenr = "/^\d+$/";
	$OutDateValuePattern = "/^\d{4}-\d{2}-\d{2}$/";
	if (preg_match_all($IisbnValuePattern, $IisbnValue) == 0) {
		echo "<script> alert('ISBN請符合格式 例: 951-442-243-7') </script>";
	} else	if ($VersionValue == "") {
		echo "<script>alert('版本不為空')</script>";
	} else if ($BookNameValue == "") {
		echo "<script>alert('書名不為空')</script>";
	} else	if ($AuthorValue == "") {
		echo "<script>alert('作者不為空')</script>";
	} else	if (preg_match_all($PriceValuePattenr, $PriceValue) == 0) {
		echo "<script>alert('價格請輸入數字')</script>";
	} else if (preg_match_all($OutDateValuePattern, $OutDateValue) == 0) {
		echo "<script>alert('日期請輸入正確格式')</script>";
	} else	if (!is_null($mysql->SelectID_Books($IisbnValue))) {
		echo "<script>alert('已有重複ISBN')</script>";
	} else {
		$VersionValue = addslashes($VersionValue);
		$BookNameValue = addslashes($BookNameValue);
		$AuthorValue = addslashes($AuthorValue);
		$result  = $mysql->Add_Books($IisbnValue, $VersionValue, $BookNameValue, $AuthorValue, $PriceValue, $OutDateValue);
		if ($result == true) {
			echo "<script>window.location.href='index.php'</script>";
			exit;
		}
		else{
			echo "<script>alert('錯誤')</script>";
			echo "<script>window.location.href='index.php'</script>";
			exit;
		}
	}
}
include("xhtml/SavePage.html");
