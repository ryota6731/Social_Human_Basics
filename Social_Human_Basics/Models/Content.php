<?php
require_once(ROOT_PATH. '/Models/Db.php');

class Content extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  /**
   * 指定したIDのコンテンツ取得
   *
   * @param int $id
   * @return array $param
   */
  public function getContentByID($c_id = 0) {
    $sql = 'SELECT * FROM contents WHERE category_id = :c_id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':c_id', $c_id, PDO::PARAM_INT);

    $sth->execute();
    $param = $sth->fetch(PDO::FETCH_ASSOC);
    return $param;
  }

  /**
   * 指定カテゴリーIDのコンテンツ取得
   *
   * @return array $params
   */
  public function getAllContents() {
    $sql = 'SELECT id, name, category_id FROM contents ORDER BY category_id ASC';

    $sth = $this->dbh->prepare($sql);
    $sth->execute();

    $params = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $params;
  }

  public function pdfUpdateByCategoryId($file_name, $file_type, $content, $c_id) {
    $sql = 'UPDATE contents SET name = :name, file_type = :type, content = :content WHERE category_id = :c_id';

    $this->dbh->beginTransaction();
    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':name', $file_name, PDO::PARAM_STR);
      $sth->bindParam(':type', $file_type, PDO::PARAM_STR);
      $sth->bindParam(':content', $content, PDO::PARAM_STR);
      $sth->bindParam(':c_id', $c_id, PDO::PARAM_INT);
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      return $result;
    }
  }
}

?>
