<?php
$servername = "localhost";
$username = "root";
$password = "0424";
$link = mysqli_connect($servername, $username, $password);  // 创建连接
if (!$link)                                                 // 检测连接
    die("Connection failed: " . mysqli_connect_error());
echo "连接成功";
if (mysqli_query($link,"CREATE DATABASE my_db0 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;"))      //创建并检测库，设置编码格式
	echo "创建库成功";
else
	echo "创建库失败".mysqli_error($link);
mysqli_select_db($link,"my_db0");                            //选择库
$sql_g="CREATE TABLE my_guest                               
(
    user_id varchar(40) NOT NULL,
	user_password varchar(40) NOT NULL,
	PRIMARY KEY (user_id)
)";                                                          //创建并检测表
if (mysqli_query($link,$sql_g))                              
    echo "创建账号表成功";
else
	echo "创建账号表失败".mysqli_error($link);
$sql_m="CREATE TABLE messageboard                          
(
    author varchar(20) NOT NULL,
	message varchar(120) NOT NULL
)";                                                         
if (mysqli_query($link,$sql_m))                              
    echo "创建留言表成功";
else
	echo "创建留言表失败".mysqli_error($link);
mysqli_close($link);
?>