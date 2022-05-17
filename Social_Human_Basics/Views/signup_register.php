<?php
require_once(ROOT_PATH .'/Controllers/Controller.php');
require_once(ROOT_PATH .'/Models/UserLogic.php');
session_start();

$controller = new Controller();

$err = [];
// バリデーション
// ニックネーム
if (!$username = filter_input(INPUT_POST, 'user_name')) {
  $err['username'] = 'ニックネームを記入して下さい';
}

// メールアドレス
if (!$email = filter_input(INPUT_POST, 'e_mail')) {
  $err['email'] = 'メールアドレスを入力して下さい';
}

// パスワード
$passwd = filter_input(INPUT_POST, 'password');
if (empty($passwd)) {
  $err['passwd'] = 'パスワードを入力して下さい';
}
if (!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i", $passwd)) {
  $err['passwd'] = 'パスワードは半角英数字を含む8文字以上100字以内にして下さい';
}
// 確認パスワード
$passwd_conf = filter_input(INPUT_POST, 'confirm_pass');
if ($passwd !== $passwd_conf) {
  $err['passwd_conf'] = '確認用パスワードが一致しません';
}

if (count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: signup.php');
  return;
}

if (count($err) === 0) {
  // ユーザ登録処理
  $hasCreated = $controller->createUser();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>アカウント作成完了</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- signup_form -->
  <section class="signup_register">
    <h2>アカウント作成完了</h2>
    <a href="./login.php">ログイン画面へ</a>
  </section>
  <!-- /signup_form -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
