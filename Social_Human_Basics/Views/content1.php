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
$syutai_id = $params[0]['category_id'];
$hataraki_id = $params[1]['category_id'];
$jikkou_id = $params[2]['category_id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>前に踏み出す力 要素一覧</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="content_container">
    <div class="content_header">
      <h2>＜前に踏み出す力＞</h2>
      <div class="definition_box">
        <p class="definition_1">「一歩前に踏み出し、失敗しても粘り強く取り組む力」と定義されている能力です。<br>例えば、学校の勉強では正解が1つと決まっているものが多くありますが、実社会で仕事をしていると、<br>正解が1つに決まっているケースは極めて少ないものです。<br>そのため、正解が分からない中でも失敗を恐れずに前に踏み出す力が求められます。<br>仮に失敗しても、周りの人の協力を得ながら試行錯誤を繰り返し、粘り強く取り組むことが大切です。</p>
      </div>
    </div>
    <div class="content_chapters">
      <!-- 主体性 -->
      <div class="chapter">
        <h2>・主体性：物事に進んで取り組む力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=h($syutai_id);?>"><img class="chapter_img" src="img/syutai.jpg" alt="主体性"></a>
        <?php if($role === 1):?>
        <!-- 管理者専用 -->
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($syutai_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 働きかけ力 -->
      <div class="chapter">
        <h2>・働きかけ力：他人に働きかけ巻き込む力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$hataraki_id;?>"><img class="chapter_img" src="img/hataraki.jpg" alt="働きかけ力"></a>
        <?php if($role === 1):?>
          <!-- 管理者専用 -->
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($hataraki_id);?>">
            <input type="submit" value="変更する">
          </form>
        <?php endif; ?>
      </div>
      <!-- 実行力 -->
      <div class="chapter">
        <h2>・実行力：目的を設定し確実に行動する力</h2>
        <a class="chapter_img_link" href="pdf_view.php?category_id=<?=$jikkou_id;?>"><img class="chapter_img" src="img/jikkou.jpg" alt="実行力"></a>
        <!-- 管理者専用 -->
        <?php if($role === 1):?>
          <form action="content_pdf_edit.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="pdf_file" accept="application/pdf">
            <input type="hidden" name="category_id" value="<?=h($jikkou_id);?>">
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
