<?php
    header('Access-Control-Allow-Origin:*');// 指定允许其他域名访问
    header('Access-Control-Allow-Methods:POST');// 响应类型
    header('Access-Control-Allow-Headers:x-requested-with,content-type');// 响应头设置
    date_default_timezone_set('PRC');
    $verify_url = 'http://192.168.123.57:5000/verify_token';
    $info_url = 'http://192.168.123.57:5000/get_user_info';
    $success = json_encode(array('status'=>TRUE));
    $fail = json_encode(array('status'=>FALSE));
?>