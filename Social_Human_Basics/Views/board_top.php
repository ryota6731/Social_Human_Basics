<?php
require_once(ROOT_PATH . '/Controllers//Controller.php');
require_once(ROOT_PATH . '/Models/Board.php');
session_start();

$controller = new Controller();
// var_dump($_SESSION);

// ログインチェック
$controller->loginCheck();

// ログインユーザID格納
$u_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

// 掲示板一覧
define('MAX', '5');
// 全ての投稿取得
$all_contacts = $controller->boardViewAll();
// var_dump($all_contacts['pages']);
$boards_num = $all_contacts['pages']; // 投稿されてる数
$max_page = ceil($boards_num / MAX);

if(!isset($_GET['page_id'])){ // $_GET['page_id'] はURLに渡された現在のページ数
  $now = 1; // 設定されてない場合は1ページ目にする
}else{
  $now = $_GET['page_id'];
}

$start_no = ($now - 1) * MAX; // 配列の何番目から取得すればよいか

// array_sliceは、配列の何番目($start_no)から何番目(MAX)まで切り取る関数
$disp_data = array_slice($all_contacts['boards'], $start_no, MAX, true);


// 投稿内容を変数に格納
if (isset($_SESSION['contact'])) {
  $post_contact = $_SESSION['contact'];

  // 投稿処理
  $result = $controller->boardPost($post_contact);

  // セッション削除
  unset($_SESSION['contact']);
  // ページ自動リロード
  header('Location: board_top.php');
}


// いいね
if (isset($_POST['postid'])) {
  $controller->good($_POST['postid'],$_SESSION['user']['id']);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>掲示板</title>
</head>

<body>
  <!-- header -->
  <?php require_once('../Views/header.php'); ?>
  <!-- /header -->
  <section class="board_container">
    <!-- main -->
    <h2 class="board_title">掲示板</h2>
    <?php if($role == 1): ?>
      <h2 class="board_title" style="color:red">管理者モード</h2>
    <?php endif; ?>
    <!-- 検索フォーム -->
    <form class="search_box" action="board_search.php" method="POST">
      <input class="search_form" type="text" name="search">
      <input type="submit" value="検索">
    </form>
    <a class="post_btn" href="board_post.php">投稿</a>
    <!-- 投稿一覧 -->
    <div class="board_box">
      <?php foreach ($disp_data as $contact) : ?>
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
            <?php if($contact['user_id'] === $u_id || $role == 1):?>
              <!-- 投稿編集 -->
              <a href="board_edit.php?id=<?=$contact['id'];?>">編集</a>
              <!-- 投稿削除 -->
              <a href="board_delete.php?id=<?=$contact['id'];?>&user_id=<?=$contact['user_id']; ?>" onclick="return confirm('削除しますか？')">削除</a>
            <?php endif;?>
          </div>
        <?php endforeach; ?>
        <!-- ページング -->
        <div class="paging">
          <?php
          if($now > 1){ // リンクをつけるかの判定
            echo "<a href=board_top.php?page_id=".($now - 1).">前へ</a>";
        } else {
            echo '前へ'. '　';
        }

        for($i = 1; $i <= $max_page; $i++){
            if ($i == $now) {
                echo $now;
            } else {
                echo "<a href=board_top.php?page_id=".$i.">".$i."</a>";
            }
        }

        if($now < $max_page){ // リンクをつけるかの判定
          echo "<a href=board_top.php?page_id=".($now + 1).">次へ</a>". '　';
      } else {
          echo '次へ';
      }
          ?>
        </div>
      </div>
    <!-- /main -->
  </section>
  <!-- footer -->
  <?php require_once('../Views/footer.php'); ?>
  <!-- /footer -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Ajax -->
  <script>
    $(function() {
      var $good = $('.btn_good');

      $good.on('click',function(e) {
        e.stopPropagation();
        var $this = $(this);

        goodPostId = $this.data('postid');

        $.ajax({
          type: 'POST',
          url: 'board_top.php',
          data: {postid: goodPostId}
        }).done(function(data){
          // クリックでボタンの色変更
          $this.toggleClass('btn_good_done');
        })
      });
    });
  </script>
</body>

</html>
