<?php
class Mysql{
    public $conn;
    public $dbname="BooksManag";
    public $username="root";
    public $password="123456";
    public $host="localhost";
    //連接資料庫
    public function __construct(){
        $this->conn=mysqli_connect($this->host,$this->username,$this->password,$this->dbname);
        if(!$this->conn){
        die("連接失敗");
        }
        else{
            mysqli_query($this->conn,"SET NAMES utf8");
        }
        
    // mysql_select_db($this->dbname,$this->conn);
    }


    function Show()
    {
        $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ";
        $query = mysqli_query($this->conn,$sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $datas[] = $row;
                }
            }
        } else {
            echo "請聯絡管理員";
        }
        return $datas;
    }
    function SortID_Books($BookSort, $SortDirection)        //排序書籍
    {
        $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ORDER BY `$BookSort` $SortDirection ";
        $query = mysqli_query($this->conn, $sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $datas[] = $row;
                }
            }
        } else {
            echo "請聯絡管理員";
        }

        return $datas;
    }
    function Add_Books($ISBN, $Version, $BookName, $Author, $Price, $OutDate) //新增
{
    $result = "false";
    $sql = "INSERT INTO `BooksList` (`ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate`) VALUES ('{$ISBN}','{$Version}','{$BookName}','{$Author}','{$Price}','{$OutDate}')";
    $query = mysqli_query($this->conn, $sql);
    if ($query) {
        if (mysqli_affected_rows($this->conn) == 1) {
            $result = "true";
        }
    } else {
        echo "請聯絡管理員";
    }
    return $result;
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
    $query = mysqli_query($this->conn, $sql);

    if ($query) {
        if (mysqli_affected_rows($this->conn) == 1) {
            $result = "true";
        }
    } else {
        echo "{$sql}語法請求失敗:<br/>" . mysqli_error($this->conn);
    }
    return $result;
}

function DeleteID_Books($ISBN,$BookSort,$SortDirection) // 刪除文章
{
    $result = "false";
    $sql = "DELETE FROM `BooksList`   
    WHERE `ISBN` = '{$ISBN}'";
    $sql2 = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ORDER BY `$BookSort` $SortDirection ";
    $query = mysqli_query($this->conn, $sql);
    $query2 = mysqli_query($this->conn, $sql2);
    if ($query2) {
        if (mysqli_affected_rows($this->conn) > 0) {
            while ($row = mysqli_fetch_assoc($query2)) {
                $datas[] = $row;
            }
        }
    } else {
        echo "請聯絡管理員";
    }

    return $datas;
}
function SelectID_Books($ISBN)
{
    $sql = "SELECT * FROM `BooksList`  WHERE `ISBN` = '{$ISBN}'";
    $query = mysqli_query($this->conn, $sql);
    if ($query) {
        if (mysqli_affected_rows($this->conn) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $datas[] = $row;
            }
        }
    } else {
        echo "請聯絡管理員";
    }
    return $datas;
}
}
?>