<?php
    class DiLi_DB
    {
        private $servername;
        private $username;
        private $password;
        function __construct($server,$user,$psw)
        {
            $this->servername = $server;
            $this->username = $user;
            $this->password = $psw;
        }
        function link($db_name='')
        {
            $link = mysqli_connect($this->servername,$this->username,$this->password);
            if (!$link)                                                 
                die("Connection failed: " . mysqli_connect_error());  
            if ($db_name)   
            {
                mysqli_select_db($link,$db_name);
                echo '连接库'.$db_name.'成功<br/>';
            }
            else   
                echo '连接成功<br/>';
            return $link;
        }        
        function create_db($link,$db_name)
        {
            $create_db = 'CREATE DATABASE '.$db_name.' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
            if (mysqli_query($link,$create_db))      
                echo '创建库成功<br/>';
            else
                echo '创建库失败<br/>'.mysqli_error($link);
        }
        function create_table($link,$table_name)
        {
            $create_table = 'CREATE TABLE '.$table_name.'
            (
               anime_id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
               anime_name varchar(500) NOT NULL,
               anime_img varchar(500) NOT NULL,
               anime_info varchar(500),
               anime_url varchar(500) NOT NULL
            )';
            if (mysqli_query($link,$create_table))
                echo'创建表成功';
            else
                echo'创建表失败'.mysqli_error($link);               
        }
        function insert($link,$name,$img,$info,$url)
        {
            $table_name = 'DiLi_anime';
            $insert="INSERT INTO ".$table_name." (anime_name,anime_img,anime_info,anime_url) VALUES ('".$name."','".$img."','".$info."','".$url."')";
            if (!mysqli_query($link,$insert))
                echo $name.'插入失败:'.mysqli_error($link).'<br/>';
        }
        function select($link)
        {
            $table_name = 'DiLi_anime';
            $select = 'SELECT * FROM '.$table_name.' ORDER BY anime_id DESC';
            if (!$result = mysqli_query($link,$select)) 
                echo mysqli_error($link);
            return $result;
        }
    }
?>