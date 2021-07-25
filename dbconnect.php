<?php
    // $mysql = "mysql:dbname=muscle_diary;host=mysql2010.db.sakura.ne.jp;charset=utf8";
    // $id = "muscle";
    // $password = "1025asai";
    // $db = new PDO("mysql:dbname=practice;host=localhost:8889;charset=utf8", "root", "root");
    $mysql = "mysql:dbname=aesthetic-01;host=localhost:3306;charset=utf8";
    $id = "root";
    $password = "1025asai";
    $mysql = "mysql:dbname=portfolio-03;host=localhost:3306;charset=utf8";
    $id = "root";
    $password = "1025asai";

    try {
        $db = new PDO ($mysql, $id, $password);
    } catch (PDOException $e) {
        print($e->message);
    }
?>