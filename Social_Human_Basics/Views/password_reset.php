<?php
session_start();

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>パスワードリセット用メール送信</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- password_reset_form -->
  <section class="signup">
    <div class="signup_box">
      <form class="signup_form" action="reset_request.php" method="POST">
        <h1>Password recovery</h1>
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <input name="e_mail" type="email" placeholder="メールアドレス">
        <input type="submit" value="Reset Password">
        <a href="login.php">Log In</a>
      </form>
    </div>
  </section>
  <!-- /password_reset_form -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
