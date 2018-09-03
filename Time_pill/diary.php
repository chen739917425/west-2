<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    function Img_check($imgName){
        $allowExt=array('jpg','png','gif','webp');
        $temp=explode(".", $_FILES["file"]["name"]);                     // 以“.”分割文件名
        $ext=end($temp);                                                 // 获取文件后缀名
        if ((
                ($_FILES["file"]["type"] == "image/gif")
                ||($_FILES["file"]["type"] == "image/jpg")
                ||($_FILES["file"]["type"] == "image/webp")
                ||($_FILES["file"]["type"] == "image/png")
                || ($_FILES["file"]["type"] == "image/jpeg")
            )
            &&in_array($ext, $allowExt)
        ){
            if ($_FILES["file"]["error"] > 0){
                echo '错误：' . $_FILES["file"]["error"] . '<br>';
            }else{
                if (file_exists("upload/" . $_FILES["file"]["name"])){
                    echo $_FILES["file"]["name"] . '文件已上传.';
                }else{
                    $url="http://127.0.0.1/upload/".$_FILES["file"]["name"];
                    $insert="INSERT INTO pic_table (images_name,images_url) VALUES('".$_FILES["file"]["name"]."','".$url."')";
                    if(mysqli_query($link,$insert)){
                        move_uploaded_file($_FILES["file"]["tmp_name"], 'upload/' . $_FILES["file"]["name"]);
                        echo '上传成功'.'<br>';
                        echo '<a href="pic_upload.html">返回上传页面</a>'.'<br>';
                        echo '<a href="pic_show.php">浏览已上传图片</a>';
                    }else
                        return FALSE;
                }
            }		
        }else
            return FALSE;
    }
    $db = new DiaryDatabase('localhost', 'root', '0424');
    $obj = RestUtils :: processRequest();
    switch ($obj->getMethod()){
        case 'post':
            $data = $obj->getData();
            /*$token = $data['token'];
            $url = 'http://localhost/verify_token.php';
            $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
            $status = $tmp['status'];
            if (!$status){
                echo $status;
                exit(0);
            }*/
            $title = $data['title'];
            $content = $data['content'];
            $bookId = $data['bookId'];
            $diaryImg = "http://127.0.0.1/Time_pill/DiaryImg/". $_FILES["file"]["name"];
            $createTime = date('Y-m-d H:i:s', time());
            if (!$db->insertDiary($createTime, $title, $content, $diaryImg, $bookId))
                echo "<script> alert('新建日记失败，请重试!');</script>";
            else if (!move_uploaded_file($_FILES["file"]["tmp_name"], 'DiaryImg/' . $_FILES["file"]["name"]))
                echo "<script> alert('图片上传失败，请重试!');</script>";
            break;
        case 'get':
            $data = $obj->getData();
            if ($data['is_login']==FALSE){
                $result = $db->queryDiary();
                if (!result)
                    exit(0);
                while ($row = mysqli_fetch_array($result)){
                    $list[] = array
                    (
                        'userName' => $row['user_id'],
                        'diaryId' => $row['id'],
                        'diaryName' => $row['title'],
                        'diaryContent' => $row['content'],
                        'diaryImg' => $row['img_url']
                    );
                }               
            }else{
                /*$token = $data['token'];
                $url = 'http://localhost/verify_token.php';
                $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
                $status = $tmp['status'];
                if (!$status){
                    echo $status;
                    exit(0);
                }*/
                $bookId = $data['bookId'];
                $result = $db->queryDiary($bookId);
                if (!$result)
                    exit(0);
                while ($row = mysqli_fetch_array($result)){
                    $list[] = array
                    (
                        'userName' => $row['user_id'],
                        'diaryId' => $row['id'],
                        'diaryName' => $row['title'],
                        'diaryContent' => $row['content'],
                        'diaryImg' => $row['img_url']
                    );
                }
            }
            RestUtils :: sendResponse(200, json_encode($list), 'application/json');
            break;
    }
?>
        