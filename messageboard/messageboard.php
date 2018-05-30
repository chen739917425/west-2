<html>
  <head>
    <meta charset=UTF-8>
    <title>发表留言</title>
  </head>
  <style type ="text/css">
    .b_style
	{
		text-align:center;
		font-weight:bold;
		font-size:20px;
	}
	.t_style
	{
		font-weight:bold;
		font-size:40px;
	}
	.error
	{
		color:red;
	}
  </style>	
  <body class='b_style'>
    <div style="position:fixed; left:0px; top:0px; width:100%;height:100%;z-index:-1">       
      <img src="http://img4.imgtn.bdimg.com/it/u=3055598097,3360735557&fm=27&gp=0.jpg" width="100%" height="100%"/>
    </div>  
    <h1 class="t_style">留言板</h1>                             
	<?php
	$servername = "localhost";                                  
    $username = "root";
    $password = "0424";
	$p="";
    $link = mysqli_connect($servername, $username, $password);  // 创建连接
    if (!$link)                                                 // 检测连接
        die("Connection failed: " . mysqli_connect_error());
	mysqli_select_db($link,'my_db');                            // 选择库
	if (!isset($_COOKIE['uname']))                                   
      header('location:login.php');                             //检验是否已登录过
    $select='SELECT * FROM messageboard';	
	$result=mysqli_query($link,$select);                        //查询留言信息
	echo '<table border="1" width="700px" align="center">';
	echo '<tr>'.'<th>'.'留言者'.'</th>'.'<th>'.'内容'.'</th>'.'<th>'.'操作'.'</th>'.'</tr>';
	while ($row=mysqli_fetch_array($result))
	{
		echo '<tr>'.'<th>'.$row['author'].'</th>'.'<th>'.$row['message'].'</th>'.'<th>';
		if ($_COOKIE['uname']==$row['author'])
		{
			echo '<a href="delmessage.php?cont='.$row['message'].'">删除</a>';
		}			
		echo '</th></tr>';
	}
    ?>
	<h2> 发布留言 </h2>	
	<form action="addmessage.php" method="post">                                                     
      留言内容：<textarea cols="30" rows="5" name="content"></textarea>(不超过120字)  
      <br/>  
      <input type="submit" name="submit" value="发表" > 
    </form>
  </body>
</html>