<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = (int)$user['id'];

$controller = new Controller();
// var_dump($_SESSION);

// ログインチェック
$controller->loginCheck();

// XSS
function h($data) {
  return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// PDFファイル変更：管理者のみ
if (isset($user) && $user_id === 0) {

  // $_FILESの中身を変数に格納
  $file = $_FILES['pdf_file'];
  $file_name = basename($file['name']);
  $file_type = $file['type'];
  $tmp_path = $file['tmp_name'];
  $file_err = $file['error'];
  $file_size = $file['size'];

  // ファイルのバリデーション
  // ファイル形式
  $allow_ext = array('pdf');
  $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

  $err = [];

  if (!in_array(strtolower($file_ext), $allow_ext)) {
    $err['pdf'] = 'PDFファイルを添付してください。';
  }

  // ファイルサイズ
  if($file_err == 2) {
    $err['img_size'] = 'ファイルサイズが大きすぎます';
  }

  if (count($err) > 0) {
    foreach ($err as $err_msg) {
      echo $err_msg;
    }
  }

  if (count($err) === 0) {
    $c_id = filter_input(INPUT_POST, 'category_id');

    // ファイルアップロード
    $content = file_get_contents($tmp_path);

    // DBのデータUPDATE(カテゴリーID、ファイル名)
    $result = $controller->pdfUpdate($file_name, $file_type, $content, $c_id);
    if (!$result) {
      echo '失敗';
    } else {
      header('Location: contents_top.php');
      return;
    }
  }

} else {
  // 管理者以外の処理
  echo '適切なユーザではありません';
}
