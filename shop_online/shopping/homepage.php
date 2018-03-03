<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商城首页</title>
<style>
* {
	margin: 0;
	padding: 0;
	
}
	body{
		position: relative;
		background-color:rgb(246,246,246);
	}
</style>
<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div id="front" style="width: 100%;background-color: rgba(243,215,161,0.55);height: 65px;border-bottom-style:solid;border-bottom-color: rgba(255,184,0,0.3)"> 
<span style="color: rgba(232,113,35,1.00);font-size: 30px;font-family:微软雅黑;line-height: 65px;">Online Shopping.</span> 
</div>
<div id="ShowIdPart" style="font-size: 14px;color: orange;float: right; margin-right: 10px;margin-top: 6px;"><img src="account.png" alt="" width="20px"/>
<span>
<?php
if (isset($_COOKIE['user']))
	echo $_COOKIE['user'];
else if (isset($_COOKIE['manager']))
	echo $_COOKIE['manager'];
else
	echo '<a href ="login.html">登录</a>';
?>
</span>

<?php
if (isset($_COOKIE['user'])||isset($_COOKIE['manager']))
    echo '<a style="font-size: 14px;color: orange;" href="logout.php">注销</a>';
?>

<span>  |  </span>

<?php
if (isset($_COOKIE['user']))
    echo '<a href="shopcart.php" style="font-size: 14px;color: orange;"><img src="cart.png" alt="" width="20px">购物车</a>';
?>

<?php
if (isset($_COOKIE['manager']))
	echo '<a href="commodity_add.html" style="font-size: 14px;color: orange;"><img src="cart.png" alt="" width="20px">添加商品</a>';
?>
</div>
<div id="DivKinds" style="margin: 40px;"><!--分类导航-->
	<span style="color: rgba(232,113,35,1.00);font-size: 30px;font-family:微软雅黑;">分类导航</span>
	<div>
	<a href="commodity_show.php?sort='服装'" target="KindsFrame" style="font-size: 20px;padding-right: 10px; color: rgba(246,153,26,0.91)">服装</a>
	<a href="commodity_show.php?sort='食品'" target="KindsFrame" style="font-size: 20px;padding-right: 10px; color: rgba(246,153,26,0.91)">食品</a>
	<a href="commodity_show.php?sort='娱乐'" target="KindsFrame" style="font-size: 20px;padding-right: 10px; color: rgba(246,153,26,0.91)">娱乐</a>
	<a href="commodity_show.php?sort='办公用品'" target="KindsFrame" style="font-size: 20px;padding-right: 10px; color: rgba(246,153,26,0.91)">办公</a>
	</div>
	<iframe name="KindsFrame" frameborder="0" width="100%" height="500px"></iframe>
</div>

</body>
</html>
