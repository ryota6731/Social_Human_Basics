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
$hasshin_id = $params[6]['category_id'];
$keicho_id = $params[7]['category_id'];
$junan_id = $params[8]['category_id'];
$haaku_id = $params[9]['category_id'];
$kiritsu_id = $params[10]['category_id'];
$stress_id = $params[11]['category_id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>チームで働く力 要素一覧</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="content_container">
    <div class="content_header">
      <h2>＜チームで働く力＞</h2>
      <div class="definition_box">
        <p class="definition_2">これは「多様な人々とともに、目標に向けて協力する力」と定義されています。<br>個人で大きな成果をあげようとしても、一人でできることには限界があります。そこで、多様な人との協働が求められます。<br>多様な人と協働するためには、自分の意見をわかりやすく相手に伝えることはもちろん、<br>相手の意見や立場を尊重し目標に向けて協力しあうことが必要です。</p>
      </div>
    </div>
    <div class="content_chapters">
      <!-- 発信力 -->
      <div class="chapter">
        <h2>・発信力：自分の意見を分かりやすく伝える力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=h($hasshin_id);?>"><img class="chapter_img" src="img/hasshin.jpg" alt="課題発見力"></a>
        <?php if($role === 1):?>
        <!-- 管理者専用 -->
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($hasshin_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 傾聴力 -->
      <div class="chapter">
        <h2>・傾聴力：相手の意見を丁寧に聴く力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$keicho_id;?>"><img class="chapter_img" src="img/keicho.jpg" alt="働きかけ力"></a>
        <?php if($role === 1):?>
          <!-- 管理者専用 -->
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($keicho_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 柔軟性 -->
      <div class="chapter">
        <h2>・柔軟性：意見の違いや立場の違いを理解する力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$junan_id;?>"><img class="chapter_img" src="img/junan.jpg" alt="実行力"></a>
        <!-- 管理者専用 -->
        <?php if($role === 1):?>
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($junan_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 情況把握力 -->
      <div class="chapter">
        <h2>・情況把握力：自分と周囲の人々や物事との関係性を理解する力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$haaku_id;?>"><img class="chapter_img" src="img/jokyo.jpg" alt="実行力"></a>
        <!-- 管理者専用 -->
        <?php if($role === 1):?>
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($haaku_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 規律性 -->
      <div class="chapter">
        <h2>・規律性：社会のルールや人との約束を守る力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$kiritsu_id;?>"><img class="chapter_img" src="img/kiritsu.jpg" alt="実行力"></a>
        <!-- 管理者専用 -->
        <?php if($role === 1):?>
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($kiritsu_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 柔軟性 -->
      <div class="chapter">
        <h2>・ストレスコントロール力：ストレスの発生源に対応する力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$stress_id;?>"><img class="chapter_img" src="img/stress.jpg" alt="実行力"></a>
        <!-- 管理者専用 -->
        <?php if($role === 1):?>
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($stress_id);?>">
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
