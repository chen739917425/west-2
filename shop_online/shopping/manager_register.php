<html>
  <head>
    <meta charset=UTF-8>
    <title>管理员注册</title>
  </head>
  <style type ="text/css">
    .b_style
	{
		text-align:center;
		background-color:#DFFFDF;
		font-weight:bold;
		font-size:15px;
	}
	.t_style
	{
		font-weight:bold;
		font-size:35px;
	}
	.error
	{
		color:red;
	}
  </style>	
  <body class="b_style">
  <?php
    $nameErr = $passwordErr = $a_passwordErr = "";
	$servername = "localhost";
    $username = "root";
    $password = "0424";
    $link = mysqli_connect($servername, $username, $password);  // 创建连接
    if (!$link)                                                 // 检测连接
        die("Connection failed: " . mysqli_connect_error());
    mysqli_select_db($link,'shop_db');                            //选择库		
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{			
			if (empty($_POST["username"]))
				$nameErr="账号不能为空";
            else if (!preg_match("/^[a-zA-Z0-9]+$/",$_POST["username"]))
                $nameErr="非法账号格式";				
            else if (empty($_POST["password"]))
                $passwordErr="密码不能为空";
            else if (empty($_POST["a_password"])||$_POST["password"]!=$_POST["a_password"])
                $a_passwordErr="两次密码不一致";
			else
			{
				$select="SELECT manager_id FROM manager WHERE manager_id=".$_POST['username'];    //检测用户名是否已存在
				$result = mysqli_query($link,$select);
				if (mysqli_num_rows($result)>0)
					$nameErr="用户名已存在";
				else
				{
					$new_pass=md5($_POST["password"]);
					mysqli_select_db($link,'shop_db');
					$insert="INSERT INTO manager (manager_id,manager_password) VALUES ('".$_POST['username']."','".$new_pass."')";
					if (mysqli_query($link,$insert))
					{
						echo '注册成功';
                    }
                    else
                        echo '注册失败，请重试：'.mysqli_error($link);						
				}	
			}	
			    
	}	
  ?>
    <h1 class="t_style"> 管理员注册 </h1>  
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">  
      用户名：<input type="text" name="username" >
	  <span class="error">*由字母和数字组成</span>
	  <br/>
	  <span class="error"><?php echo $nameErr ?></span>
      <br/>  
      密码：<input type="password" name="password" >
	  <span class="error">*由字母，数字和符号组成</span>
	  <br/>
      <span class="error"><?php echo $passwordErr ?></span>	  
      <br/> 
	  再次确认密码：<input type="password" name="a_password" >
	  <span class="error">*再次输入以确认</span>
	  <br/>
      <span class="error"><?php echo $a_passwordErr ?></span>	  
      <br/><br/>  
      <input type="submit" name="submit" value="注册" >
	  <br/><br/>
	  <a href="login.php"><span class="b_style">返回登录界面</span></a> 
    </form>
  </body>	
</html>