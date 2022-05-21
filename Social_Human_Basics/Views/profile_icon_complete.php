<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];

$controller = new Controller();

// ログインチェック
$controller->loginCheck();


// $_FILESの中身を変数に格納
$file = $_FILES['profile_img'];
$file_name = basename($file['name']);
$file_type = $file['type'];
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$file_size = $file['size'];
$upload_dir = ROOT_PATH .'public/img/';
$save_filename = date('YmdHis'). $file_name;
$save_path = $upload_dir. $file_name;

// ファイルのバリデーション
// ファイル形式
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

$err = [];

if (!in_array(strtolower($file_ext), $allow_ext)) {
  $err['img'] = '画像ファイルを添付してください。';
}

// ファイルサイズ
if($file_size > 5242880 || $file_err == 2) {
  $err['img_size'] = 'ファイルサイズは5MB未満にしてください';
}

if (count($err) > 0) {
  $_SESSION['err'] = $err;
  header('Location: profile_icon.php');
  return;
}

if (count($err) === 0) {
  // ファイルアップロード
  if (is_uploaded_file($tmp_path)) {
    if(move_uploaded_file($tmp_path, $save_path)){
      $up_comp = '変更完了しました';

      // DBのデータUPDATE(ファイル名、ファイルパス)
      $result = $controller->profileIconUpdate($user_id, $file_name, $save_path);
      if (!$result) {
        echo '失敗';
      }

    } else {
      $up_err = 'エラーのためやり直して下さい';
    }
  } else {
    $up_attack = 'おそらく何かしらの攻撃を受けました';
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
  <title>プログ画像編集完了画面</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="signup_register">
    <?php if(isset($up_comp)): ?>
      <h2><?=$up_comp; ?></h2>
    <?php endif; ?>
    <?php if(isset($up_err)): ?>
      <h2><?=$up_err; ?></h2>
    <?php endif; ?>
    <?php if(isset($up_attack)): ?>
      <h2><?=$up_attack; ?></h2>
    <?php endif; ?>
    <a href="mypage.php">マイページへ</a>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
  <script src="./js/script.js"></script>
</body>
</html>
