<?php
require_once(ROOT_PATH. '/Models/Db.php');

class Board extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  /**
   * 掲示板投稿
   *
   * @param array $contact
   * @param int $user_id
   * @return array
   */
  public function board_post($contact) {
    $result = false;

    $sql = 'INSERT INTO board (content, title, user_id) VALUES (:content, :title, :user_id)';

    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':content', $contact['content'], PDO::PARAM_STR);
    $sth->bindParam(':title', $contact['title'], PDO::PARAM_STR);
    $sth->bindParam(':user_id', $contact['user_id'], PDO::PARAM_INT);

    $this->dbh->beginTransaction();
    try {
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      return $result;
    }
  }

  /**
   * 掲示板一覧
   *
   * @return array
   */
  public function board_view():Array {

    $sql = 'SELECT b.id, b.title, b.content, b.user_id, b.updated_at, u.name FROM board as b INNER JOIN users as u ON b.user_id = u.id ORDER BY updated_at DESC';

    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

      /**
       * playersテーブルから全データ数を取得
       *
       * @return Int $count 全選手の件数
       */
      public function countAll():Int {
        $sql = 'SELECT count(*) as count FROM board';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }

  public function boardSearch($post) {
    $sql = 'SELECT * FROM board as b INNER JOIN users as u ON b.user_id = u.id WHERE content LIKE :content ORDER BY updated_at DESC';

    $sth = $this->dbh->prepare($sql);

    $post = '%'.$post.'%';
    $sth->bindParam(':content',$post,PDO::PARAM_STR);
    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * 指定IDの投稿を取得
   *
   * @param int $id
   * @return array
   */
  public function findById($id = 0):array {
    $sql = 'SELECT id, user_id, title, content FROM board WHERE id = :id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();

    $param = $sth->fetch(PDO::FETCH_ASSOC);
    return $param;
  }

  /**
   * 掲示板投稿編集、実行
   *
   * @param array $contact
   * @return bool
   */
  public function editBoard($post) {
    $sql = 'UPDATE board SET title = :title, content = :content WHERE id = :id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':title', $post['title'], PDO::PARAM_STR);
    $sth->bindParam(':content', $post['content'], PDO::PARAM_STR);
    $sth->bindParam(':id', $post['id'], PDO::PARAM_INT);

    $this->dbh->beginTransaction();
    try {
      $sth->execute();
      $this->dbh->commit();
      return true;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      return false;
    }
  }

  /**
   * 指定IDの投稿削除（自分の投稿のみ）
   *
   * @return bool
   */
  public function deleteBoard($id = 0) {
    $sql = 'DELETE FROM board WHERE id = :id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':id', $id, PDO::PARAM_INT);

    $this->dbh->beginTransaction();
    try {
      $sth->execute();
      $this->dbh->commit();
      return true;
    } catch (PDOException $e) {
      echo '失敗';
      $this->dbh->rollBack();
      return false;
    }
  }

  /**
   * いいね実行
   *
   * @param array $post
   * @param int $user_id
   * @return bool
   */
  public function ajaxGood($post, $user_id) {

    $sql = 'INSERT INTO goods (board_id, user_id) VALUES (:b_id, :u_id)';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':b_id', $post, PDO::PARAM_INT);
    $sth->bindParam(':u_id', $user_id, PDO::PARAM_INT);

    $this->dbh->beginTransaction();
    try {
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      $result = '失敗';
      return $result;
    }

  }

  /**
   * いいね解除
   *
   * @param array $post
   * @param int $user_id
   *
   */
  public function ajaxGoodDelete($post, $user_id) {
    $sql = 'DELETE FROM goods WHERE board_id = :b_id AND user_id = :u_id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':b_id', $post, PDO::PARAM_INT);
    $sth->bindParam(':u_id', $user_id, PDO::PARAM_INT);

    $this->dbh->beginTransaction();
    try {
      $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      $this->dbh->rollback();
      $result = '失敗';
      return $result;
    }
  }

  /**
   * 指定のgoodsテーブルレコードチェック
   *
   * @param array $post
   * @param int $user_id
   * @return array
   */
  public function goodCheck($post, $user_id) {
    $sql = 'SELECT * FROM goods WHERE board_id = :b_id AND user_id = :u_id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':b_id', $post, PDO::PARAM_INT);
    $sth->bindParam(':u_id', $user_id, PDO::PARAM_INT);

    try {
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      $result = '失敗';
      return $result;
    }
  }

}


?>
