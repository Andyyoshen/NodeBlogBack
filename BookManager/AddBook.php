<?php

include("class/dbconnect.php");
@$IisbnValue =  $_POST["IisbnValue"];
@$VersionValue =  $_POST["VersionValue"];
$VersionValue = addslashes($VersionValue);
@$BookNameValue =  $_POST["BookNameValue"];
$BookNameValue = addslashes($BookNameValue);
@$AuthorValue =  $_POST["AuthorValue"];
$AuthorValue = addslashes($AuthorValue);
@$PriceValue =  $_POST["PriceValue"];
@$OutDateValue =  $_POST["OutDateValue"];
include("xhtml/SavePage.html");
$IisbnValuePattern = "/^\d{3}-\d{3}-\d{3}-\d$/";
$PriceValuePattenr = "/^\d+$/";
$OutDateValuePattern = "/^\d{4}-\d{2}-\d{2}$/";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(preg_match_all($IisbnValuePattern,$IisbnValue) == 0){
		echo "<script> alert('ISBN請符合格式') </script>";
		 return false;
	}
	if($VersionValue == ""){
		echo "<script>alert('版本不為空')</script>";
		return false;
	}
	if($BookNameValue == ""){
		echo "<script>alert('書名不為空')</script>";
		return false;
	}
	if($AuthorValue == ""){
		echo "<script>alert('作者不為空')</script>";
		return false;
	}
	if(preg_match_all($PriceValuePattenr,$PriceValue) == 0){
		echo "<script>alert('價格請輸入數字')</script>";
		return false;
	}
	if(preg_match_all($OutDateValuePattern,$OutDateValue) == 0){
		echo "<script>alert('日期請輸入正確格式')</script>";
		return false;
	}
	$mysql = new Mysql();
	if(!is_null($mysql->SelectID_Books($IisbnValue))){
		echo "<script>alert('已有重複ISBN')</script>";
		return false;
	}
	$result  =$mysql->Add_Books($IisbnValue,$VersionValue,$BookNameValue,$AuthorValue, $PriceValue, $OutDateValue );
	if($result == true){	
		echo "<script>window.location.href='http://localhost/BookManager/index.php'</script>";
	}

}
?>
