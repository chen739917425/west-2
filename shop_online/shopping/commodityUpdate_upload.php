<?php
setcookie('cmd_id',$_GET['c_id'],time()+600);
?>
<html>
  <head>
    <meta charset="utf-8">
	<title>商品信息修改</title>
  </head>
  <style type ="text/css">
    .h_style
	{
		font-weight:bold;
		font-size:14px;
	}
  </style>	
  <body class="h_style">
    <div style="position:fixed; left:0px; top:0px; width:100%;height:100%;z-index:-1">       
      <img src="background.jpg" width="100%" height="100%"/>
    </div>  
    <h1>修改商品信息（商品图片仅支持“.jpg”、“.png”、“.gif”、“.webp”格式）</h1>
	<form action="commodity_update.php" method="post" enctype="multipart/form-data">
	  <label>商品名</label>
	  <input type="text" name="commodity_name">
	  <br/>
	  <laber>价格(单位￥)</label>
	  <input type="text" name="commodity_price">
	  <br/>
	  <label>种类</label>
		<select name="commodity_sort">
		<option value="服装">服装</option>
		<option value="食品">食品</option>
		<option value="娱乐">娱乐</option>
		<option value="办公用品">办公用品</option>
		</select>
	  <br/>
	  <label>商品描述</label>
	  <br/>
	  <textarea cols="30" rows="5" name="commodity_describe"></textarea>(不超过120字)
	  <br/>
	  <label for="file">请选择图片</label>
	  <br/>
	  <input type="file" name="file" id="file">
	  <br><br>
	  <input type="submit" name="submit" value="提交">
	</form>  
	<a href='commodity_show.php?sort=服装'>返回商城</a>
  </body>  
<html>  