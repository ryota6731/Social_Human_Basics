<?php
require_once(ROOT_PATH . '/Controllers/Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];

$controller = new Controller();

// ログインチェック
$controller->loginCheck();

//  DBから登録情報取得しテキストボックスに表示させる

// バリデーション
if (isset($_SESSION['err'])) {
  $err = $_SESSION['err'];
}
// var_dump($err);
$_SESSION['err'] = array();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>プロフィール画像変更</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="accout_edit_container">
    <div class="account_edit_main">
      <h1>＜画像を添付してください＞</h1>
      <form class="account_edit_form" action="profile_icon_complete.php" method="post" enctype="multipart/form-data">
        <!-- プロフ画像 -->
        <?php if(isset($err['img'])):?>
          <label>プロフィール画像変更<?='<span id="err_msg">'.$err['img'].'</span>' ?></label>
        <?php endif;?>
        <?php if(isset($err['img_size'])):?>
          <label>プロフィール画像変更<?='<span id="err_msg">'.$err['img_size'].'</span>' ?></label>
        <?php endif;?>
        <input type="hidden" name="MAX_FILE_SIZE" value ="5242880">
        <input type="file" name="profile_img" accept="image/*" onchange="preview_image(this)">
        <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">

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
