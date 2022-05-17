<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');

$controller = new Controller();
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// XSS
function h($data) {
  return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// バリデーション: err_msg
if (isset($_SESSION['err'])) {

  $err_msg = $_SESSION['err'];
  unset($_SESSION['err']);

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>掲示板投稿</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="accout_edit_container">
    <div class="account_edit_main">
    <h1>投稿内容を入力してください</h1>
      <form class="account_edit_form" action="board_post_confirm.php" method="POST">
        <?php if(isset($err_msg['title'])): ?>
          <?='<p id="err_msg">'.$err_msg['title'].'</p>' ?>
        <?php endif; ?>
        <label for="title">タイトル</label>
        <input name="title" type="text">
        <?php if(isset($err_msg['content'])): ?>
          <?='<p id="err_msg">'.$err_msg['content'].'</p>' ?>
        <?php endif; ?>
        <label for="content">内容</label>
        <textarea class="text_area" name="content" cols="30" rows="10" style="white-space:pre-wrap;"></textarea>
        <input type="hidden" name="user_id" value="<?=h($user_id); ?>">
        <input type="submit" value="確認">
      </form>
    </div>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
