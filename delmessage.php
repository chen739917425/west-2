<?php
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link = mysqli_connect($servername,$username,$password);  
  if (!$link)                                                  //检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'my_db');	                           //选择库
  $delcont=$_GET["con"];
  $del='DELETE FROM messageboard WHERE message='.$delcont;
  if (isset($_GET["con"]))
	echo $_GET["con"]."sd";  
  
?>