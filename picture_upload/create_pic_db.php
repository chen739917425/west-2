<?php
$servername = "localhost";
$username = "root";
$password = "0424";
$link = mysqli_connect($servername, $username, $password);  // 创建连接
if (!$link)                                                 // 检测连接
    die("Connection failed: " . mysqli_connect_error());
echo "连接成功";
if (mysqli_query($link,"CREATE DATABASE pic_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;"))      //创建并检测库，设置编码格式
	echo "创建库成功";
else
	echo "创建库失败".mysqli_error($link);
mysqli_select_db($link,"pic_db");                            //选择库
$p_table="CREATE TABLE pic_table
(
   images_id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
   images_name varchar(100) NOT NULL,
   images_url varchar(100) NOT NULL
)";
if(mysqli_query($link,$p_table))
	echo'创建图片表成功';
else
	echo'创建图片表失败'.mysqli_error($link);
?>