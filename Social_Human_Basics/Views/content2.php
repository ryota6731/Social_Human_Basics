<?php
/**
 * ・イメージ画像表示（ディレクトリ管理）
 * ・画像クリックでPDF表示
 *
 * ＜管理人＞
 * PDFファイル変更
 */

require_once(ROOT_PATH . '/Controllers//Controller.php');
session_start();

// ログイン情報
$user = $_SESSION['user'];
$user_id = (int)$user['id'];
$role = (int)$_SESSION['user']['role'];

$controller = new Controller();
// var_dump($_SESSION);

// ログインチェック
$login_check = $controller->loginCheck();
if (!$login_check) {
  header('Location: login.php');
  exit();
}

// XSS
function h($data) {
  return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// 全コンテンツ情報取得
$params = $controller->getAllContents();
$kadai_id = $params[3]['category_id'];
$souzo_id = $params[4]['category_id'];
$plan_id = $params[5]['category_id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>考え抜く力 要素一覧</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="content_container">
    <div class="content_header">
      <h2>＜考え抜く力＞</h2>
      <div class="definition_box">
        <p class="definition_2">これは「疑問を持ち、考え抜く力」と定義されています。<br>課題を解決したり物事を改善したりするためには、常に問題意識を持ち課題を発見しなければなりません。<br>そして、課題をどうすれば解決できるのかという疑問を持ち、自律的に深く考える必要があります。</p>
      </div>
    </div>
    <div class="content_chapters">
      <!-- 課題発見力 -->
      <div class="chapter">
        <h2>・課題発見力：現状を分析し目的や課題を明らかにする力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=h($kadai_id);?>"><img class="chapter_img" src="img/kadai.jpg" alt="課題発見力"></a>
        <?php if($role === 1):?>
        <!-- 管理者専用 -->
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($kadai_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 創造力 -->
      <div class="chapter">
        <h2>・創造力：新しい価値を生み出す力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$souzo_id;?>"><img class="chapter_img" src="img/souzo.jpg" alt="働きかけ力"></a>
        <?php if($role === 1):?>
          <!-- 管理者専用 -->
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($souzo_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 計画力 -->
      <div class="chapter">
        <h2>・計画力：問題の解決に向けたプロセスを明らかにし準備する力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$plan_id;?>"><img class="chapter_img" src="img/plan.jpg" alt="実行力"></a>
        <!-- 管理者専用 -->
        <?php if($role === 1):?>
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($plan_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
