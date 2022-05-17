<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = $user['id'];
$user_name = $user['name'];
$user_email = $user['email'];
$user_passwd = $user['password'];

$controller = new Controller();

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// パスワードチェック
if (isset($_POST['password'])) {
  $passwd = filter_input(INPUT_POST, 'password');

  // パスワード照合
  if (password_verify($passwd, $user_passwd)) {
    // 一致すればアカウント削除実行
    $result = $controller->accountDelete($user_id);

    // セッション初期化
    $_SESSION = array();
    session_destroy();
    } else {
      $err = [];

      // パスワード不一致
      $err['passwd'] = 'パスワードが違います';
      $_SESSION['err'] = $err['passwd'];
      header('Location: account_delete.php');
      return;
  }
}
