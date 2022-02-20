<?php
include("dbconnect.php");
function Show()
{
    $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ";
    $query = mysqli_query($GLOBALS['link'], $sql);
    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }
    } else {
        echo "請聯絡管理員";
    }
    return $datas;
}
function SortID_Books($BookSort, $SortDirection)
{
    $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ORDER BY `$BookSort` $SortDirection ";
    $query = mysqli_query($GLOBALS['link'], $sql);
    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }
    } else {
        echo "請聯絡管理員";
    }

    return $datas;
}
function DeleteID_Books($ISBN) // 刪除文章
{
    $result = "false";
    $sql = "DELETE FROM `BooksList`   
    WHERE `ISBN` = '{$ISBN}'";
    $query = mysqli_query($GLOBALS['link'], $sql);
    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) == 1) {
            $result = "true";
        }
    } else {
        echo "請聯絡管理員";
    }

    return $result;
}

function Search_Account($ListTyep, $ListValue) //搜尋
{

    $datas = array();
    if ($ListValue == '') {
        $sql = "SELECT * FROM `Account` ";
    } else {
        $sql = "SELECT * FROM `Account` WHERE {$ListTyep} LIKE '%{$ListValue}%'";
    }

    $query = mysqli_query($GLOBALS['link'], $sql);
    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }
    } else {
        echo "請聯絡管理員";
    }
    return $datas;
}

function SelectID_Books($ISBN) //選擇
{
    $datas = array();
    $sql = "SELECT `Version`,`BookName`,`Author`,`Price`,`OutDate`
            FROM `BooksList` WHERE ISBN = '{$ISBN}'";
    $query = mysqli_query($GLOBALS['link'], $sql);
    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }
    } else {
        echo "請聯絡管理員";
    }
    return $datas;
}
function UpdateID_Books($ISBN, $Version, $BookName, $Author, $Price, $OutDate) //更新 
{
    $result = "false";
    $sql = "UPDATE `BooksList` 
                SET `Version` = '{$Version}',
                `BookName` = '{$BookName}',
                `Author` = '{$Author}',
                `Price` = '{$Price}',
                `OutDate` = '{$OutDate}'
                WHERE `ISBN` = '{$ISBN}'";
    $query = mysqli_query($GLOBALS['link'], $sql);

    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) == 1) {
            $result = "true";
        }
    } else {
        echo "{$sql}語法請求失敗:<br/>" . mysqli_error($GLOBALS['link']);
    }
    return $result;
}
function Add_Books($ISBN, $Version, $BookName, $Author, $Price, $OutDate) //新增
{
    $result = "false";
    $sql = "INSERT INTO `BooksList` (`ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate`) VALUES ('{$ISBN}','{$Version}','{$BookName}','{$Author}','{$Price}','{$OutDate}')";
    $query = mysqli_query($GLOBALS['link'], $sql);
    if ($query) {
        if (mysqli_affected_rows($GLOBALS['link']) == 1) {
            $result = "true";
        }
    } else {
        echo "請聯絡管理員";
    }
    return $result;
}
