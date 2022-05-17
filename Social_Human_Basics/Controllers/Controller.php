<?php
require_once(ROOT_PATH. '/Models/UserLogic.php');
require_once(ROOT_PATH. '/Models/Board.php');
require_once(ROOT_PATH. '/Models/Content.php');

class Controller {
  private $request;
  private $UserLogic;
  private $Board;
  private $Content;

  public function __construct() {
    // リクエストパラメータ取得
    $this->request['post'] = $_POST;
    $this->request['get'] = $_GET;

    // モデルオブジェクト生成
    $this->UserLogic = new UserLogic();
    $this->Board = new Board();
    $this->Content = new Content();
  }

  // ユーザ関連
  // ユーザ登録
  public function createUser() {

    $this->UserLogic->createUser($this->request['post']);

  }

  // アカウント編集実行
  public function accountUpdate($u_id, $name, $email) {
    $result = $this->UserLogic->account_edit($u_id, $name, $email);
    return $result;
  }

  // アカウント削除
  public function accountDelete($id = 0) {
    $result = $this->UserLogic->account_delete($id);
    return $result;
  }

  // プロフィールアイコンアップロード実行
  public function profileIconSave($u_id, $file_name, $save_path) {
    $result = $this->UserLogic->profile_icon_save($u_id, $file_name, $save_path);
    return $result;
  }

    // プロフィールアイコンUPDATE実行
    public function profileIconUpdate($u_id, $file_name, $save_path) {
      $result = $this->UserLogic->profile_icon_update($u_id, $file_name, $save_path);
      return $result;
    }

    // プロフィールのアイコンファイル名取得
    public function getProfileIcon($u_id) {
      $result = $this->UserLogic->get_icon_name_by_id($u_id);
      return $result;
    }

  // 掲示板関係
  // 掲示板一覧
  public function boardViewAll() {

    $board_count = $this->Board->countAll();
    $board = $this->Board->board_view();


    $params = [
      'boards' => $board,
      'pages' => $board_count
    ];

    return $params;
  }

  // 掲示板投稿
  public function boardPost($contact) {

    $this->Board->board_post($contact);

  }

  // 掲示板投稿編集：実行
  public function boardEdit() {
    $post = $this->request['post'];

    $result = $this->Board->editBoard($post);
    return $result;
  }

  // 投稿編集：指定IDの投稿を取得
  public function getContentByID() {
    $b_id = $this->request['get']['id'];

    $param = $this->Board->findById($b_id);
    return $param;
  }

  // 投稿削除
  public function deleteBoard() {
    $b_id = $this->request['get']['id'];
    $this->Board->deleteBoard($b_id);
  }

  // 検索結果
  public function getSearch() {
    $post = $this->request['post']['search'];
    $params = $this->Board->boardSearch($post);
    return $params;
  }



  public function goodJudge($p_id, $user_id) {

    $result = $this->Board->goodCheck($p_id, $user_id);

    if (!empty($result)) {
      // いいねしてる
      return true;
    } else {
      // いいねしてない
      return false;
    }

  }

  // Ajaxいいね
  public function good($p_id,$user_id) {

    $judge = $this->goodJudge($p_id,$user_id);

    if ($judge) {
      // いいね解除
      $this->Board->ajaxGoodDelete($p_id, $user_id);
    } else {
      echo '解除';
      // いいね実行
      $this->Board->ajaxGood($p_id, $user_id);
    }
  }

  // 指定IDのユーザデータ取得
  public function getUserByID($id) {
    $params = $this->UserLogic->get_user_by_id($id);
    return $params;
  }

  // ログイン状態チェック
  public function loginCheck() {
    $result = false;

    if (isset($_SESSION['user']) && isset($_SESSION['user']['id']) > 0) {
      return $result = true;
    }

    return $result;
  }

  // ログアウト
  public function logout() {
    $_SESSION = array();
    session_destroy();
  }

  // 指定カテゴリーIDのコンテンツ取得
  public function getContentByCategory() {
    $get = $this->request['get']['category_id'];

    $param = $this->Content->getContentByID($get);
    return $param;
  }

  // 全コンテンツ取得
  public function getAllContents() {
    $params = $this->Content->getAllContents();
    return $params;
  }

  // PDFアップデート
  public function pdfUpdate($file_name, $file_type, $content, $c_id) {
    $result = $this->Content->pdfUpdateByCategoryId($file_name, $file_type, $content, $c_id);

    return $result;
  }

  // 以下からパスワードリセット

  /**
   * テーブルにemailあるかチェック
   *
   * @param string $email
   * @return bool $result
   */
  public function checkEmail($email) {
    $result = $this->UserLogic->check_email($email);

    return $result;
  }

  /**
   * トークン生成しメール送信
   *
   * @param string $email
   */
  public function tokenUrlSend($email) {

    $test = $this->UserLogic->token_create_email_send($email);

    return $test;
  }

  // tokenに合致するユーザーを取得
  public function tokenGetUser($token) {
    $result = $this->UserLogic->token_get_user($token);

    return $result;
  }

  public function passwordUpdate($hashedPassword, $passwordResetUser) {
    $this->UserLogic->passwd_update($hashedPassword, $passwordResetUser);
  }
}
?>
