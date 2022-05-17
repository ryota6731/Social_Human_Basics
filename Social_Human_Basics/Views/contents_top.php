<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

$controller = new Controller();
// var_dump($_SESSION);

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>コンテンツトップ</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <main class="contents_main">
      <div class="contents_title">
        <h2>社会人基礎力 ３大要素</h2>
      </div>
      <!-- contents -->
      <div class="contents_list">
        <a href="content1.php">
          <div class="contents_items">
            <h2>前に踏み出す力</h2>
            <p>進捗率:<span class="late_progress"> 30</span>%</p>
          </div>
        </a>
        <a href="content2.php">
          <div class="contents_items">
            <h2>考え抜く力</h2>
            <p>進捗率:<span class="late_progress"> 10</span>%</p>
          </div>
        </a>
        <a href="content3.php">
          <div class="contents_items">
            <h2>チームで働く力</h2>
            <p>進捗率:<span class="late_progress"> 90</span>%</p>
          </div>
        </a>
      </div>
      <!-- contents --> -->
  </main>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
