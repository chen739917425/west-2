<?php
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link = mysqli_connect($servername,$username,$password);  
  if (!$link)                                                  //检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'shop_db');	                           //选择库
  $del="DELETE FROM commodity WHERE commodity_id='".$_GET['c_id']."'";
  if (mysqli_query($link,$del))
	header('location:commodity_show.php');
  else
  {
	echo "删除失败，请重试".mysqli_error($link);
    echo '<a href="commodity_show.php">返回商城</a>';	
  }
?>