<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$role = $_SESSION['user']['role'];
// var_dump($user);

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// 削除実行
if (($user_id === $_GET['user_id'] && isset($_GET)) || $role == 1) {
  $controller->deleteBoard();
  header('Location: board_top.php');
  return;
} else {
  echo '不正なリクエスト';
  return;
}








?>
