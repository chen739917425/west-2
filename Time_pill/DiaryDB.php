<?php
    date_default_timezone_set('PRC');
    function guid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid =
                substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
            return $uuid;
        }
    }
    class DiaryDatabase{
        private $serverName;
        private $userName;
        private $password;
        private $link;
        function __construct($serve,$user,$pwd){
            $this->serverName = $serve;
            $this->userName = $user;
            $this->password = $pwd;
            $this->link = mysqli_connect($this->serverName, $this->userName, $this->password);
            mysqli_select_db($this->link, 'TimePill');
            if (!$this->link)
                die("Connection failed: ".mysqli_connect_error());
            if (!mysqli_select_db($this->link, 'TimePill'))
                echo mysqli_error($this->link);
        }
        function getLink(){
            return $this->link;
        }
        function getBookName($bookId){
            $select = "SELECT book_name FROM diary_book WHERE id='". $bookId ."'";
            $res = mysqli_query($this->link, $select);
            $bookName = mysqli_fetch_array($res)['book_name'];
            return $bookName;
        }
        function insertBook($gmt_open, $brief, $name, $user_id){
            $gmt_create = time();
            $ins = "INSERT INTO diary_book ( gmt_open, gmt_create, book_name, book_brief, user_id ) 
                    VALUES ('". $gmt_open ."','". $gmt_create ."','" . $name ."','". $brief ."','" . $user_id ."') ";
            if (mysqli_query($this->link, $ins))
                return TRUE;
            else
                return FALSE;
        }
        function insertDiary($gmt, $content, $url, $book_id, $book_name, $user_id){
            $ins = "INSERT INTO diary ( gmt_create, content, img_url, book_id, book_name, user_id )
                    VALUES ('". $gmt ."','". $content ."','". $url ."','". $book_id . "','" . $book_name . "','" . $user_id. "')";
            if (mysqli_query($this->link, $ins))
                return TRUE;
            else
                return FALSE;
        }
        function queryBook($user_id){
            $select = "SELECT * FROM diary_book WHERE user_id = '". $user_id ."'";
            if ($result = mysqli_query($this->link, $select))
                return $result;
            else   
                return FALSE;
        }
        function queryDiary($book_id =''){
            if (!$book_id){
                $today = strtotime(date('Y-m-d',time()));
                $select = "SELECT * FROM diary WHERE gmt_create >= ". $today;
                $result = mysqli_query($this->link, $select);
            }else{   
                $select = "SELECT * FROM diary_book WHERE id = ". $book_id;
                if ($result = mysqli_query($this->link, $select)){
                    $row = mysqli_fetch_array($result);
                    $open_time = $row['gmt_open'];  //获取该日记本的开放时间
                    if ($open_time < time())
                        $flag = TRUE; 
                    else
                        $flag = FALSE; 
                    if ($flag){                     //已到开放时间
                        $select = "SELECT * FROM diary WHERE book_id = ". $book_id;
                    }else{                          //未到开放时间
                        $today = strtotime(date('Y-m-d',time()));
                        $select = "SELECT * FROM diary WHERE book_id = ". $book_id ." AND gmt_create >= ". $today;
                    }
                    $result = mysqli_query($this->link, $select);
                }else    
                    return FALSE;
            }
            return $result;
        }
    }
?>