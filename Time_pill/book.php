<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
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
            }
            $userId = $tmp['userName'];*/
            $openTime = $data['endTime'];
            $bookName = $data['diaryName'];
            if (!$db->insertBook($openTime, $bookName, $userId))
                echo "<script> alert('新建日记本失败，请重试!');</script>";
            break;
        case 'get':
            $data = $obj->getData();
            /*$token = $data['token'];
            $url = 'http://localhost/verify_token.php';
            $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
            $status = $tmp['status'];
            if (!$status){
                echo $status;
                exit(0);
            }
            $userId = $tmp['userName'];*/
            $result = $db->queryBook($userId);
            if (!$result)
                exit(0);
            while ($row = mysqli_fetch_array($result)){
                $list[] = array 
                (
                    'bookName' => $row['book_name'],
                    'bookId' => $row['id']
                );
            }
            RestUtils :: sendResponse(200, json_encode($list), 'application/json');
            break;
    }
?>