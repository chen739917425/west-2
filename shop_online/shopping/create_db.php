<?php
$servername = "localhost";
$username = "root";
$password = "0424";
$link = mysqli_connect($servername, $username, $password);  // 创建连接
if (!$link)                                                 // 检测连接
    die('Connection failed: '. mysqli_connect_error());
echo '连接成功';
$create='CREATE DATABASE shop_db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
if (mysqli_query($link,$create))      //创建并检测库，设置编码格式
	echo '创建库成功';
else
	echo '创建库失败'.mysqli_error($link);
mysqli_select_db($link,'shop_db');                            //选择库
//建普通用户表
$create_usertable='CREATE TABLE user                               
(
    user_id varchar(40) NOT NULL,
	user_password varchar(40) NOT NULL,
	PRIMARY KEY (user_id)
)';                                                          
if (mysqli_query($link,$create_usertable))                              
    echo '创建普通用户账号表成功';
else
	echo '创建普通用户账号表失败'.mysqli_error($link);
//建管理员表
$create_managertable='CREATE TABLE manager                         
(
    manager_id varchar(40) NOT NULL,
	manager_password varchar(40) NOT NULL,
	PRIMARY KEY (manager_id)
)';                                                         
if (mysqli_query($link,$create_managertable))                              
    echo '创建管理员账户表成功';
else
	echo '创建管理员账户表失败'.mysqli_error($link);
//建商品信息表(id,商品名，种类，价格，描述，图片)
$create_commoditytable='CREATE TABLE commodity                          
(
    commodity_id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	commodity_name varchar(20) NOT NULL, 
	commodity_sort varchar(40) NOT NULL,
	commodity_price decimal(10,2) NOT NULL,
	commodity_describe varchar(120),
	image_url varchar(120) 	NOT NULL
)';                                                         
if (mysqli_query($link,$create_commoditytable))                              
    echo '创建商品表成功';
else
	echo '创建商品表失败'.mysqli_error($link);
//建购物车表(用户id作为外键，商品ID，商品名)
$create_shopcart='CREATE TABLE shopcart
(
    cart_id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    pur_id varchar(40) NOT NULL,
	cmd_id int(10) NOT NULL,
    cmd_name varchar(40) NOT NULL
)';
if (mysqli_query($link,$create_shopcart))                              
    echo '创建购物车表成功';
else
	echo '创建购物车表失败'.mysqli_error($link);
mysqli_close($link);
?>