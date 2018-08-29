<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    $db = new DiaryDatabase('localhost', 'root', '0424');
    $obj = RestUtils :: processRequest();
    switch ($obj->getMethod()){
        case 'get':
            $data = $obj->getData();
            $title = $data[''];
            $content = $data[''];
            $bookId = $data[''];
            $diaryImg = "http://127.0.0.1/Time_pill/DiaryImg/". $_FILES["file"]["name"];
            $createTime = date('Y-m-d H:i:s',time());
            if ($db->insertDiary($createTime, $title, $content, $diaryImg, $bookId)
                && move_uploaded_file($_FILES["file"]["tmp_name"], 'DiaryImg/' . $_FILES["file"]["name"]))
                echo "<script> window.location.href=' .html'; </script>";
            else
                echo "<script> alert('新建日记失败，请重试!');window.location.href=' .html';</script>";
            break;
        case 'post':
        
            break;
    }
?>
        