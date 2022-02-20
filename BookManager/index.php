<?php
include("class/dbconnect.php");
header("Content-Type:text/html; charset==utf-8");
$mysql = new Mysql();



// echo $SortDirection;
// if(empty($SortDirection)){
	$showBook = $mysql->Show();
// }


@$BookSort = $_POST["BookSortData"];
@$SortDirection = $_POST["SortDirectionData"];
if(!empty($BookSort) && !empty($SortDirection)){
	$showBook =$mysql->SortID_Books($BookSort,$SortDirection);

}

@$ISBN = $_POST["DeleteData"];
if(!empty($ISBN)){
	// var_dump($SortDirection);
	 $showBook = $mysql->DeleteID_Books($ISBN,$BookSort,$SortDirection);
	//  $showBook =$mysql->SortID_Books($BookSort,$SortDirection);
	// echo "<meta http-equiv='refresh' content='0'>";
}
include("xhtml/index.html");


// $showBook = $mysql->SortID_Books($BookSort,$SortDirection);