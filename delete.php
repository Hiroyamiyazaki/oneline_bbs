<?php

//削除する処理

    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');

    $id =$_GET['id'];


    $sql ='DELETE FROM `posts` WHERE `id` = ?';
    $data[]=$_GET['id'];

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);



     $dbh = null;
// リダイレクト


header("Location: bbs.php");
exit();