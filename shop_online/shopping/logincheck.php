<?php
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $newpassword=md5($_POST['userpassword']);  
  $link = mysqli_connect($servername,$username,$password);  
  if (!$link)                                                  //检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'shop_db');	                           //选择库
  $user_select="SELECT * FROM user WHERE user_id ='".$_POST['username']."'";    //在普通用户表中找到与输入用户名相同的信息，要取出两项
  $manager_select="SELECT * FROM manager WHERE manager_id ='".$_POST['username']."'";  //在管理员表中找到与输入用户名相同的信息，要取出两项
  $user_result=mysqli_query($link,$user_select);
  $manager_result=mysqli_query($link,$manager_select);
  if ($user_result==false||$manager_result==false)
    echo mysqli_error($link);	  
  $urow = mysqli_fetch_array($user_result);     //取出普通用户查询结果
  $mrow = mysqli_fetch_array($manager_result);  //取出管理员查询结果
  if($_POST['submit'])
  {      
    if($urow['user_id']==$_POST['username'] && $urow['user_password']==$newpassword)
	{  
        setcookie('user',$_POST['username'],time()+3600);  
        header('location:homepage.php');  
    }  
	else if($mrow['manager_id']==$_POST['username'] && $mrow['manager_password']==$newpassword)
	{
        setcookie('manager',$_POST['username'],time()+3600);  
        header('location:homepage.php');  		
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