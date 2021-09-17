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

<!--タイトルの表示-->
<form action="" method="post">
    <input name="log_out" type="submit" value="ログアウト" style="position: absolute; right: 0px; top: 0px">
</form>
<body style="background: url(forum.jpg) fixed; background-size: cover;">
<br>
<h1 class="midashi_1" style="text-align:center; font-family:Sawarabi Mincho,sans-serif; background: rgba(240, 248, 255, 0.9);"><div style="padding: 10px; margin-bottom: 10px; border: 5px double #333333;">
    掲示板
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
	<li><a href="page_HOMEのurl">HOME</a></li>
	<li><a href="page_ABOUTのurl">ABOUT</a></li>
	<li><a href="page_SCHEDULEのurl">SCHEDULE</a></li>
	<li><a class="active" href="page_FORUMのurl">FORUM</a></a></li>
</ul>



<!--掲示板の外部の白い背景-->
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
    

<!--【①学生ヴァージョン】はこちらの掲示板を表示-->
<?php
//(大前提)データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//【学生ヴァージョン】はこちらの掲示板を表示
$sql='SELECT occupation FROM tbmission_602u WHERE mail=:mail';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':mail', $_SESSION['logmail'], PDO::PARAM_STR);
$stmt->execute();
$result=$stmt->fetchAll();
$array= array_column($result, 'occupation');
    if (in_array('学生', $array))://ここ迄が【学生ヴァージョン】条件
 ?>
 
<h2>️<center><u style="color:navy; text-align:center;"><span style="color:navy; text-align:center; font-style:itali; background: linear-gradient(transparent 70%, #a7d6ff 70%); font-size:30px;">学生用 起床報告掲示板</span></u></center></h2>

<?php
//(大前提)データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

echo $_SESSION["logmail"];
//【Mission③-1】 編集対象番号の入力があったら
if (isset($_POST["compile"])){
    //先に必要な変数の定義
    $compile=$_POST["compile"];
    $pass3=$_POST["pass3"];
    
    //対応するIDが存在するかどうかの確認
    $sql='SELECT id FROM tbmission_602sforum';
    $smtm=$pdo->prepare($sql);
    $smtm->execute();
    $result=$smtm->fetchAll();
    foreach($result as $raw){
    if ($compile==$raw['id']){
    //対応する情報をデータベースから取得する
    $sql='SELECT*FROM tbmission_602sforum where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $compile, PDO::PARAM_INT);
    $stmt->execute();
    $results=$stmt->fetchAll();
    }//ここ迄一致する対象番号があった時の反応
    }//ここ迄対応するIDが存在した時の対応
}//ここ迄【Mission③-1】 編集対象番号の入力があった際の対応


