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

<!--タイトルの表示-->
<form action="" method="post">
    <input name="log_out" type="submit" value="ログアウト" style="position: absolute; right: 0px; top: 0px">
</form>
<body style="background: url(toppage.jpg) fixed; background-size: cover;">
<br>
<h1 class="midashi_1" style="text-align:center; font-family:Sawarabi Mincho,sans-serif; background: rgba(240, 248, 255, 0.9);"><div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333;">
    完全二度寝マスターへようこそ！
</div></h1>
<!--メニューバー-->
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
	<li><a class="active" href="page_HOMEのurl">HOME</a></li>
	<li><a href="page_ABOUTのurl">ABOUT</a></li>
	<li><a href="page_SCHEDULEのurl">SCHEDULE</a></li>
	<li><a href="page_FORUMのurl">FORUM</a></a></li>
</ul>

<div class="box7">
    <style>
.box7{
    width: 90%;
    padding: 0.5em 1em;
    margin: 2em 2em;
    color: #474747;
    background: white;/*背景色*/
    border-left: double 7px #4ec4d3;/*左線*/
    border-right: double 7px #4ec4d3;/*右線*/
}
.box7 p {
    margin: 0; 
    padding: 0;
}
img {
  object-fit: contain;
  width: 50%;
  height: 50%;
  margin: 2px 2px;
  float: right;
}
    </style>
    <!--ここからが文章の内容-->
    <br>
    <img src="いらすと.jpg" alt="時計の写真" title="時計の画像" width="400px" >
    <h1><style>
    h1 {
  padding: 0.25em 0.5em;/*上下 左右の余白*/
  color: #494949;/*文字色*/
  background: transparent;/*背景透明に*/
  border-left: solid 5px #7db4e6;/*左線*/
}
    </style>もう寝坊なんてしねぇ！</h1>
    <p><div style="font-size:20px;">あぁ今日も学校に行くのがダルい……後ちょっとだけ布団の中にいたい……</div></p><br>
    <p><div style="font-size:20px;">もう少しだけ夢の世界の中で漂っていたい……</div></p><br>
    <p><div style="font-size:20px;">そんな気持ちから目覚ましを止めて後５分だけうとうと…</div></p><br>
    <p><div style="font-size:20px;">……</div></p><br>
    <p><div style="font-size:20px;">……</div></p><br>
    <p><div style="font-size:20px;">と、思っていたら<div style="font-size:30px;"><b>30分も経っていた!?</b></div>なーんて経験、誰にでもあるんじゃないでしょうか。</div></p><br><br>
    <p><div style="font-size:20px;">こんにちは、二度寝マスター開発者のわらじむしです。</div></p><br>   
    <p><div style="font-size:20px;">何を隠そう、私自身も大の遅刻常連者です。</div></p><br><br>
    <p><div style="font-size:20px;">一般的に人間は人生の３分の１は寝て過ごすと言われていますが、私は人生の２分の１以上を布団と共に歩んできた自負があります。</div></p><br>
    <p><div style="font-size:20px;">でも寝坊って朝の貴重な時間は失うし、職場での信頼関係も失うし、本当にいいことないですよね…</div></p><br><br>
    <p><div style="font-size:20px;">そんな朝が苦手な忙しい学生・社会人の方々にとって、この<b>「完全二度寝マスター」</b>は誰よりも心強い助っ人になるに違いありません！</div></p><br><br><br>
    <p><div style="font-size:20px;">最初に断っておきたいのは、本アプリは「完全二度寝マスター」という名前のとおり、<u>早起きを目指すものではございません</u>。</div></p><br>
    <p><div style="font-size:20px;">本アプリの掲げる目標は、<b>「自分で決めた時間に起きること」</b>です。</div></p><br>
    <p><div style="font-size:20px;">すなわち、ここでいう「二度寝」とは「早起きしちゃったな、だから二度寝するか、でも決めた時間に起きるぞ」という意味での二度寝です。</div></p><br>
    <p><div style="font-size:20px;">もっとわかりやすく言えば、「遅刻する二度寝」ではなく、<b>「決めた時間に起きる二度寝」</b>です。</div></p><br>
    <p><div style="font-size:20px;">この発明が人々の「二度寝」の概念を変えるに違いない、そんな思いからこのような名前をつけました。</div></p><br><br>
    <p><u style="color:#228b22;"><font style="color:#228b22;"><div style="font-size:32px; text-align:center"><b>さぁ、一緒に生活習慣を、人生を、変えていきませんか？</b></div></font></u></p><br><br>
    <h1><style>
    h1 {
  padding: 0.25em 0.5em;/*上下 左右の余白*/
  color: #494949;/*文字色*/
  background: transparent;/*背景透明に*/
  border-left: solid 5px #7db4e6;/*左線*/
}
    </style>開発者情報</h1>
    <img src="アザラシィ.jpg" alt="アザラシィ" title="アザラシィ" width="200px" >
    <h2>✏️<u style="color:navy;"><span style="color:navy; font-style:itali; background: linear-gradient(transparent 70%, #a7d6ff 70%); font-size:30px;">ワラジムシ</span></u></h2>
    <p><div style="font-size:20px;">国際政治を勉強する都内在住の法学徒。</div></p><br>
    <p><div style="font-size:20px;">一人暮らし開始と共に自炊を始めたがしゃもじを溶かして紛失した圧倒的自炊強者。</div></p><br>
    <p><div style="font-size:20px;">ちなみに各ページの背景に使用した写真は、各々私が学生時代に訪れたロシア、ミャンマー、オーストラリア、台湾の写真。</div></p>
    <br><p><div style="font-size:20px;"><b>⏩開発者のプロフィール詳細は<a href="※個人情報のためGit-Hubには掲載しません">こちら</a></b></div></p>
    </div>
<?php endif; ?>