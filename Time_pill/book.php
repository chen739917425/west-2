<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    $db = new DiaryDatabase('localhost', 'root', '0424');  
    $obj = RestUtils :: processRequest();
    switch ($obj->getMethod()){
        case 'get':
            $data = $obj->getData();
            $openTime = $data[''];
            $bookName = $data[''];
            $userId = $data[''];
            if ($db->insertBook($openTime, $bookName, $userId))
                echo "<script> window.location.href=' .html';</script>";
            else
                echo "<script> alert('新建日记本失败，请重试!');window.location.href=' .html';</script>";            
            break;
        case 'post':

            break;
    }
?>