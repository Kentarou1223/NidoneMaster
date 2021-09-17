

<!-- ※このページは未完成です。-->

<!--ログイン画面の表示-->
<div style="display:inline-block; padding: 3px 3px; margin: 0px 0px; border: 5px double #333333; border-radius: 5px; background:#f5f5f5">
<font size="3px">
<?php
//セッションのスタート
session_start();
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql='SELECT*FROM tbmission_602u WHERE mail=:mail';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':mail', $_SESSION['logmail'], PDO::PARAM_STR);
$stmt->execute();
$result=$stmt->fetchAll();
foreach ($result as $row){
    $login_last=$row['last'];
    $login_first=$row['first'];
}
echo "ようこそ<b>".$login_last."</b> <b>".$login_first."</b>さん";
?></font></div>

<!--タイトルの表示-->
<form action="" method="post">
    <input name="log_out" type="submit" value="ログアウト" style="position: absolute; right: 0px; top: 0px">
</form>
<body style="background: url(schedule.JPG) fixed; background-size: cover;">
<br>
<h1 class="midashi_1" style="text-align:center; font-family:Sawarabi Mincho,sans-serif; background: rgba(240, 248, 255, 0.9);"><div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333;">
    朝起きてからのスケジュール
</div></h1>

<!--メニューバーの表示-->
<ul>
    <style>
    ul {
    font-family: 'arial', sans-serif;
    font-size: 20px ;
    width: 100%;
	list-style-type: none;
	text-align: center;
	padding: 0;
	overflow: hidden;
	background-color: transparent;
}
li {
    width: 24%;
    display: inline-block;
    /display: inline;
    /zoom: 1;
	border-right: 1px solid #bbbbbb;
}
li:last-child {
	border-right: none;
}
li a {
	display: block;
	color: white;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
	background-color: #696969;
}
li a:hover:not(.active) {
	background-color: #a9bce2;
}
.active {
	background-color: #ba55d3;
}
    </style>
	<li><a href="page_HOME.phpのurl">HOME</a></li>
	<li><a href="page_ABOUT.phpのurl">ABOUT</a></li>
	<li><a class="active" href="page_SCHEDULE.phpのurl">SCHEDULE</a></li>
	<li><a href="page_FORUM.phpのurl">FORUM</a></a></li>
</ul>

<!--ログアウトボタンへの入力があった際の対応>
<?php if(isset($_POST["log_out"])): ?>
 <?php
 //セッション変数を全て削除
 $_SESSION=array();
 //セッションクッキーの削除
 if (isset($_COOKIE["PHPSESSID"])){
     setcookie("PHPSESSID", '', time() - 1800,'/');
    }
    //セッションを破棄する
    session_destroy();
 header("Location:login.phpのurl")?>
<?php endif; ?>