//【Mission①】入力された名前とコメントをDBのカラムに登録するプロセス
if(isset($_POST["str"])&&isset($_POST["comment"])){
    //先に必要な変数の定義
    $num=$_POST["num"];
    $str=$_POST["str"];
    $date=date("Y-m-d H:i:s");
    $com=$_POST["comment"];
    $pass1=$_POST["pass1"];
    
       //(条件①A-1) 再度投稿である場合
         if ($num!="投稿番号"){
             $id=$num;
             $sql='UPDATE tbmission_602sforum SET name=:name, comment=:comment, create_date=:create_date, password=:password WHERE id=:id';
             $stmt=$pdo->prepare($sql);
             $stmt->bindParam(':name', $str, PDO::PARAM_STR);
             $stmt->bindParam(':comment', $com, PDO::PARAM_STR);
             $stmt->bindParam(':create_date', $date, PDO::PARAM_STR);
             $stmt->bindParam(':password', $pass1, PDO::PARAM_STR);
             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
             $stmt->execute();
         } else {//ここ迄(条件①A-1)再度投稿である場合
       //(条件①A-2) 再度投稿でない場合
         $sql=$pdo->prepare("INSERT INTO tbmission_602sforum (name,comment,create_date,password) VALUES(:name,:comment,:create_date,:password)");
         //テーブルに上記の要素を書き込む作業
         $sql->bindParam(':name', $str, PDO::PARAM_STR);
         $sql->bindParam(':create_date', $date, PDO::PARAM_STR);
         $sql->bindParam(':comment', $com, PDO::PARAM_STR);
         $sql->bindParam(':password', $pass1, PDO::PARAM_STR);
         $sql->execute();
         }//ここ迄(条件①A-2)再度表示でない場合
     //データを読み取りブラウザに表示する作業
     $sql='SELECT*FROM tbmission_602sforum';
     $stmt=$pdo->query($sql);
     $result=$stmt->fetchAll();
     foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment']."<br>";
     }//ここ迄 foreach関数
} else {//←ここ迄【Mission①】：名前とコメントに入力があった際の対応

//【Mission②】削除対象番号の入力があった際の対応
if (isset($_POST["delete"])) {
    //先に必要な変数の定義
    $delete=$_POST["delete"];
    $pass2=$_POST["pass2"];
    
    //対応するIDが存在するかどうかの確認
    $spl='SELECT id FROM tbmission_602sforum';
    $sttm=$pdo->prepare($spl);
    $sttm->execute();
    $result=$sttm->fetchAll();
    $array=array_column($result, 'id');
    if (in_array($delete, $array)){
    
    //パスワードが一致した時のみ、と言う条件
    $sql='SELECT*FROM tbmission_602sforum where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetchAll();
    foreach ($result as $row){
        if ($row['password']==$pass2){
    
    //削除する過程
    $sql='delete from tbmission_602sforum where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    $stmt->execute();
    
    //データを読み取り再度ブラウザに表示
    $sql='SELECT*FROM tbmission_602sforum';
    $stmt=$pdo->query($sql);
    $result=$stmt->fetchAll();
    echo "<hr>";
    foreach($result as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].'<名前>';
        echo $row['name'].'<日付>';
        echo $row['create_date'].'<br>';
        echo '　　'.$row['comment'].'<br>';
    }//ここ迄 foreach関数
        }//ここ迄 passが一致した時のみ、と言う条件(168〜188)
        else {
        $sql = 'SELECT*FROM tbmission_602sforum';
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();
        echo "<hr>";
        foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
     }}//ここまでがpassが一致しなかった時(189〜200)
    }//ここまでがpassのforeach関数
    }
    else {
        $sql = 'SELECT*FROM tbmission_602sforum';
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();
        echo "<hr>";
        foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
        }}//ここまでが対応するpassがなかった時の話
}//ここ迄【Mission②】：削除対象番号の入力があった際の対応
else {
    $sql = 'SELECT*FROM tbmission_602sforum';
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();
    echo "<hr>";
    foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
     }//ここまでがforeach関数
}//ここまでがMission②elseの話
}//ここまでがMission①elseの話
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>mission_6-02 STUDENT FORUM</title>
        <style>
        #child1 {
            background-color: none;
            border-right-style: solid;
            border-width:1.5px;
            margin: 0em 1em;
        }
        #child2 {
            background-color: none;
            border-right-style: solid;
            border-width:1.5px;
            margin: 0em 1em;
        }
        #child3 {
            background-color: none;
        }
        @media (min-width: 600px) {
            #parent {
                display: flex;
            }
            #child1 {
                flex-grow: 1;
            }
            #child2 {
                flex-grow: 1;
            }
            #child3 {
                flex-grow: 1;
            }
        }
        </style>
    </head>
    <body>
        <hr><hr>
        <div id="parent">
            <div id="child1">
                <form action="" method="post">
            <input name="num" type="hidden" value="<?php
            if (isset($results)){
                foreach($results as $row){
                    if ($row['password']==$pass3){
                        echo $row['id'];
                    } else { echo "投稿番号";//ここ迄 パスワードが一致した時
                    }//ここまでpassが一致しなかった時
                }//ここまでがforeach関数
            }//ここまでが$resultが存在した時の対応
            else {echo "投稿番号";
            }?>">
            <input name="str" type="text" value="<?php
            if (isset($results)){
                foreach($results as $row){
                    if ($row['password']==$pass3){
                        echo $row['name'];
                    }//ここ迄 パスワードが一致した時
                }//ここまでがforeach関数
            }//ここまでが$resultが存在した時の対応
            ?>" placeholder="名前" size=15px required><br>
            <input name="pass1" type="password" placeholder="パスワード" size=15px required><br>
            <textarea name="comment" cols="24" rows="3" value="<?php
            if (isset($results)){
                foreach($results as $row){
                    if ($row['password']==$pass3){
                        echo $row['comment'];
                    }//ここ迄 パスワードが一致した時
                }//ここまでがforeach関数
            }//ここまでが$resultが存在した時の対応
            ?>"
            placeholder="コメント" required></textarea>
            <input name="submit" type="submit"></form>
            </div>
            <div id="child2">
                <form action="" method="post">
                    <input name="delete" type="text" placeholder="削除対象番号(半角)" size="16px"required><br>
                    <input name="pass2" type="password" placeholder="パスワード" size="16px" required>
                    <input name="submit" type="submit">
                </form>
            </div>
            <div id="child3">
                <form action="" method="post">
                    <input name="compile" type="text" placeholder="編集対象番号(半角)" size="16px"required><br>
                    <input name="pass3" type="password" placeholder="パスワード" size="16px" required>
                    <input name="submit" type="submit">
                </form>
            </div>
        </div>
    </body>
