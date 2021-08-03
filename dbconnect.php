<?php
    // MacBook
    $mysql = "mysql:dbname=aesthetic-01;host=localhost:3306;charset=utf8";
    $id = "root";
    $password = "1025asai";
    // さくらのレンタルサーバ
    $mysql = "mysql:dbname=muscle_portfolio-03;host=mysql2010.db.sakura.ne.jp;charset=utf8";
    $id = "muscle";
    $password = "1025asai";
    // WindowsノートPC
    $mysql = "mysql:dbname=portfolio-03;host=localhost:3306;charset=utf8";
    $id = "root";
    $password = "1025asai";

    try {
        $db = new PDO ($mysql, $id, $password);
    } catch (PDOException $e) {
        print($e->message);
    }
?>