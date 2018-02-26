<?php 
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link=mysqli_connect($servername,$username,$password);
  if (!$link)                                                 // 检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'my_db');                            //选择库
  if (!isset($_COOKIE['uname']))                                   
    header('location:login.php');                             //检验是否已登录过
  if($_POST['submit'])
  {
    $cont=$_POST['content'];
	if (empty($cont))
	  echo '内容不能为空';
    else
    {
	  $insert="INSERT INTO messageboard (author,message) VALUES ('".$_COOKIE['uname']."','".$cont."')";
      if (mysqli_query($link,$insert))
        header('location:messageboard.php');
      else
        echo '发表失败，请重试：'.mysqli_error($link);	
    }	
  }	  
?>
