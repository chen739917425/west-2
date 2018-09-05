<?php
    include 'DiaryDB.php';
    include 'RESTful.php';
    include 'config.php';
    $db = new DiaryDatabase('localhost', 'root', 'root');
    $obj = RestUtils:: processRequest();
    $data = $obj->getData();
    switch ($data['op']) {
        case 'post':
            $token = (object)array('token'=>$data['token']);
            $tmp = json_decode(RestUtils:: http_request($verify_url, $token), TRUE);
            $status = $tmp['status'];
            if (!$status) {
                echo $fail;
                exit(0);
            }
            $user_id = $tmp['userId'];
            $content = addslashes(htmlspecialchars($data['diaryContent']));
            $bookId = $data['bookId'];
            $bookName = $data['bookName'];
            if ($data['diaryImg'] != '') {
                $img = explode(',', $data['diaryImg']);     //截取data:image/png;base64, 这个逗号后的字符
                $data = base64_decode($img[1]);                      //对截取后的字符使用base64_decode进行解码
                $setUrl = 'http://192.168.123.23/';
                $diaryImg = 'DiaryImg/' . guid() . '.jpg';
                file_put_contents($diaryImg, $data);                 //写入文件并保存
                $createTime = time();
                if ($db->insertDiary($createTime, $content, $setUrl.$diaryImg, $bookId, $bookName, $user_id))
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
            $list = array();
            while ($row = mysqli_fetch_array($result)) {
                $user_id = json_encode((object)array('userId' => $row['user_id']));
                $info = json_decode(RestUtils:: http_request($user_id, $info_url), TRUE);
                $list[] = (object)array
                (
                    'userName' => $info['userName'],
                    'userHead' => $info['headImageURL'],
                    'createTime' => $row['gmt_create'],
                    'bookName' => $row['book_name'],
                    'diaryId' => $row['id'],
                    'diaryContent' => $row['content'],
                    'diaryImg' => $row['img_url']
                );
            }
            RestUtils:: sendResponse(200, json_encode($list), 'application/json');
            break;
        case 'get':
            $token = (object)array('token'=>$data['token']);
            $tmp = json_decode(RestUtils:: http_request($verify_url, $token), TRUE);
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
        