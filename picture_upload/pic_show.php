<html>
  <head>
    <meta charset="utf-8">
	<title>图片总览</title>
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
      <img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1515425731&di=31eea8ebfa34b24211945cc30bd78289&imgtype=jpg&er=1&src=http%3A%2F%2Fpic.58pic.com%2F58pic%2F15%2F15%2F34%2F39i58PICUkF_1024.jpg" width="100%" height="100%"/>
    </div>
    <h1>图片浏览</h1>	
    <?php
	  $servername = "localhost";                                  
      $username = "root";
      $password = "0424";
      $link = mysqli_connect($servername, $username, $password);  
      if (!$link)                                                 
        die("Connection failed: " . mysqli_connect_error());
      mysqli_select_db($link,'pic_db');
	  $select='SELECT * FROM pic_table order by images_id desc';
	  $res=mysqli_query($link,$select);
	  echo '<table border="1" width="700px" align="center">';
	  echo '<tr>'.'<th>'.'上传顺序'.'</th>'.'<th>'.'图片名称'.'</th>'.'<th>'.'操作'.'</th>'.'</tr>';
	  while ($row=mysqli_fetch_array($res,MYSQLI_BOTH))
	  {
		echo '<tr>'.'<th>'.$row['images_id'].'</th>'.'<th>'.$row['images_name'].'</th>'.'<th>';
		echo "<a href=".$row['images_url'].">查看</a>";	
		echo '</th></tr>';
	  }
	?>
  </body>
</html>  