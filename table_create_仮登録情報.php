<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = "CREATE TABLE IF NOT EXISTS tbmission_602preu"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "urltoken VARCHAR(255),"
. "create_date DATETIME,"
. "mail VARCHAR(128),"
. "flag TINYINT(1) NOT NULL DEFAULT 0"
.")ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;";
$stmt = $pdo->query($sql);
?>
