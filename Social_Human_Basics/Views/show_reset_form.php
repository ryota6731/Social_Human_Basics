<?php
require_once(ROOT_PATH . '/Controllers/Controller.php');
session_start();

$controller = new Controller();

// クエリからtokenを取得
$passwordResetToken = filter_input(INPUT_GET, 'token');

// tokenに合致するユーザーを取得

$passwordResetUser = $controller->tokenGetUser($passwordResetToken);

// 合致するユーザーがいなければ無効なトークンなので、処理を中断
if (!$passwordResetUser) exit('無効なURLです');

// 今回はtokenの有効期間を24時間とする
$tokenValidPeriod = (new \DateTime())->modify("-24 hour")->format('Y-m-d H:i:s');

// パスワードの変更リクエストが24時間以上前の場合、有効期限切れとする
if ($passwordResetUser->token_sent_at < $tokenValidPeriod) {
    exit('有効期限切れです');
}

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

// パスワードリセットフォームを読み込む
require_once('reset_form.php');
