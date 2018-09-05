<?php
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');
    include 'DiaryDB.php';
    include 'RESTful.php';
    $db = new DiaryDatabase('localhost', 'root', 'root');
    $obj = RestUtils :: processRequest();
    $data = $obj->getData();
    $url = 'http://59.77.134.23:5000/verify_token';
    $success = json_encode(array('status'=>TRUE));
    $fail = json_encode(array('status'=>FALSE));
    switch ($data['op']){
        case 'post':
            $token = json_encode(array('token'=>$data['token']));
            $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
            $status = $tmp['status'];
            if (!$status){
                echo $fail;
                exit(0);
            }
            $userId = $tmp['userId'];
            $openTime = $data['endTime'];
            $bookName = htmlspecialchars($data['subject']);
            $bookBrief = htmlspecialchars($data['description']);
            if ($db->insertBook($openTime, $bookBrief, $bookName, $userId))
                echo $success;
            else
                echo $fail;
            break;
        case 'get':
            $token = json_encode(array('token'=>$data['token']));
            $tmp = json_decode(RestUtils :: postData($token, $url), TRUE);
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
            $s=json_encode((object)$list);
            RestUtils :: sendResponse(200, $s, 'application/json');
            break;
    }
?>