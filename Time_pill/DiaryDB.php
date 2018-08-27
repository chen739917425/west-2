<?php
    class DiaryDatebase{
        private $serverName;
        private $userName;
        private $password;
        private $link;
        function __construct($serve,$user,$pwd){
            $this->serverName = $serve;
            $this->userName = $user;
            $this->password = $pwd;
            $this->link = mysqli_connect($this->serverName, $this->userName, $this->password);
            if (!$this->link)
                die("Connection failed: ".mysqli_connect_error());
            if (!mysqli_select_db($this->link, 'TimePill'))
                echo mysqli_error($this->link);
        }
        function insertBook($gmt, $name, $user_id){
            $ins = "INSERT INTO diary_book ( gmt_open, book_name, user_id ) 
                    VALUES ('". $gmt ." ',' ". $name ." ',' ". $user_id ." ') ";
            if (mysqli_query($this->link, $ins))
                return TRUE;
            else
                return FALSE;
        }
        function inserDiary($gmt, $title, $content, $url, $book_id){
            $ins = "INSERT INTO diary ( gmt_create, title, content, img_url, book_id ) 
                    VALUES ('". $gmt ." ',' ". $title ." ',' ". $content ." ',' ". $url ." ',' ". $book_id ." ') ";
            if (mysqli_query($this->link, $ins))
                return TRUE;
            else
                return FALSE;
        }
        function queryBook($user_id){
            $select = "SELECT * FROM diary_book WHERE user_id = ". $user_id;
            if ($result = mysqli_query($this->link, $select))
                return $result;
            else   
                return FALSE;
        }
        function queryDiary($book_id){
            $select = "SELECT * FROM diary_book WHERE id = ". $book_id;
            if ($result = mysqli_query($this->link, $select)){
                $row = mysqli_fetch_array($result); 
                $open_time = $row['gmt_open']; //获取该日记本的开放时间
                if (strtotime($open_time) < time())
                    $flag = TRUE; 
                else
                    $flag = FALSE; 
                if ($flag){ //已到开放时间
                    $select = "SELECT * FROM diary WHERE book_id = ". $book_id;
                    if ($result = mysqli_query($this->link, $select))
                        return $result;
                    else
                        return FALSE;
                }else{ //未到开放时间
                    $today = strtotime(date('Y-m-d',time()));
                    $select = "SELECT * FROM diary WHERE book_id = ". $book_id ."AND unix_timestamp(gmt_create) >= ". $today;
                    if ($result = mysqli_query($this->link, $select))
                        return $result;
                    else
                        return FALSE;
                }
            }else    
                return FALSE;
        }
    }
?>