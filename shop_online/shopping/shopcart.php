<?php
$servername = "localhost";                                  
$username = "root";
$password = "0424";
$link = mysqli_connect($servername, $username, $password);  
if (!$link)                                                 
die("Connection failed: " . mysqli_connect_error());
mysqli_select_db($link,'shop_db');
if (!isset($_COOKIE['user']))
	header('location:login.html');
?>
<html>
  <head>
    <meta charset="utf-8">
	<title>购物车</title>
  </head>
  <style type ="text/css">
    .h_style
	{
		text-align:center;
		font-weight:bold;
		font-size:16px;
	}
  </style>	
  <body class="h_style">
    <div style="position:fixed; left:0px; top:0px; width:100%;height:100%;z-index:-1">       
      <img src="background.jpg" width="100%" height="100%"/>
    </div>
    <h1>购物车中商品</h1>	
      <?php
	  $select="SELECT * FROM shopcart WHERE pur_id ='".$_COOKIE['user']."'";
	  $result=mysqli_query($link,$select);
	  echo '<table border="1" width="700px" align="center">';
	  echo '<tr>'.'<th>'.'商品名'.'</th>'.'<th>'.'商品详情'.'</th>'.'<th>'.'操作'.'</th>'.'</tr>';
	  while ($row=mysqli_fetch_array($result))
	  {
		echo '<tr>'.'<th>'.$row['cmd_name'].'</th>'.'<th>';
		echo '<a href="commodity_detail.php?cmd_id='.$row['cmd_id'].'">查看</a>'.'</th>'.'<th>';
        echo '<a href="shopcart_delete.php?cart_id='.$row['cart_id'].'">删除</a>';		
		echo '</th></tr>';
	  }
	  ?>
  </body>
</html>  