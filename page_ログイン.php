<?php
session_start();
//クロスサイトリクエストフォージェリ(CSRF)対策
$_SESSION['token']=base64_encode(openssl_random_pseudo_bytes(32));
$token=$_SESSION['token'];
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//エラーメッセージの初期化
$errors=array();

//DB情報とDBへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//(ログイン)urlへのアクセスがあったら
if (isset($_POST['log_submit'])){
    //まず必要な入力情報を変数化
    $logmail=$_POST['logmail'];
    $logpass=$_POST['logpass'];
    //さらにセッションに登録
    $_SESSION['logmail']=$logmail;
    $_SESSION['logpass']=$logpass;
    
    //対応するパスワードがあるかどうかの確認
    $sql= "SELECT*FROM tbmission_602u WHERE mail=:mail";
    $stm=$pdo->prepare($sql);
    $stm->bindParam(':mail', $logmail, PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll();
    $array=array_column($result, 'mail');
    if(in_array($logmail, $array)){
        $arrey=array_column($result, 'password');
        if(!in_array($logpass, $arrey)){
            $errors['pass']="パスワードが違います。";
        }} else {
            $errors['mail']= "メールアドレスが存在しません。";
    }
}//ここまでがログイン情報の入力があった際の対応
?>

<!--page_3 完了画面-->
<?php if(isset($_POST['log_submit']) && count($errors) === 0): ?>
     <?php header("Location:page_HOME.phpのurl")?>

<?php else: ?>
<!--page_2 ログイン画面-->
<h1>ログイン画面</h1>
     <?php if(count($errors)>0): ?>
          <?php
          foreach($errors as $value){
              echo "<p class='error'>".$value."</p>";
          }
          ?>
     <?php endif; ?>
        <form action="" method="post">
            <input name="logmail" type="text" placeholder="メールアドレス" required><br>
            <input name="logpass" type="text" placeholder="パスワード" required><br>
            <input name="log_submit" type="submit">
        </form><hr>
        <p>新規登録の方は<a href="仮登録画面.phpのurl">こちら</a></p>
<?php endif; ?>
