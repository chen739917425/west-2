<?php
$servername = "localhost";
$username = "root";
$password = "0424";
$link = mysqli_connect($servername, $username, $password);  // 创建连接
if (!$link)                                                 // 检测连接
    die('Connection failed: '. mysqli_connect_error());
echo '连接成功';
$create='CREATE DATABASE commodity_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysqli_query($link,$create))      //创建并检测库，设置编码格式
	echo '创建库成功';
else
	echo '创建库失败'.mysqli_error($link);
mysqli_select_db($link,'commodity_db');                            //选择库
//建普通用户表
$create_usertable='CREATE TABLE user_table                               
(
    user_id varchar(40) NOT NULL,
	user_password varchar(40) NOT NULL,
	PRIMARY KEY (user_id)
)';                                                          //创建并检测表
if (mysqli_query($link,$create_usertable))                              
    echo '创建普通用户账号表成功';
else
	echo '创建普通用户账号表失败'.mysqli_error($link);
//建管理员表
$create_managertable='CREATE TABLE manager_table                          
(
    manager_id varchar(40) NOT NULL,
	manager_password varchar(40) NOT NULL,
	PRIMARY KEY (manager_id)
)';                                                         
if (mysqli_query($link,$create_managertable))                              
    echo '创建管理员账户表成功';
else
	echo '创建管理员账户表失败'.mysqli_error($link);
//建商品信息表
$create_commoditytable='CREATE TABLE commodity_table                          
(
    commodity_id varchar(40) NOT NULL,
	commodity_describe varchar(120),
	image_url varchar(120),
    PRIMARY KEY (commodity_id)	
)';                                                         
if (mysqli_query($link,$create_commoditytable))                              
    echo '创建管理员账户表成功';
else
	echo '创建管理员账户表失败'.mysqli_error($link);
mysqli_close($link);
?>