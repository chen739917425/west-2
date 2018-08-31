<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    $db = new DiaryDatabase('localhost', 'root', '0424');
    $obj = RestUtils :: processRequest();
    switch ($obj->getMethod()){
        case 'post':
            $data = $obj->getData();
            $token = $data['token'];
            $url = 'http://localhost/verify_token.php';
            $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
            if (!$tmp['status']){
                echo "<script> alert('身份验证失败，请重试!');</script>";
                exit(0);
            }
            $title = $data[''];
            $content = $data[''];
            $bookId = $data[''];
            $diaryImg = "http://127.0.0.1/Time_pill/DiaryImg/". $_FILES["file"]["name"];
            $createTime = date('Y-m-d H:i:s', time());
            if (!$db->insertDiary($createTime, $title, $content, $diaryImg, $bookId))
                echo "<script> alert('新建日记失败，请重试!');</script>";
            else if (!move_uploaded_file($_FILES["file"]["tmp_name"], 'DiaryImg/' . $_FILES["file"]["name"]))
                echo "<script> alert('图片上传失败，请重试!');</script>";
            break;
        case 'get':
            $data = $obj->getData();
            $token = $data['token'];
            $url = 'http://localhost/verify_token.php';
            $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
            if (!$tmp['status']){
                echo "<script> alert('身份验证失败，请重试!');</script>";
                exit(0);
            } 
            $bookId = $data[''];
            $result = $db->queryDiary($bookId);
            if (!$result)
                exit(0);
            while ($row = mysqli_fetch_array($result)){
                $list[] = array
                (
                    'diaryId' => $row['id'],
                    'diaryName' => $row['title'],
                    'diaryContent' => $row['content'],
                    'diaryImg' => $row['img_url']
                );
            }
            RestUtils :: sendResponse(200, json_encode($list), 'application/json');
            break;
    }
?>
        