</html>














<!--【②社会人ヴァージョン】-はこちらの掲示板を表示-->
<?php else: ?>

<h2>️<center><u style="color: mediumvioletred; text-align:center;"><span style="color: mediumvioletred; text-align:center; font-style:itali; background: linear-gradient(transparent 70%, #ffb6c1 70%); font-size:30px;">社会人用 起床報告掲示板</span></u></center></h2>

<?php
//(大前提)データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//【Mission③-1】 編集対象番号の入力があったら
if (isset($_POST["compile"])){
    //先に必要な変数の定義
    $compile=$_POST["compile"];
    $pass3=$_POST["pass3"];
    
    //対応するIDが存在するかどうかの確認
    $sql='SELECT id FROM tbmission_602wforum';
    $smtm=$pdo->prepare($sql);
    $smtm->execute();
    $result=$smtm->fetchAll();
    foreach($result as $raw){
    if ($compile==$raw['id']){
    //対応する情報をデータベースから取得する
    $sql='SELECT*FROM tbmission_602wforum where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $compile, PDO::PARAM_INT);
    $stmt->execute();
    $results=$stmt->fetchAll();
    }//ここ迄一致する対象番号があった時の反応
    }//ここ迄対応するIDが存在した時の対応
}//ここ迄【Mission③-1】 編集対象番号の入力があった際の対応


