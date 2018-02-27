<?php
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $newpassword=md5($_POST['userpassword']);  
  $link = mysqli_connect($servername,$username,$password);  
  if (!$link)                                                  //检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'shop_db');	                           //选择库
  $select="SELECT * FROM user WHERE user_id ='".$_POST['username']."'";    //找到与输入用户名相同的信息，要取出两项
  $result=mysqli_query($link,$select);
  if ($result==false)
    echo mysqli_error($link);	  
  $row = mysqli_fetch_array($result);                                                    //取出
  if($_POST['submit'])
  {      
    if($row['user_id']==$_POST['username'] && $row['user_password']==$newpassword)
	{  
        setcookie('uname',$_POST['username'],time()+3600);  
        header('location:messageboard.php');  
    }  
    else 
	{
		echo "用户名不存在或密码错误";
	}	
 }  
?>
<html>
  <head>
    <meta charset=UTF-8>
    <title>登录失败</title>
  </head>
  <style type ="text/css">
  .b_style
	{
		font-weight:bold;
		font-size:17px;
	}
  </style>
  <body>
  <a href="login.html"><span class="b_style">返回登录界面</span></a>
  </body>  
</html>  