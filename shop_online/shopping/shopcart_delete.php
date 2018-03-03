<?php
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link = mysqli_connect($servername,$username,$password);  
  if (!$link)                                                  //检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'shop_db');	                           //选择库
  $del="DELETE FROM shopcart WHERE cart_id='".$_GET['cart_id']."'";
  if (mysqli_query($link,$del))
	header('location:shopcart.php');
  else
  {
	echo "删除失败，请重试".mysqli_error($link); 
    echo '<a href="shopcart.php">返回购物车</a>';	
  }	  
?>