<?php
    include 'DiLi_db.php';
    $servername = 'localhost';
    $username = 'root';
    $password = '0424';
    $db_name = 'DiLi';
    $table_name = 'DiLi_anime';
    $sql = new DiLi_DB($servername,$username,$password);
    $link = $sql->link($db_name);
    $result = $sql->select($link);
    while ($row = mysqli_fetch_array($result))
    {
        echo '<img src ="'.$row['anime_img'].'" width = "400px" height = "300px"/><br/>';
        echo '<span style = "font-size:20px;">'.$row['anime_name'].'</span><br/>'.$row['anime_info'].'<br/>';
        echo '<a href ="'.$row['anime_url'].'"> 在线观看 </a><br/>';
    }   
?>