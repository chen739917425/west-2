<?php 
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link=mysqli_connect($servername,$username,$password);
  if (!$link)                                                 // 检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'shop_db');                            //选择库
  if (!isset($_COOKIE['user']))                                   
    header('location:login.html');                             //检验是否登录
    $cmd_id=$_GET['c_id'];
    $select="SELECT commodity_name FROM commodity WHERE commodity_id='".$cmd_id."'";
	$result=mysqli_query($link,$select);
	$row=mysqli_fetch_array($result);
	$cmd_name=$row['commodity_name'];
	$insert="INSERT INTO shopcart (pur_id,cmd_id,cmd_name) VALUES ('".$_COOKIE['user']."',".$cmd_id.",'".$cmd_name."')";
	if (mysqli_query($link,$insert))
	{
		header('location:shopcart.php');
	}	
	else
	{
		echo '商品添加至购物车失败，请重试'.'<br>';
		echo '<a href="commodity_show.php?sort=服装">返回商城</a>';
	}
?>
