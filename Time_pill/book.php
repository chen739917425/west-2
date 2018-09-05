<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    include 'config.php';
    $db = new DiaryDatabase('localhost', 'root', 'root');
    $obj = RestUtils :: processRequest();
    $data = $obj->getData();
    switch ($data['op']){
        case 'post':
            $token = (object)array('token'=>$data['token']);
            $tmp = json_decode(RestUtils :: http_request($verify_url, $token), TRUE);
            $status = $tmp['status'];
            if (!$status){
                echo $fail;
                exit(0);
            }
            $userId = $tmp['userId'];
            $openTime = $data['endTime'];
            $bookName = addslashes(htmlspecialchars($data['subject']));
            $bookBrief = addslashes(htmlspecialchars($data['description']));
            if ($db->insertBook($openTime, $bookBrief, $bookName, $userId))
                echo $success;
            else
                echo $fail;
            break;
        case 'get':
            $token = (object)array('token'=>$data['token']);
            $tmp = json_decode(RestUtils :: http_request($verify_url, $token), TRUE);
            $status = $tmp['status'];
            if (!$status){
                echo $fail;
                exit(0);
            }
            $userId = $tmp['userId'];
            $result = $db->queryBook($userId);
            if ($result==FALSE){
                echo $fail;
                exit(0);
            }
            $list = array();
            while ($row = mysqli_fetch_array($result)){
                $list[] = array
                (
                    'bookName' => $row['book_name'],
                    'description' => $row['book_brief'],
                    'beginTime' => $row['gmt_create'],
                    'endTime' => $row['gmt_open'],
                    'bookId' => $row['id']
                );
            }
            RestUtils :: sendResponse(200, json_encode((object)$list), 'application/json');
            break;
    }
?>