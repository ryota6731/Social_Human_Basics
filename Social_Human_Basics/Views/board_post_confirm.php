<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

$controller = new Controller();

// ログインチェック
$controller->loginCheck();

// // 投稿内容を変数に格納
// $contact = $_POST;
// // var_dump($contact);

// XSS
function h($data) {
  return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $err = [];

  $post = filter_input_array(INPUT_POST, $_POST);

  // バリデーション
  // タイトル
  if ($post['title'] === '') {
    $err['title'] = 'タイトルを入力して下さい';
  }

  if (mb_strlen($post['title'], 'UTF-8') > 100) {
    $err['title'] = '100文字以内で入力してください';
  }

  // 内容
  if ($post['content'] === '') {
    $err['content'] = '内容を入力して下さい';
  }
  if (mb_strlen($post['content'], 'UTF-8') > 500) {
    $err['content'] = '500文字以内で入力してください';
  }
  if (count($err) > 0) {
    $_SESSION['err'] = $err;
    header('Location: board_post.php');
    return;
  }

  // 以下をboard_top.phpで実行し投稿する
  if (count($err) === 0) {
    // 投稿内容をセッションに格納
    $_SESSION['contact'] = $_POST;
  }
}

/* 確認画面にPOSTの情報反映させる inputタグ変更 */
// ボタン押したらboard_top.phpへ遷移
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>掲示板投稿確認</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="accout_edit_container">
    <div class="account_edit_main">
      <h1>以下内容で、投稿しますか？</h1>
      <div class="confirm_box">
        <h2 class="label_text">タイトル</h2>
        <?php if(isset($post['title'])): ?>
          <p class="text_box"><?=h($post['title']); ?></p>
        <?php endif;?>
        <h2 class="label_text">内容</h2>
        <?php if(isset($post['content'])): ?>
          <p class="textarea_box"><?=h($post['content']); ?></p>
        <?php endif;?>
      </div>
      <div class="btn_position">
        <a class="post_submit" href="board_top.php">投稿する</a>
      </div>
    </div>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
