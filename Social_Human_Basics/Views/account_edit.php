<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_name = $user['name'];
$user_email = $user['email'];

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

//  DBから登録情報取得しテキストボックスに表示させる

// バリデーション
if (isset($_SESSION['err'])) {
  $err = $_SESSION['err'];
}
$_SESSION['err'] = array();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>アカウント編集</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="accout_edit_container">
    <div class="account_edit_main">
      <h1>＜編集する内容を入力して下さい＞</h1>
      <form class="account_edit_form" action="./account_edit_confirm.php" method="post" enctype="multipart/form-data">
        <!-- ニックネーム -->
        <?php if(isset($err['u_name'])):?>
          <label for="user_name">ニックネーム<?='<span id="err_msg">'.$err['u_name'].'</span>' ?></label>
        <?php endif;?>
        <input name="user_name" type="text" placeholder="ニックネーム">

        <!-- メールアドレス -->
        <?php if(isset($err['email'])):?>
          <label for="e_mail">メールアドレス<?='<span id="err_msg">'.$err['email'].'</span>' ?></label>
        <?php endif;?>
        <input name="e_mail" type="email" placeholder="メールアドレス">
        <input type="submit" value="確認">
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
