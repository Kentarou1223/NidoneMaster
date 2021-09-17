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
header("Location:login.phpのurl"); ?>
<?php else: ?>

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

<!--フォームの表示-->
<form action="" method="post">
    <input name="log_out" type="submit" value="ログアウト" style="position: absolute; right: 0px; top: 0px">
</form>
<body style="background: url(about.jpg) fixed; background-size: cover;">
<br>
<h1 class="midashi_1" style="text-align:center; font-family:Sawarabi Mincho,sans-serif; background: rgba(240, 248, 255, 0.9);"><div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333;">
    このウェブアプリで何ができるの？
</div></h1>

<!--メニューバー--の表示-->
<ul>
    <style>
ul:not(div) {
    font-family: 'arial', sans-serif;
    font-size: 20px ;
    width: 100%;
	list-style-type: none;
	text-align: center;
	padding: 0;
	overflow: hidden;
	background-color: transparent;
}
li:not(div) {
    width: 24%;
    display: inline-block;
    /display: inline;
    /zoom: 1;
	border-right: 1px solid #bbbbbb;
}
li:last-child:not(div) {
	border-right: none;
}
li a:not(div) {
	display: block;
	color: white;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
	background-color: #696969;
}
li a:hover:not(.active):not(div) {
	background-color: #a9bce2;
}
.active:not(div) {
	background-color: #ba55d3;
}
    </style>
	<li><a href="page_HOMEのurl">HOME</a></li>
	<li><a class="active" href="page_ABOUTのurl">ABOUT</a></li>
	<li><a href="page_SCHEDULEのurl">SCHEDULE</a></li>
	<li><a href="page_FORUMのurl">FORUM</a></a></li>
</ul><!--ここまでがメニューバーの話-->

<div class="box7">
    <style>
.box7{
    width: 90%;
    padding: 0.5em 1em;
    margin: 2em 2em;
    color: #474747;
    background: whitesmoke;/*背景色*/
    border-left: double 7px #4ec4d3;/*左線*/
    border-right: double 7px #4ec4d3;/*右線*/
}
.box7 p {
    margin: 0; 
    padding: 0;
}
img{
  object-fit: contain;
  width: 50%;
  height: 50%;
  float: right;
}
    </style>
    <!--ここからが文章の内容-->
    <p><div style="font-size:20px">
    <br>
    本ウェブアプリには、朝が苦手な皆さんのために大きく２つの機能が搭載されています。<br>
    それぞれ詳しくご紹介していきましょう。</div></p><br>
    
    <h2>✏️<u style="color:navy;"><span style="color:navy; font-style:itali; background: linear-gradient(transparent 70%, #a7d6ff 70%); font-size:30px;">投稿・出勤までのプロセス表示機能(SHCEDULE)</span></u></h2>
    <img src="clock.jpg" alt="時計の写真" title="時計の画像" width="400px" >
    <p><div style="font-size:25px; color: navy;"><span style="border-bottom: solid 1px navy;"><b>主な機能</b></div></span></p>
    <p><div style="font-size:20px;">▷ 出勤・出社にかかる時間を予め登録</div></p>
    <p><div style="font-size:20px;">▷ 前日夜に翌日の起床時間を入力すれば、翌日の朝の起床〜出勤・出社までの具体的なプロセスを提示</div></p>
    <p><div style="font-size:20px;">▷ 余裕を持って出社できるイージーモードから、出社ギリギリまで寝ていたい人向けのハードモードまで３種類のモードが選択可能</div></p>
    <br>
    <p><div style="font-size:25px; color: navy;"><span style="border-bottom: solid 1px navy;"><b>製作者コメント</b></b></div></span></p>
    <p><div style="font-size:20px;">①ゴールから<b>逆算</b>して考えること、②ゴール達成までの道のりを<b>分割</b>して示すこと、この２つによって目標達成はぐんと楽になります。本機能を活用すれば、早起きはもう苦手じゃなくなるはず！</div></p>
    <br><p><div style="font-size:20px;"><b>⏩スケジュール機能は<a href="page_SCHEDULEのurl">こちら</b></a></div></p>
    <br><br>
    
    <h2>✏️<u style="color:navy;"><span style="color:navy; font-style:itali; background: linear-gradient(transparent 70%, #a7d6ff 70%); font-size:30px;">起床報告掲示板(FORUM)</span></u></h2>
    <img src="netforum.jpg" alt="時計の写真" title="時計の画像" width="400px" >
    <p><div style="font-size:25px; color: navy;"><span style="border-bottom: solid 1px navy;"><b>主な機能</b></div></span></p>
    <p><div style="font-size:20px;">▷ ユーザーが社会人であるか、学生であるかによって使える掲示板が異なる</div></p>
    <p><div style="font-size:20px;">▷ ユーザーは自由にコメントの投稿や編集、削除が可能</div></p>
    <p><div style="font-size:20px;">▷ 他人からのGOODの他に、自分の目標より早起きすればするほどGOOD数が増える。いいね数をランキングで競おう。</div></p>
    <br>
    <p><div style="font-size:25px; color: navy;"><span style="border-bottom: solid 1px navy;"><b>製作者コメント</b></b></div></span></p>
    <p><div style="font-size:20px;">人は環境に左右されやすい生き物だから、周りに早起きする人がたくさんいればきっと良い影響をもらえるはず！</div></p>
    <br><p><div style="font-size:20px;"><b>⏩起床報告掲示板機能は<a href="page_FORUMのurl">こちら</b></a></div></p>
    </div>
<?php endif; ?>