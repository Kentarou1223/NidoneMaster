<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = "CREATE TABLE IF NOT EXISTS tbmission_602u"
." ("
. "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
. "last CHAR(32) NOT NULL,"
. "first CHAR(32) NOT NULL,"
. "password VARCHAR(128) NOT NULL,"
. "mail VARCHAR(128) NOT NULL,"
. "status INT(1) NOT NULL DEFAULT 2,"
. "occupation TEXT,"
. "created_at DATETIME,"
. "updated_at DATETIME"
.")ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;";
$stmt = $pdo->query($sql);
?>