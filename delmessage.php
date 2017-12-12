<?php
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link = mysqli_connect($servername,$username,$password);  
  if (!$link)                                                  //检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'my_db');	                           //选择库
  $delcont=$_GET['cont'];
  $del='DELETE FROM messageboard WHERE author='.$delcont;
  if (mysqli_query($link,$del))
	header('location:messageboard.php');
  else
	echo "删除失败，请重试".mysqli_error($link);
  
?>