<?php
require_once(ROOT_PATH . '/Controllers/Controller.php');
session_start();

$controller = new Controller();
// var_dump($_SESSION);

$csrfToken = filter_input(INPUT_POST, '_csrf_token');

// csrf tokenを検証
if (
    empty($csrfToken)
    || empty($_SESSION['_csrf_token'])
    || $csrfToken !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}
// 本来はここでemailのバリデーションもかける
$email = filter_input(INPUT_POST, 'e_mail');
// emailがusersテーブルに登録済みか確認
$user = $controller->checkEmail($email);

// 未登録のメールアドレスであっても、送信完了画面を表示
// 「未登録です」と表示すると、万が一そのメールアドレスを知っている別人が入力していた場合、「このメールアドレスは未登録である」と情報を与えてしまう
if (!$user) {
    require_once('email_sent.php');
    exit();
}

// トークン生成しメール送信
$controller->tokenUrlSend($email);

// 送信済み画面を表示
require_once('email_sent.php');
