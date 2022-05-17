<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();


// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_passwd = $user['password'];

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// $_POSTの値を格納

$err = [];

$u_name = filter_input(INPUT_POST, 'user_name');
$email = filter_input(INPUT_POST, 'e_mail');

// バリデーション

if (mb_strlen($u_name) === 0) {
  $err['u_name'] = 'ニックネームが未入力です';
}

if (mb_strlen($email) === 0) {
  $err['email'] = 'メールアドレスが未入力です';
}


if (count($err) > 0 && !isset($_SESSION['err'])) {
  $_SESSION['err'] = $err;
  header('Location: account_edit.php');
  return;
}

// エラー０で完了画面へ
if (count($err) === 0) {
  $_SESSION ['form'] = $_POST;
}

if (isset($_SESSION['pass_err']['password_err'])) {
  $err_pass = $_SESSION['pass_err']['password_err'];

  $u_name = $_SESSION['form']['user_name'];
  $email = $_SESSION['form']['e_mail'];
  $_SESSION['pass_err'] = array();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>アカウント編集確認画面</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="accout_edit_container">
    <div class="account_edit_main">
      <h1>＜以下内容へ変更しますか？＞</h1>
      <div class="confirm_box">
        <h2 class="label_text">ニックネーム</h2>
        <?php if(isset($u_name)): ?>
          <p class="text_box"><?=$u_name; ?></p>
        <?php endif;?>
        <h2 class="label_text">メールアドレス</h2>
        <?php if(isset($u_name)): ?>
          <p class="text_box"><?=$email; ?></p>
        <?php endif;?>
      </div>
      <form class="submit_box" action="account_edit_complete.php" method="POST">
        <?php if(isset($err_pass)):?>
          <?='<p id="err_msg">'.$err_pass.'</p>'; ?>
        <?php endif;?>
        <label class="input_passwd" for="password">パスワードを入力して下さい</label>
        <input type="password" name="password" placeholder="確認パスワード">
        <input class="edit_btn" type="submit" value="変更する">
      </form>
    </div>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
  <script src="./js/script.js"></script>
</body>
</html>
