<?php
class Mysql
{
    public $conn;
    public $dbname = "Books";
    public $username = "root";
    public $password = "123456";
    public $host = "localhost";
    //連接資料庫
    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if (!$this->conn) {
            die("連接失敗");
        } else {
            mysqli_query($this->conn, "SET NAMES utf8");
        }
    }
    function GetRow_Books(){
        $sql = "SELECT * FROM `BooksList` ORDER BY `id`"; //修改成你要的 SQL 語法
        $query = mysqli_query($this->conn, $sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $data_nums = mysqli_num_rows($query); //統計總比數
            }
        }
        return $data_nums;
    }
    function GetPageLimit_Books($start,$per,$BookSortAndDirection){
        if(empty($BookSortAndDirection)){
        $sql = "SELECT bookslist.ISBN,bookslist.Version,bookslist.BookName,bookslist.Author,bookslist.Price,bookslist.OutDate,tips.Phone,tips.Address
                FROM bookslist
                LEFT JOIN tips
                ON tips.ISBN=bookslist.ISBN
                ORDER BY bookslist.ISBN 
                LIMIT  $start , $per";    
        // $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` LIMIT  $start , $per";
        }
        else{
            @$cutToArry = explode(":", $BookSortAndDirection);
            $ExportBookSort = $cutToArry[0];
            $ExportSortDirection = $cutToArry[1];
            $sql = "SELECT bookslist.ISBN,bookslist.Version,bookslist.BookName,bookslist.Author,bookslist.Price,bookslist.OutDate,tips.Phone,tips.Address
                FROM bookslist
                LEFT JOIN tips
                ON tips.ISBN=bookslist.ISBN
                ORDER BY $ExportBookSort $ExportSortDirection 
                LIMIT  $start , $per"; 
            // $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ORDER BY $ExportBookSort $ExportSortDirection LIMIT  $start , $per";
        }
        // var_dump(empty($ExportBookSort));
        $query = mysqli_query($this->conn,$sql);
        
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    @$datas[] = $row;
                }
            }
        }
        return @$datas;

    }
    function Export_Books($ExportWayName,$ExportArry, $BookSortAndDirection)        //排序書籍&顯示
    {

        // 判斷匯出方式和排序方式
        if($ExportWayName == "ExportValueNormal"){
            if(empty($BookSortAndDirection)){
                $PutArrayData = array();
                for ($x = 0; $x < count($ExportArry); $x++) {
                    array_push($PutArrayData, "\"" . $ExportArry[$x] . "\"");
                }
                
                $LinkData = implode(",", $PutArrayData);
                $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` WHERE `ISBN` IN ($LinkData)";
            }
            else{

                $PutArrayData = array();
                for ($x = 0; $x < count($ExportArry); $x++) {
                    array_push($PutArrayData, "\"" . $ExportArry[$x] . "\"");
                }
                
                $LinkData = implode(",", $PutArrayData);
                @$cutToArry = explode(":", $BookSortAndDirection);

                $ExportBookSort = $cutToArry[0];
                $ExportSortDirection = $cutToArry[1];
                $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` WHERE `ISBN` IN ($LinkData) ORDER BY $ExportBookSort $ExportSortDirection";
            }
           
        }
         if ($ExportWayName == "ExportValueAll") {
             if(empty($BookSortAndDirection)){
                $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` WHERE `ISBN` ";
             }
             else{
                @$cutToArry = explode(":", $BookSortAndDirection);
                $ExportBookSort = $cutToArry[0];
                $ExportSortDirection = $cutToArry[1];
                $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` WHERE `ISBN`  ORDER BY $ExportBookSort $ExportSortDirection";
             }
            
        } 
        if($ExportWayName == "ExportValueThisPage"){
            
        }
        // else {
        //     $PutArrayData = array();
        //     for ($x = 0; $x < count($ExportArry); $x++) {
        //         array_push($PutArrayData, "\"" . $ExportArry[$x] . "\"");
        //     }
        //     $LinkData = implode(",", $PutArrayData);
        //     @$cutToArry = explode(":", $BookSortAndDirection);
        //     $ExportBookSort = $cutToArry[0];
        //     $ExportSortDirection = $cutToArry[1];
        //     $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` WHERE `ISBN` IN ($LinkData) ORDER BY $ExportBookSort $ExportSortDirection";
        // }
        $query = mysqli_query($this->conn, $sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    @$datas[] = $row;
                }
            }
        }
        return @$datas;
    }
    function ExportThisPage($start,$per,$BookSortAndDirection){
        if(empty($BookSortAndDirection)){
        $sql = "SELECT bookslist.ISBN,bookslist.Version,bookslist.BookName,bookslist.Author,bookslist.Price,bookslist.OutDate
                FROM bookslist
                LEFT JOIN tips
                ON tips.ISBN=bookslist.ISBN
                ORDER BY bookslist.ISBN 
                LIMIT  $start , $per";    
        // $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` LIMIT  $start , $per";
        }
        else{
            @$cutToArry = explode(":", $BookSortAndDirection);
            $ExportBookSort = $cutToArry[0];
            $ExportSortDirection = $cutToArry[1];
            $sql = "SELECT bookslist.ISBN,bookslist.Version,bookslist.BookName,bookslist.Author,bookslist.Price,bookslist.OutDate
                FROM bookslist
                LEFT JOIN tips
                ON tips.ISBN=bookslist.ISBN
                ORDER BY $ExportBookSort $ExportSortDirection 
                LIMIT  $start , $per"; 
            // $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ORDER BY $ExportBookSort $ExportSortDirection LIMIT  $start , $per";
        }
        // var_dump(empty($ExportBookSort));
        $query = mysqli_query($this->conn,$sql);
        
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    @$datas[] = $row;
                }
            }
        }
        return @$datas;

    }
    function SortID_Books($BookSort, $SortDirection)        //排序書籍&顯示
    {
        $sql = "SELECT `ISBN`,`Version`,`BookName`,`Author`,`Price`,`OutDate` FROM `BooksList` ORDER BY `$BookSort` $SortDirection ";
        $query = mysqli_query($this->conn, $sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    @$datas[] = $row;
                }
            }
        }

        return @$datas;
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
        }
        return $result;
    }

    function DeleteID_Books($ISBN) // 刪除文章
    {
        $result = 'false';
        $sql = "DELETE FROM `BooksList`   
        WHERE `ISBN` = '{$ISBN}'";

        $query = mysqli_query($this->conn, $sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) == 1) {
                $result = "true";
            }
        }

        return $result;
    }
    function SelectID_Books($ISBN)      //依isbn選擇資料
    {
        $datas = null;
        $sql = "SELECT * FROM `BooksList`  WHERE `ISBN` = '{$ISBN}'";
        $query = mysqli_query($this->conn, $sql);
        if ($query) {
            if (mysqli_affected_rows($this->conn) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $datas[] = $row;
                }
            }
        }
        if (!is_null($datas)) {
            return $datas;
        } else {
            return null;
        }
    }
}
