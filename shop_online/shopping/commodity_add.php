<?php 
  $servername = "localhost";
  $username = "root";
  $password = "0424"; 
  $link=mysqli_connect($servername,$username,$password);
  if (!$link)                                                 // 检测连接
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'shop_db');                            //选择库
  if (!isset($_COOKIE['manager']))                                   
    header('location:login.html');                             //检验是否管理员
  if($_POST['submit'])
  {
    $name=$_POST[''];
	$price=$_POST[''];
	$describe=$_POST[''];
	$sort=$_POST[''];
	$url=$_POST[''];
	if (empty($name)||empty($price)||empty($sort))
	  echo '商品名、价格、分类不能为空';
    else
	{
		$allowExt=array('jpg','png','gif','webp');
		$temp=explode(".", $_FILES["file"]["name"]);                     // 以“.”分割文件名
		$ext=end($temp);                                                 // 获取文件后缀名
		if (
			(
			  ($_FILES["file"]["type"] == "image/gif")
			  ||($_FILES["file"]["type"] == "image/jpg")
			  ||($_FILES["file"]["type"] == "image/webp")
			  ||($_FILES["file"]["type"] == "image/png")
			  || ($_FILES["file"]["type"] == "image/jpeg")
			)
			  &&in_array($ext, $allowExt)
		   )
		{
		  if ($_FILES["file"]["error"] > 0)
		  {
			echo '错误：' . $_FILES["file"]["error"] . '<br>';
		  }
		  else
		  {
			if (file_exists("http://127.0.0.1/shop_online/commodity_picture/" . $_FILES["file"]["name"]))
			{
				echo $_FILES["file"]["name"] . '该商品图片已存在.';
			}
			else
			{
				$url="http://127.0.0.1/shop_online/commodity_picture/".$_FILES["file"]["name"];
				$insert="INSERT INTO commodity (commodity_name,commodity_price,commodity_sort,commodity_describe,image_url) VALUES ('".$name."','".$price."','".$sort."','".$describe."','".$url."')";
				if(mysqli_query($link,$insert))
				{
					move_uploaded_file($_FILES["file"]["tmp_name"], 'http://127.0.0.1/shop_online/commodity_picture/' . $_FILES["file"]["name"]);
					echo '商品添加成功'.'<br>';
					echo '<a href="commodity_add.html">返回商品添加页面</a>'.'<br>';
					echo '<a href="commodity_show.php">浏览商城</a>';
				}
				else
				{
					echo '商品添加失败，请重试：'.mysqli_error($link);
				}
			}
		  }		
		}	
	    else
	    {
		   echo "非法的文件格式";
	    }      			
	}	
?>
