<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_name = $user['name'];
$user_email = $user['email'];
$user_passwd = $user['password'];

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// パスワードエラー取得
if (isset($_SESSION['err'])) {
  $err = $_SESSION['err'];
  $_SESSION['err'] = array();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>アカウント退会
  </title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="accout_edit_container">
    <div class="account_edit_main">
      <h1>＜退会するにはパスワードを入力してください＞</h1>
      <form class="account_edit_form" action="account_delete_complete.php" method="post">
        <!-- パスワード -->
        <?php if(!empty($err)):?>
          <label for="password">パスワード<?='<span id="err_msg">'.$err.'</span>' ?></label>
        <?php endif;?>
        <input name="password" type="password" placeholder="パスワード">

        <input type="submit" value="退会する">
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
