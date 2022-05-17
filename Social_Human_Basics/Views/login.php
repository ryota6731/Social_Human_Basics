<?php
/**
 * omaze
 * test@test.com
 * mongoru7
 *
 * 管理者
 * admin
 * admin@admin.com
 * admin1234
 */
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
require_once(ROOT_PATH. '/Models/UserLogic.php');
session_start();


if (isset($_SESSION['err'])) {
  $err_msg = $_SESSION['err'];
}

$_SESSION = array();
session_destroy();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>ログイン画面</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- login_form -->
  <section class="login">
    <div class="login_box">
      <form class="login_form" action="main.php" method="POST">
        <?php if(isset($err_msg)): ?>
          <p class="err_msg"><?=$err_msg ?></p>
        <?php endif; ?>
        <h1>Login</h1>
        <input name="e_mail" type="email" placeholder="e-mail">
        <input name="password" type="password" placeholder="password">
        <input type="submit" value="login">
        <a href="signup.php">Sign Up</a><br>
        <a href="password_reset.php">Forgot password ?</a>
      </form>
    </div>
  <div class="side_box">
    <img src="img/kisoryoku_logo.jpeg">
  </div>
  </section>
  <!-- /login_form -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
