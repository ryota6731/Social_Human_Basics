<?php
require_once(ROOT_PATH.'/Models/Db.php');
require_once(ROOT_PATH.'/Models/UserLogic.php');
require_once(ROOT_PATH . '/Controllers//Controller.php');
session_start();

$email = "";
$password = "";

/* バリデーション */
if (!empty($_POST)) {

  $email = $_POST['e_mail'];
  $password = $_POST['password'];

  $UserLogic = new UserLogic();
  $UserLogic->login($email, $password);

  $user = $_SESSION['user'];
  // var_dump($user);
}

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>メインページ</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <main>
    <section  class="main_page">
      <div class="main_img1">
        <a href="board_top.php"><img src="img/BBS_logo.jpg" alt="掲示板TOP"></a>
      </div>
      <div class="main_img2">
        <a href="contents_top.php"><img src="img/content_logo.jpg" alt="メインコンテンツ"></a>
      </div>
    </section>
  </main>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
