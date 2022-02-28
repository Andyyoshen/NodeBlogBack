<?php
    //資料庫連結
  include("class/dbconnect.php");
    
	$mysql = new Mysql();
	$NumData= $mysql->GetRow_Books();

    $per = 4; //每頁顯示項目數量
    $pages = ceil($NumData/$per); //取得不小於值的下一個整數
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page-1)*$per; //每一頁開始的資料序號
    // $LimitData = $mysql->GetPageLimit_Books($start,$per);
		var_dump($LimitData);
?>

<table>
<tr>
    <td style="text-align: center;">編號</td>
    <td style="text-align: center;">姓名</td>
</tr>
<?php
//輸出資料內容
// while ($row = mysql_fetch_array ($result))
{
    $id=$row['id'];
    $name=$row['name'];
    ?>
    
    <tr>
        <td style="text-align: center;"><?php echo $id; ?></td>
        <td style="text-align: center;"><?php echo $name; ?></td>
    </tr>

<?php 
    }
?>
</table>

<br />

<?php
    //分頁頁碼
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁';
    echo "<br /><a href=?page=1>首頁</a> ";
    echo "第 ";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if ( $page-3 < $i && $i < $page+3 ) {
            echo "<a href=?page=".$i.">".$i."</a> ";
        }
    } 
    echo " 頁 <a href=?page=".$pages.">末頁</a><br /><br />";
?>