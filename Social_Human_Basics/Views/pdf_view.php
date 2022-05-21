<?php
require_once(ROOT_PATH . '/Controllers/Controller.php');
session_start();

$controller = new Controller();

// ログインチェック
$controller->loginCheck();


$content = $controller->getContentByCategory();
// var_dump($content);

header("Content-Type: {$content['file_type']}");
echo $content['content'];
?>
