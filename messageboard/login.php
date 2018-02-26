<html>
  <head>
    <meta charset=UTF-8>
    <title>用户登录</title>
  </head>
  <style type ="text/css">
    .b_style
	{
		text-align:center;
		background-color:#DFFFDF;
		font-weight:bold;
		font-size:20px;
	}
	.t_style
	{
		font-weight:bold;
		font-size:40px;
	}
  </style>	
  <body class="b_style">
    <h1 class="t_style"> 用户登录 </h1>  
    <form action="logincheck.php" method="post">  
      用户名：<input type="text" name="username" >  
      <br/>  
      密码：<input type="password" name="userpassword" >  
      <br/>  
      <input type="submit" name="submit" value="登录" >
      &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
      <a href="register.php"><span class="b_style">注册</span></a>  
    </form>
  </body>	
</html>