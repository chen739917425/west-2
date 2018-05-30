<?php
$servername = "localhost";
$username = "root";
$password = "0424"; 
$link=mysqli_connect($servername,$username,$password);
if (!$link)                                                 // 检测连接
die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($link,'shop_db');                            //选择库
header("Content-Type: application/json; charset=utf-8");
$page = intval($_POST['pageNum']);
$sort = $_COOKIE['cmd_sort'];
$select="SELECT commodity_id FROM commodity WHERE commodity_sort='".$sort."'";
$result = mysqli_query($link,$select);
$total = mysqli_num_rows($result);//总记录数

$pageSize = 6; //每页显示数
$totalPage = ceil($total/$pageSize); //总页数

$startPage = $page*$pageSize;
$arr['total'] = $total;
$arr['pageSize'] = $pageSize;
$arr['totalPage'] = $totalPage;
$select="SELECT * FROM commodity WHERE commodity_sort='".$sort."' ORDER BY commodity_id ASC LIMIT ".$startPage.",".$pageSize;
$result = mysqli_query($link,$select);
while($row=mysqli_fetch_array($result))
{
	$arr['list'][] = array
	(
	 	'commodity_id' => $row['commodity_id'],
		'commodity_name' => $row['commodity_name'],
		'commodity_price' => $row['commodity_price'],
		'image_url' => $row['image_url']
	 );
}
echo json_encode($arr);
?>