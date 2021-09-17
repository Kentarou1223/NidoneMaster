<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset ="UTF-8">
        <title>mission_6-02-pre registration</title>
    </head>
    <body>
        <h1>仮会員登録画面</h1>
        <form action="" method="post">
            <input name="adress1" type="text" placeholder="メールアドレス" required><br>
            <input name="adress2" type="text" placeholder="メールアドレス(確認用)" required><br>
            <input name="submit" type="submit"><br><hr>
        </form>
        <p>ログイン画面は<a href="login.phpのurl">こちら</a></p>
    </body>
</html>

<?php

if(isset($_POST["submit"])){

//メールアドレスが一致している時
if($_POST["adress1"]==$_POST["adress2"]){

//必要な関数を文字で定義
$adress1=$_POST["adress1"];

//０段階目：メールアドレス構文チェック
if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $adress1)){
    echo 'メールアドレスの形式が正しくありません。';
}//ここまでが０段階目
else {
    
//１段階目：DB(u)への重複の確認とDB(preu)への入力情報の登録
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  //１−１：DB(u)の確認
  $sql= "SELECT mail FROM tbmission_602u";
  $stm=$pdo->prepare($sql);
  $stm->execute();
  $result=$stm->fetchAll();
  $array=array_column($result, 'mail');
  if(in_array($adress1, $array)){
      echo "このメールアドレスは既に使用されています。";
  }//ここまでがDB(u)に既にメアドが存在した時の対応
  else {
  //1-2：DB(preu)に入力情報を登録
  $urltoken = hash('sha256', uniqid(rand(), 1));
  $url="https://ドメイン名/ユーザー名/本登録画面.php?urltoken=".$urltoken;
  $sql="INSERT INTO tbmission_602preu (urltoken, mail, create_date, flag) VALUES (:urltoken, :mail, now(), '0')";
  $stm=$pdo->prepare($sql);
  $stm->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
  $stm->bindParam(':mail', $adress1, PDO::PARAM_STR);
  $stm->execute();

//２段階目：認証メールの送信
    
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'setting.php';

// PHPMailerのインスタンス生成
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    $mail->SMTPAuth = true;
    $mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    $mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    $mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    $mail->Port = SMTP_PORT; // 接続するTCPポート

    // メール内容設定
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";
    $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    $mail->addAddress($adress1, '仮登録者'); //受信者（送信先）を追加する
//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
    $mail->Subject = MAIL_SUBJECT; // メールタイトル
    $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    $body = '■完全二度寝マスター ご利用登録について■<br><br>この度は完全二度寝マスターにご登録いただき、誠にありがとうございます。<br><br>お客様は現在、仮登録が完了した状態です。<br>登録を完了させるには、下記のURLをクリックしてください。<br><br>'.$url.'<br><br>※上記URLは仮登録から10分間有効です。それ以降はURLが無効となりますのでご注意ください。<br><br>※このメールはシステムが自動的にメール送信しています。<br><br>------------------------------------------------<br>完全二度寝マスター 運営担当<br>E-mail：naokishida69@gmail.com<br>TEL：××-××××-××××(内線××××)<br>------------------------------------------------<br>';

    $mail->Body  = $body; // メール本文
    // メール送信の実行
    if(!$mail->send()) {
    	echo 'メッセージは送られませんでした！';
    	echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    	echo 'この度は完全二度寝マスターに仮登録いただき誠にありがとうございます。<br><br>お客様のメールアドレスに本登録フォームを送信しました。<br>10分以内に本登録を完了してください。';
    }//ここ迄メールの送信：登録者にメールを送るプロセス
  }//ここまでが２段階目
}//ここまでが０段階目のelse
}//ここ迄：フォームメールアドレスが一致していた時
else { echo "メールアドレスが一致しません。再入力をお願いします。";
}//ここ迄：メアドが一致しなかった時
}//ここ迄：名前メアド等フォームへの入力があった際の対応
?>