<?php
  $servername = "localhost";                                  
  $username = "root";
  $password = "0424";
  $link = mysqli_connect($servername, $username, $password);  
  if (!$link)                                                 
    die("Connection failed: " . mysqli_connect_error());
  mysqli_select_db($link,'pic_db');                         
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
		if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
            echo $_FILES["file"]["name"] . '文件已上传.';
        }
        else
        {
			$url="http://127.0.0.1/upload/".$_FILES["file"]["name"];
			$insert="INSERT INTO pic_table (images_name,images_url) VALUES('".$_FILES["file"]["name"]."','".$url."')";
			if(mysqli_query($link,$insert))
			{
				move_uploaded_file($_FILES["file"]["tmp_name"], 'upload/' . $_FILES["file"]["name"]);
			    echo '上传成功'.'<br>';
			    echo '<a href="pic_upload.html">返回上传页面</a>'.'<br>';
			    echo '<a href="pic_show.php">浏览已上传图片</a>';
			}
            else
			{
				echo '上传失败，请重试：'.mysqli_error($link);
			}
        }
	}		
  }	
  else
  {
    echo "非法的文件格式";
  }  
?>