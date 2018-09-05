<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    $db = new DiaryDatabase('localhost', 'root', 'root');
    $obj = RestUtils:: processRequest();
    $data = $obj->getData();
    $verify_url = 'http://59.77.134.23:5000/verify_token';
    $info_url = 'http://59.77.134.23:5000/get_user_info';
    $success = json_encode(array('status' => TRUE));
    $fail = json_encode(array('status' => FALSE));
    switch ($data['op']) {
        case 'post':
            $token = json_encode(array('token' => $data['token']));
            $tmp = json_decode(RestUtils:: postData($token, $verify_url), TRUE);
            $status = $tmp['status'];
            if (!$status) {
                echo $fail;
                exit(0);
            }
            $user_id = $tmp['userId'];
            $content = htmlspecialchars($data['diaryContent']);
            $bookId = $data['bookId'];
            $bookName = $data['bookName'];
            if ($data['diaryImg'] != '') {
                $img = explode(',', $data['diaryImg']);     //截取data:image/png;base64, 这个逗号后的字符
                $data = base64_decode($img[1]);                      //对截取后的字符使用base64_decode进行解码
                $serUrl='http://59.77.134.34:80/';
                $diaryImg = 'DiaryImg/' . guid() . '.jpg';
                file_put_contents($diaryImg, $data);                 //写入文件并保存
                $createTime = time();
                if ($db->insertDiary($createTime, $content, $serUrl.$diaryImg, $bookId, $bookName, $user_id))
                    echo $success;
            } else {
                $diaryImg = '';
                $createTime = time();
                if ($db->insertDiary($createTime, $content, $diaryImg, $bookId, $bookName, $user_id))
                    echo $success;
                else
                    echo $fail;
            }
            break;
        case 'getIndex':
            $result = $db->queryDiary();
            if (!$result) {
                echo $fail;
                exit(0);
            }
            while ($row = mysqli_fetch_array($result)) {
                $user_id = json_encode((object)array('userId' => $row['user_id']));
                $info = json_decode(RestUtils:: postData($user_id, $info_url), TRUE);
                $list[] = (object)array
                (
                    'userName' => $info['userName'],
                    'userHead' => $info['headImageURL'],
                    'createTime' => $row['gmt_create'],
                    'diaryId' => $row['id'],
                    'diaryContent' => $row['content'],
                    'diaryImg' => $row['img_url']
                );
            }
            RestUtils:: sendResponse(200, json_encode($list), 'application/json');
            break;
        case 'get':
            $token = json_encode(array('token' => $data['token']));
            $tmp = json_decode(RestUtils:: postData($token, $verify_url), TRUE);
            $status = $tmp['status'];
            if (!$status) {
                echo $fail;
                exit(0);
            }
            $bookId = $data['bookId'];
            $result = $db->queryDiary($bookId);
            if (!$result) {
                echo $fail;
                exit(0);
            }
            $list =array();
            while ($row = mysqli_fetch_array($result)) {
                $list[] = array
                (
                    'diaryId' => $row['id'],
                    'diaryContent' => $row['content'],
                    'diaryImg' => $row['img_url'],
                    'createTime' => $row['gmt_create']
                );
            }
            $bookName=$db->getBookName($bookId);
            RestUtils:: sendResponse(200, json_encode((object)array('bookName' => $bookName,'diaryList' => $list)), 'application/json');
            break;
    }
?>
        