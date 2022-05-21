<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

$controller = new Controller();

// ログインチェック
$controller->loginCheck();

// ログインユーザID格納
$u_id = $_SESSION['user']['id'];

// 投稿内容検索
if (isset($_POST['search']) && !empty($_POST['search'])) {
  // 検索結果格納
  $search_result = $controller->getSearch();
  // var_dump($search_result);
} else {
  $no_result = '検索結果がありません';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>掲示板検索結果</title>
</head>
<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <!-- main -->
  <section class="board_container">
    <!-- 検索フォーム -->
    <h2 class="board_title">検索結果</h2>
    <form class="search_box" action="" method="POST">
      <input class="search_form" type="text" name="search">
      <input type="submit" value="検索">
    </form>
    <!-- 投稿一覧 -->
    <div class="board_box">
      <?php if(isset($search_result)): ?>
      <?php foreach ($search_result as $contact) : ?>
        <?php
          $icon_name = $controller->getProfileIcon($contact['user_id']);
          // var_dump($contact);
          ?>
        <table class="board_lists">
          <tr class="table_colum">
            <th></th>
            <th>name</th>
            <th>No.</th>
            <th>タイトル</th>
            <th>内容</th>
            <th>投稿日</th>
          </tr>
          <tr>
            <?php $good_judge = $controller->goodJudge($contact['id'], $_SESSION['user']['id']);
              ?>
              <td>
                <img class="board_icon" src="./img/<?=$icon_name['name'];?>" alt="プロフィール画像">
              </td>
              <td><?= $contact['name'] ?></td>
              <td><?= $contact['id'] ?></td>
              <td><?= $contact['title'] ?></td>
              <td><?= $contact['content'] ?></td>
              <td><?= $contact['updated_at'] ?></td>
            </tr>
          </table>
          <div class="board_btn_box">
            <!-- いいね解除状態 -->
            <?php if(!$good_judge): ?>
              <input class = "btn_good" type="button" value = "いいね" data-postid = "<?=$contact['id']; ?>">
            <?php endif; ?>
            <!-- いいね状態 -->
            <?php if($good_judge): ?>
              <input class = "btn_good btn_good_done" type="button" value = "いいね" data-postid = "<?=$contact['id']; ?>">
            <?php endif; ?>
            <?php if($contact['user_id'] === $u_id):?>
              <!-- 投稿編集 -->
              <a href="board_edit.php?id=<?=$contact['id'];?>">編集</a>
              <!-- 投稿削除 -->
              <a href="board_delete.php?id=<?=$contact['id'];?>&user_id=<?=$contact['user_id']; ?>" onclick="return confirm('削除しますか？')">削除</a>
            <?php endif;?>
          </div>
        <?php endforeach; ?>
        <?php else: ?>
          <h2 class="search_msg">該当の投稿が見つかりませんでした。</h2>
        <?php endif;?>
      </div>
  </section>
  <!-- /main -->
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
</body>
</html>
