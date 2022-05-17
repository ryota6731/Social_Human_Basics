<?php
require_once(ROOT_PATH . '/Controllers/Controller.php');
session_start();

$controller = new Controller();

$request = filter_input_array(INPUT_POST);

// var_dump($request);


// csrf tokenが正しければOK
if (
    empty($request['_csrf_token'])
    || empty($_SESSION['_csrf_token'])
    || $request['_csrf_token'] !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

// 本来はここでパスワードのバリデーションをする


// tokenに合致するユーザーを取得
$passwordResetToken = $request['password_reset_token'];
// var_dump($passwordResetToken);

$passwordResetUser = $controller->tokenGetUser($passwordResetToken);
// var_dump($passwordResetUser);

// どのレコードにも合致しない無効なtokenであれば、処理を中断
if (!$passwordResetUser) exit('無効なURLです');

// テーブルに保存するパスワードをハッシュ化
$hashedPassword = password_hash($request['password'], PASSWORD_BCRYPT);

// パスワード更新
$controller->passwordUpdate($hashedPassword, $passwordResetUser);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>パスワード変更完了</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/login_header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="signup_register">
    <h2>パスワードの変更が完了しました。</h2>
    <a href="./login.php">ログイン画面へ</a>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
