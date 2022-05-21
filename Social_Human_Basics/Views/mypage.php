<?php
require_once(ROOT_PATH . '/Controllers/Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_name = $user['name'];

if ($login_check) {
  $userData = $controller->getUserById($user_id);
  $_SESSION['user'] = $userData;
  $user = $_SESSION['user'];
  $user_name = $user['name'];
}


// var_dump($_SESSION);


// プロフアイコン名取得
$icon_name = $controller->getProfileIcon($user_id);

// 進捗率取得
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>マイページ</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <main>
      <!-- mypage_header -->
      <div class="mypage_header">
        <!-- プロフィール画像はDBから取り出す -->
        <a href="profile_icon.php"><img class="mypage_icon" src="./img/<?=$icon_name['name'] ?>" alt="プロフィール画像"></a>
        <h2 class="mypage_name"><?=$user_name; ?></h2>
      </div>
      <!-- /mypage_header -->
      <!-- mypage_main -->
      <div class="mypage_progress">
        <div class="progress_items">
          <h2>前に踏み出す力</h2>
          <p>進捗率:<span class="late_progress"> 30</span>%</p>
        </div>
        <div class="progress_items">
          <h2>考え抜く力</h2>
          <p>進捗率:<span class="late_progress"> 10</span>%</p>
        </div>
        <div class="progress_items">
          <h2>チームで働く力</h2>
          <p>進捗率:<span class="late_progress"> 90</span>%</p>
        </div>
      </div>
      <div class="mypage_edit">
        <a class="account_edit_btn" href="./account_edit.php">アカウント編集</a>
        <a class="account_delete_btn" href="./account_delete.php">退会する</a>
      </div>
      <!-- /mypage_main -->
  </main>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
