<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

$controller = new Controller();

// POSTで受け取りチェックする

// ログインチェック
$result  = $controller->loginCheck();
if (!$result) {
  exit('セッションが切れたため再度ログインして下さい');
}

// ログアウト
$controller->logout();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>ログアウト</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="signup_register">
    <h2>ログアウト完了</h2>
    <a href="./login.php">ログイン画面へ</a>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
