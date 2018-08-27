<?php
    include 'DiaryDB';
    $serveName = 'localhost';
    $userName = 'root';
    $password = '0424';
    $link = mysqli_connect($serveName, $userName ,$password);
    if (!$link)
        echo mysqli_connect_error();
    $createDB = 'CREATE DATABASE TimePill DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
    if (!mysqli_query($link, $createDB))
        echo mysqli_error($link);
    $createTable = 'CREATE TABLE diary_book
    (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        gmt_open DATETIME NOT NULL,
        book_name CHAR(30) NOT NULL,
        user_id CHAR(30)
    )ENGINE = InnoDB  DEFAULT CHARSET = utf8'; 
    if (!$mysqli_query($link, $ceateTable))
        echo mysqli_error($link);
    $createTable = 'CREATE TABLE diary
    (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        gmt_create DATETIME NOT NULL,
        title CHAR(30) NOT NULL,
        content VARCHAR(2000) NOT NULL,
        img_url VARCHAR(200),
        book_id BIGINT UNSIGNED NOT NULL
    )ENGINE = InnoDB  DEFAULT CHARSET = utf8';
    if (!$mysqli_query($link, $createTable))
        echo mysqli_error($link);
?>