//【Mission①】入力された名前とコメントをDBのカラムに登録するプロセス
if(isset($_POST["str"])&&isset($_POST["comment"])){
    //先に必要な変数の定義
    $num=$_POST["num"];
    $str=$_POST["str"];
    $date=date("Y-m-d H:i:s");
    $com=$_POST["comment"];
    $pass1=$_POST["pass1"];
    
       //(条件①A-1) 再度投稿である場合
         if ($num!="投稿番号"){
             $id=$num;
             $sql='UPDATE tbmission_602wforum SET name=:name, comment=:comment, create_date=:create_date, password=:password WHERE id=:id';
             $stmt=$pdo->prepare($sql);
             $stmt->bindParam(':name', $str, PDO::PARAM_STR);
             $stmt->bindParam(':comment', $com, PDO::PARAM_STR);
             $stmt->bindParam(':create_date', $date, PDO::PARAM_STR);
             $stmt->bindParam(':password', $pass1, PDO::PARAM_STR);
             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
             $stmt->execute();
         } else {//ここ迄(条件①A-1)再度投稿である場合
       //(条件①A-2) 再度投稿でない場合
         $sql=$pdo->prepare("INSERT INTO tbmission_602wforum (name,comment,create_date,password) VALUES(:name,:comment,:create_date,:password)");
         //テーブルに上記の要素を書き込む作業
         $sql->bindParam(':name', $str, PDO::PARAM_STR);
         $sql->bindParam(':create_date', $date, PDO::PARAM_STR);
         $sql->bindParam(':comment', $com, PDO::PARAM_STR);
         $sql->bindParam(':password', $pass1, PDO::PARAM_STR);
         $sql->execute();
         }//ここ迄(条件①A-2)再度表示でない場合
     //データを読み取りブラウザに表示する作業
     $sql='SELECT*FROM tbmission_602wforum';
     $stmt=$pdo->query($sql);
     $result=$stmt->fetchAll();
     foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
     }//ここ迄 foreach関数
} else {//←ここ迄【Mission①】：名前とコメントに入力があった際の対応

//【Mission②】削除対象番号の入力があった際の対応
if (isset($_POST["delete"])) {
    //先に必要な変数の定義
    $delete=$_POST["delete"];
    $pass2=$_POST["pass2"];
    
    //対応するIDが存在するかどうかの確認
    $spl='SELECT id FROM tbmission_602wforum';
    $sttm=$pdo->prepare($spl);
    $sttm->execute();
    $result=$sttm->fetchAll();
    $array=array_column($result, 'id');
    if (in_array($delete, $array)){
    
    //パスワードが一致した時のみ、と言う条件
    $sql='SELECT*FROM tbmission_602wforum where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetchAll();
    foreach ($result as $row){
        if ($row['password']==$pass2){
    
    //削除する過程
    $sql='delete from tbmission_602wforum where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    $stmt->execute();
    
    //データを読み取り再度ブラウザに表示
    $sql='SELECT*FROM tbmission_602wforum';
    $stmt=$pdo->query($sql);
    $result=$stmt->fetchAll();
    echo "<hr>";
    foreach($result as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].'<名前>';
        echo $row['name'].'<日付>';
        echo $row['create_date'].'<br>';
        echo '　　'.$row['comment'].'<br>';
    }//ここ迄 foreach関数
        }//ここ迄 passが一致した時のみ、と言う条件(168〜188)
        else {
        $sql = 'SELECT*FROM tbmission_602wforum';
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();
        echo "<hr>";
        foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
     }}//ここまでがpassが一致しなかった時(189〜200)
    }//ここまでがpassのforeach関数
    }
    else {
        $sql = 'SELECT*FROM tbmission_602wforum';
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();
        echo "<hr>";
        foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
        }}//ここまでが対応するpassがなかった時の話
}//ここ迄【Mission②】：削除対象番号の入力があった際の対応
else {
    $sql = 'SELECT*FROM tbmission_602wforum';
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();
    echo "<hr>";
    foreach($result as $row){
         //$rowの中にはテーブルのカラム名が入る
         echo $row['id'].'<名前>';
         echo $row['name'].'<日付>';
         echo $row['create_date'].'<br>';       
         echo '　　'.$row['comment'].'<br>';
     }//ここまでがforeach関数
}//ここまでがMission②elseの話
}//ここまでがMission①elseの話
?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>mission_6-02 STUDENT FORUM</title>
        <style>
        #child1 {
            background-color: none;
            border-right-style: solid;
            border-width:1.5px;
            margin: 0em 1em;
        }
        #child2 {
            background-color: none;
            border-right-style: solid;
            border-width:1.5px;
            margin: 0em 1em;
        }
        #child3 {
            background-color: none;
        }
        @media (min-width: 600px) {
            #parent {
                display: flex;
            }
            #child1 {
                flex-grow: 1;
            }
            #child2 {
                flex-grow: 1;
            }
            #child3 {
                flex-grow: 1;
            }
        }
        </style>
    </head>
    <body>
        <hr><hr>
        <div id="parent">
            <div id="child1">
                <form action="" method="post">
            <input name="num" type="hidden" value="<?php
            if (isset($results)){
                foreach($results as $row){
                    if ($row['password']==$pass3){
                        echo $row['id'];
                    } else { echo "投稿番号";//ここ迄 パスワードが一致した時
                    }//ここまでpassが一致しなかった時
                }//ここまでがforeach関数
            }//ここまでが$resultが存在した時の対応
            else {echo "投稿番号";
            }?>">
            <input name="str" type="text" value="<?php
            if (isset($results)){
                foreach($results as $row){
                    if ($row['password']==$pass3){
                        echo $row['name'];
                    }//ここ迄 パスワードが一致した時
                }//ここまでがforeach関数
            }//ここまでが$resultが存在した時の対応
            ?>" placeholder="名前" size=15px required><br>
            <input name="pass1" type="password" placeholder="パスワード" size=15px required><br>
            <textarea name="comment" cols="24" rows="3" value="<?php
            if (isset($results)){
                foreach($results as $row){
                    if ($row['password']==$pass3){
                        echo $row['comment'];
                    }//ここ迄 パスワードが一致した時
                }//ここまでがforeach関数
            }//ここまでが$resultが存在した時の対応
            ?>"
            placeholder="コメント" required></textarea>
            <input name="submit" type="submit"></form>
            </div>
            <div id="child2">
                <form action="" method="post">
                    <input name="delete" type="text" placeholder="削除対象番号(半角)" size="16px"required><br>
                    <input name="pass2" type="password" placeholder="パスワード" size="16px" required>
                    <input name="submit" type="submit">
                </form>
            </div>
            <div id="child3">
                <form action="" method="post">
                    <input name="compile" type="text" placeholder="編集対象番号(半角)" size="16px"required><br>
                    <input name="pass3" type="password" placeholder="パスワード" size="16px" required>
                    <input name="submit" type="submit">
                </form>
            </div>
        </div>
    </body>
</html>



<?php endif; ?>

</div>
<?php endif; ?>