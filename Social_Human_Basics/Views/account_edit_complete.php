<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_passwd = $user['password'];

// var_dump($_SESSION);

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

if (isset($_POST['password'])) {
  $passwd = filter_input(INPUT_POST, 'password');

  // パスワード照合
  if (password_verify($passwd, $user_passwd)) {
    // $_SESSION['form']の値を変数に格納
    $name = $_SESSION['form']['user_name'];
    $email = $_SESSION['form']['e_mail'];

    // 編集内容をDBに保存
    $result = $controller->accountUpdate($user_id, $name, $email);
    $_SESSION['form'] = array();
    $_SESSION['err'] = array();
    $_SESSION['pass_err'] = array();
    } else {
      $err = [];
      // パスワード不一致
      $err['password_err'] = 'パスワード不一致';
      $_SESSION['pass_err'] = $err;
      header('Location: account_edit_confirm.php');
      return;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>アカウント編集完了画面</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <!-- パスワード一致 -->
  <!-- パスワード不一致 -->
  <?php if($result):?>
  <section class="signup_register">
    <h2>編集完了</h2>
    <a href="mypage.php">マイページへ</a>
  </section>
  <?php endif;?>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
  <script src="./js/script.js"></script>
</body>
</html>
