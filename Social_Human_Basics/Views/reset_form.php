<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>パスワードリセット</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- password_reset_form -->
  <section class="signup">
    <div class="signup_box">
        <form class="signup_form" action="reset.php" method="POST">
            <h1>Password recovery</h1>
            <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
            <input type="hidden" name="password_reset_token" value="<?= $passwordResetToken ?>">
            <input type="password" name="password" placeholder="new password">
            <input type="password" name="password_confirmation" placeholder="confirm password">
            <input type="submit" value="Reset Password">
        </form>
    </div>
  </section>
  <!-- /password_reset_form -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
