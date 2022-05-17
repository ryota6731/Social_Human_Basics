<?php
/*
・バリデーション
・POSTのデータセッションへ保存
*/
session_start();
if (isset($_SESSION['err'])) {
  $err = $_SESSION['err'];
}

// セッション初期化
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
  <title>アカウント作成</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- signup_form -->
  <section class="signup">
    <div class="signup_box">
      <form class="signup_form" action="./signup_register.php" method="POST">
        <h1>Sign Up</h1>

        <?php if(isset($err['username'])): ?>
          <?='<p class="err_msg">'.$err['username'].'</p>' ?>
        <?php endif; ?>
        <input name="user_name" type="text" placeholder="ニックネーム">

        <?php if(isset($err['email'])): ?>
          <?='<p class="err_msg">'.$err['email'].'</p>' ?>
        <?php endif; ?>
        <input name="e_mail" type="email" placeholder="メールアドレス">

        <?php if(isset($err['passwd'])): ?>
          <?='<p class="err_msg">'.$err['passwd'].'</p>' ?>
        <?php endif; ?>
        <input name="password" type="password" placeholder="パスワード">

        <?php if(isset($err['passwd_conf'])): ?>
          <?='<p class="err_msg">'.$err['passwd_conf'].'</p>' ?>
        <?php endif; ?>
        <input name="confirm_pass" type="password" placeholder="確認パスワード">

        <input type="submit" value="登録">
        <span>Already have an account?</span>
        <a href="login.php">Log In</a>
      </form>
    </div>
  </section>
  <!-- /signup_form -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
