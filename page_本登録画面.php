<?php
session_start();
//クロスサイトリクエストフォージェリ(CSRF)対策
$_SESSION['token']=base64_encode(openssl_random_pseudo_bytes(32));
$token=$_SESSION['token'];
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//エラーメッセージの初期化
$errors = array();

//DB情報と DBへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//(多分)urlへのアクセスがあったら
if(!empty($_GET)){

//GETデータを変数に入れる
$urltoken=isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
//メール入力判定
if ($urltoken== ''){
    $errors['urltoken']= "トークンがありません。";
} else {
    //flagが0の登録者 or 仮登録日にちから24時間以内
    $sql = "SELECT mail FROM tbmission_602preu WHERE urltoken=(:urltoken) AND flag =0 AND create_date > now() - interval 10 hour";
    $stm = $pdo->prepare($sql);
    $stm ->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
    $stm ->execute();
    
    //レコード件数の取得
    $row_count=$stm->rowCount();
    
    //24時間以内に仮登録され、本登録されていないトークンの場合
    if ($row_count == 1){
        $mail_array=$stm->fetch();
        $mail=$mail_array["mail"];
        $_SESSION['mail']=$mail;
    } else {
        $errors['urltoken_timeover']="このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやり直してください。";
    }
    //データベース切断
    $stm=null;
    }//ここまでトークンが存在した場合(メール入力が適正にあった場合)
}//ここまでがurlへのアクセスがあった時の対応

//【条件A】本登録画面への入力があったら
if (isset($_POST['btn_confirm'])){
    //まずパスワードが一致していたら
    if ($_POST['pass1']==$_POST['pass2']){
        
        //第一にPOSTデータを変数化する
        $last=$_POST['last'];
        $first=$_POST['first'];
        $occupation=$_POST['occupation'];
        $pessword=$_POST['pass1'];
        
        //セッションに登録
        $_SESSION['last']=$last;
        $_SESSION['first']=$first;
        $_SESSION['occupation']=$occupation;
        $_SESSION['pass1']=$pessword;
    } else {
        $errors['password']="パスワードが一致しません。";
    }
}

//【条件B】登録(btn_submit)した後の処理
if(isset($_POST['btn_submit'])){
    
    //ここでデータベースに登録する
    $sql="INSERT INTO tbmission_602u (last,first,occupation,password,mail,status,created_at,updated_at) VALUES (:last, :first, :occupation, :password, :mail, 1, now(), now())";
    $stm=$pdo->prepare($sql);
    $stm->bindParam(':last', $_SESSION['last'], PDO::PARAM_STR);
    $stm->bindParam(':first', $_SESSION['first'], PDO::PARAM_STR);
    $stm->bindParam(':occupation', $_SESSION['occupation'], PDO::PARAM_STR);
    $stm->bindParam(':password', $_SESSION['pass1'], PDO::PARAM_STR);
    $stm->bindParam(':mail', $_SESSION['mail'], PDO::PARAM_STR);
    $stm->execute();
    
    //pre_userのflagを1にする(トークンの無効化)
    $sql="UPDATE tbmission_602preu SET flag=1 WHERE mail=:mail";
    $stm=$pdo->prepare($sql);
    //プレースホルダへ実際の値を設定する
    $stm->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stm->execute();
    
//メールの送信
    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';
    require 'setting.php';
    
    // PHPMailerのインスタンス生成
    $nail = new PHPMailer\PHPMailer\PHPMailer();

    $nail->isSMTP(); // SMTPを使うようにメーラーを設定する
    $nail->SMTPAuth = true;
    $nail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    $nail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    $nail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    $nail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    $nail->Port = SMTP_PORT; // 接続するTCPポート

    // メール内容設定
    $nail->CharSet = "UTF-8";
    $nail->Encoding = "base64";
    $nail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    $nail->addAddress($mail, '本登録者'); //受信者（送信先）を追加する
//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
    $nail->Subject = MAIL_SUBJECT; // メールタイトル
    $nail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    $uurl = 'ログインページのurl';
    $body = $_SESSION['last']." ".$_SESSION['first'].'様<br><br>完全二度寝マスターへの本登録が完了致しました。<br><br>登録いただきましたメールアドレスは、以下の通りです。<br><br>E-mail: '.$mail.'<br><br>※パスワードは、セキュリティ上、メールや電話でのご案内はしておりません。<br><br>パスワードは、第三者に知られることのないよう、ご自身で厳重に管理してください。<br><br>ログインはこちら⇨　'.$uurl.'<br><br>※このメールはシステムが自動的にメール送信しています。<br><br>------------------------------------------------<br>完全二度寝マスター 運営担当<br>E-mail：naokishida69@gmail.com<br>TEL：××-××××-××××(内線××××)<br>------------------------------------------------<br>';

    $nail->Body  = $body; // メール本文
    // メール送信の実行
    if(!$nail->send()) {
    	echo 'メッセージは送られませんでした！';
    	echo 'Mailer Error: ' . $nail->ErrorInfo;
    }//ここ迄がメール本文
    
    
    //データベース接続切断
    $stm=null;
    
    //セッション変数を全て削除
    $_SESSION=array();
    //セッションクッキーの削除
    if (isset($_COOKIE["PHPSESSID"])){
        setcookie("PHPSESSID", '', time() - 1800,'/');
    }
    //セッションを破棄する
    session_destroy();
    
}//ここ迄【条件B】登録(btn_submit)した後の作業

?>

<h1>会員登録画面</h1>
<!-- page_3 完了画面-->
<?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
本登録されました。

<p>ログインは<a href="login.phpのurl">こちら</a></p>

<p>

<!-- page_2 確認画面-->
<?php elseif (isset($_POST['btn_confirm']) && count($errors) === 0): ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME']?>?urltoken=<?php print $urltoken; ?>" method="post">
        <p>メールアドレス：<?=htmlspecialchars($_SESSION['mail'], ENT_QUOTES) ?></p>
        <p>氏 名：<?=htmlspecialchars($last." ".$first, ENT_QUOTES)?></p>
        <p>職 業：<?=$occupation?></p>
        <p>パスワード：<?=$pessword?></p>
        
        <input type="submit" name="btn_back" value="戻る">
        <input type="hidden" name="token" value="<?=$_POST['token']?>">
        <input type='submit' name="btn_submit" value="登録する">
    </form>


<?php else: ?>
<!-- page_1 登録画面-->
      <?php if(count($errors)>0):?>
          <?php
          foreach($errors as $value){
              echo "<p class='error'>".$value."</p>";
          }
          ?>
      <?php endif; ?>
      <?php if(!isset($errors['urltoken_timeover'])):?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
            <p>メールアドレス：<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></p>
            <input name="last" type="text" placeholder="姓" required>
            <input name="first" type="text" placeholder="名" required>
            <select name="occupation">
                <option value="学生">学生</option>
                <option value="社会人">社会人</option>
            </select><br>
            <input name="pass1" type="password" placeholder="パスワード" required><br>
            <input name="pass2" type="password" placeholder="パスワード(確認用)" required><br>
            <input name="token" type="hidden" value="<?=$token?>">
            <input name="btn_confirm" type="submit" value="確認する">
        </form>
      <?php endif; ?>
<?php endif; ?>
