<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// 編集実行
// bool $result
if ($user_id === $_POST['user_id'] && isset($_POST)) {
  $controller->boardEdit();
  header('Location: board_top.php');
  return;
} else {
  echo '不正なリクエスト';
}








?>
