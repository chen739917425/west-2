<?php
$servername = "localhost";
$username = "root";
$password = "0424"; 
$link=mysqli_connect($servername,$username,$password);
if (!$link)                                                 // 检测连接
   die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($link,'shop_db');                            //选择库
$commodity_id=$_GET['cmd_id'];
$select="SELECT * FROM commodity WHERE commodity_id='".$commodity_id."'";
$result=mysqli_query($link,$select);
$row=mysqli_fetch_array($result);
echo '<div style="position:fixed; left:0px; top:0px; width:100%;height:100%;z-index:-1">       
      <img src="background.jpg" width="100%" height="100%"/>
      </div> ';
echo '<img src="'.$row['image_url'].'" width="200px" height="350px"/> <br/>';
echo $row['commodity_name'];
echo '<br/>';
echo '￥'.$row['commodity_price'].'<br/>';
echo $row['commodity_describe'].'<br/>';
if (isset($_COOKIE['user']))
	echo '<a href ="shopcart_add.php?c_id='.$row['commodity_id'].'">加入购物车</a>';
if (isset($_COOKIE['manager']))
{
	echo '<a href ="commodityUpdate_upload.php?c_id='.$row['commodity_id'].'">修改商品信息</a> <br/>';
    echo '<a href ="commodity_delete.php?c_id='.$row['commodity_id'].'">删除该商品</a>';
}	
echo "<br/><a href='commodity_show.php?sort=服装'>返回商城</a>";
echo "<br/><a href='shopcart.php'>查看购物车</a>";
?>