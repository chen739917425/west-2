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
	$cmd_id=$_SESSION['cmd_id'];
    unset($_SESSION['cmd_id']);	
    $name=$_POST['commodity_name'];
	$price=$_POST['commodity_price'];
	$describe=$_POST['commodity_describe'];
	$sort=$_POST['commodity_sort'];
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
				$update="UPDATE commodity SET commodity_name='".$name."',commodity_price=".$price.",commodity_sort='".$sort."',image_url='".$url."',commodity_describe='".$describe."' WHERE commodity_id=".$cmd_id;
				if(mysqli_query($link,$insert))
				{
					move_uploaded_file($_FILES["file"]["tmp_name"], 'http://127.0.0.1/shop_online/commodity_picture/' . $_FILES["file"]["name"]);
					header('location:commodity_show.php');
				}
				else
				{
					echo '商品信息修改失败，请重试：'.mysqli_error($link);
					echo '<a href="homepage.php">返回商城</a>';
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
