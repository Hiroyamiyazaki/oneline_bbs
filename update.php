<?php

    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');


    
    $nickname =$_POST['nickname'];
    $comment =$_POST['comment'];
    $id =$_POST['id'];


    $sql ='UPDATE `posts` SET `nickname` = ?,`comment` = ? WHERE `id`=?';
    $data[] = $nickname;
    $data[] = $comment;
    $data[]= $id;



    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql='SELECT FROM `posts` WHERE `id` =?';


     $dbh = null;
// リダイレクト
header("Location: bbs.php");
exit();
