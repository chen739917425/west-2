<?php
    include 'DiLi_db.php';
    $servername = 'localhost';
    $username = 'root';
    $password = '0424';
    $db_name = 'DiLi';
    $table_name = 'DiLi_anime';
    $sql = new DiLi_DB($servername,$username,$password);
    $link = $sql->link();
    $sql->create_db($link,$db_name);
    mysqli_select_db($link,$db_name);
    $sql->create_table($link,$table_name);
?>