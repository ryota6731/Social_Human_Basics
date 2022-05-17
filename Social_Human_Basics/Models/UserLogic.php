<?php
require_once(ROOT_PATH .'/Models/Db.php');

class UserLogic extends Db {

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  /**
   * ユーザを登録する
   *
   * @param array $UserData
   * @return bool $result
   */
  public function createUser($userData) {
    $result = false;

    $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
    $sth = $this->dbh->prepare($sql);

    $pass_hash = password_hash($userData['password'], PASSWORD_DEFAULT);


    $sth->bindParam(':name', $userData['user_name'], PDO::PARAM_STR);
    $sth->bindParam(':email', $userData['e_mail'], PDO::PARAM_STR);
    $sth->bindParam(':password', $pass_hash, PDO::PARAM_STR);

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
   * ログイン
   *
   * @param string $email
   * @param string $passwd
   * @return array
   */
  public function login($email, $passwd) {
    $result = false;

    $sql = 'SELECT * FROM users WHERE email = :email';
    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':email', $email, PDO::PARAM_STR);

    try {
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);

      if (password_verify($passwd, $result['password'])) {
        $_SESSION['user'] = $result;
        return $result = true;
      } else {
        $_SESSION['err'] = 'メールアドレスまたはIDが間違っています';
        header('Location: login.php');
        return $result;
      }

    } catch (PDOException $e) {
      echo 'しっぱい';
    }
  }

  public function get_user_by_id($id = 0) {
    $sql = 'SELECT * FROM users WHERE id = :id';

    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  /**
   * プロフィールアイコンアップロード
   * @param string $file_name ファイル名
   * @param string $save_path 保存パス
   *
   * @return bool $result
   */
  public function profile_icon_save($u_id, $file_name, $save_path) {
    $result = false;

    $sql = 'INSERT profile_images (user_id,name, path) VALUE (:u_id, :name, :path)';

    $this->dbh->beginTransaction();
    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':u_id', $u_id, PDO::PARAM_INT);
      $sth->bindParam(':name', $file_name, PDO::PARAM_STR);
      $sth->bindParam(':path', $save_path, PDO::PARAM_STR);
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      return $result;
    }
  }

    /**
   * プロフィールアイコンUPDATE
   * @param int $u_id ユーザID
   * @param string $file_name ファイル名
   * @param string $save_path 保存パス
   *
   * @return bool $result
   */
  public function profile_icon_update($u_id, $file_name, $save_path) {
    $result = false;

    $sql = 'UPDATE profile_images SET name = :name, path = :path WHERE user_id = :u_id';

    $this->dbh->beginTransaction();
    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':u_id', $u_id, PDO::PARAM_INT);
      $sth->bindParam(':name', $file_name, PDO::PARAM_STR);
      $sth->bindParam(':path', $save_path, PDO::PARAM_STR);
      $result = $sth->execute();
      $this->dbh->commit();
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      return $result;
    }
  }

  /**
   * 指定IDのアイコン取得
   * @param int $u_id ユーザID
   *
   * @return array $result
   */
  public function get_icon_name_by_id($u_id) {
    $sql = 'SELECT name FROM profile_images WHERE user_id = :u_id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':u_id', $u_id, PDO::PARAM_INT);

    try {
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      return;
    }
  }

  /**
   * パスワード照合
   *
   * @param string $u_id
   * @param string $passwd
   * @return bool $result
   */
  public function passwd_check($u_id, $passwd) {
    $result = false;

    $sql = 'SELECT * FROM users WHERE email = :email';
    $sth = $this->dbh->prepare($sql);

    $sth->bindParam(':email', $email, PDO::PARAM_STR);

    try {
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);

      if (password_verify($passwd, $result['password'])) {
        $_SESSION['user'] = $result;
        return $result = true;
      } else {
        $_SESSION['err'] = 'メールアドレスまたはIDが間違っています';
        header('Location: login.php');
        return $result;
      }

    } catch (PDOException $e) {
      echo 'しっぱい';
    }
  }

  /**
   * アカウント編集
   *
   * @param string $name
   * @param string $email
   * @param int $u_id
   * @return bool $result
   */
  public function account_edit($u_id, $name, $email) {
    $result = false;

    $sql = 'UPDATE users SET name = :name, email = :email WHERE id = :u_id';
    $sth = $this->dbh->prepare($sql);


    $sth->bindParam(':name', $name, PDO::PARAM_STR);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);
    $sth->bindParam(':u_id', $u_id, PDO::PARAM_INT);

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
   * 指定IDのアカウント削除
   *
   * @param int $id
   * @return bool $result
   */
  public function account_delete($id = 0) {
    $result = false;

    $sql = 'DELETE FROM users WHERE id = :id LIMIT 1';

    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);

    $this->dbh->beginTransaction();
    try {
      $result = $sth->execute();
      $this->dbh->commit();
      echo 'ok';
      return $result;
    } catch (PDOException $e) {
      $this->dbh->rollBack();
      echo 'no';
      return $result;
    }

  }

  public function check_email($email) {
    // emailがusersテーブルに登録済みか確認
    $sql = 'SELECT * FROM users WHERE email = :email';

    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);
    $sth->execute();
    $user = $sth->fetch(\PDO::FETCH_OBJ);

    return $user;
  }

  public function token_create_email_send($email) {
    // 既にパスワードリセットのフロー中（もしくは有効期限切れ）かどうかを確認
    // $passwordResetUserが取れればフロー中、取れなければ新規のリクエストということ
    $sql = 'SELECT * FROM password_resets WHERE email = :email';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':email', $email, \PDO::PARAM_STR);
    $sth->execute();
    $passwordResetUser = $sth->fetch(\PDO::FETCH_OBJ);

    if (!$passwordResetUser) {
        // $passwordResetUserがいなければ、仮登録としてテーブルにインサート
        $sql = 'INSERT INTO `password_resets`(`email`, `token`, `token_sent_at`) VALUES(:email, :token, :token_sent_at)';
    } else {
        // 既にフロー中の$passwordResetUserがいる場合、tokenの再発行と有効期限のリセットを行う
        $sql = 'UPDATE `password_resets` SET `token` = :token, `token_sent_at` = :token_sent_at WHERE `email` = :email';
    }

    // password reset token生成
    $passwordResetToken = bin2hex(random_bytes(32));

    // password_resetsテーブルへの変更とメール送信は原子性を保ちたいため、トランザクションを設置する
    // メール送信に失敗した場合は、パスワードリセット処理自体も失敗させる
    try {
        $this->dbh->beginTransaction();

        $token_sent_at = (new \DateTime())->format('Y-m-d H:i:s');

        // ユーザーを仮登録
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':email', $email, \PDO::PARAM_STR);
        $sth->bindParam(':token', $passwordResetToken, \PDO::PARAM_STR);
        $sth->bindParam(':token_sent_at', $token_sent_at, \PDO::PARAM_STR);
        $sth->execute();

        // 以下、mail関数でパスワードリセット用メールを送信
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        // URLはご自身の環境に合わせてください
        $url = "http://localhost/show_reset_form.php?token={$passwordResetToken}";

        $subject =  'パスワードリセット用URLをお送りします';

        $body = <<<EOD
            24時間以内に下記URLへアクセスし、パスワードの変更を完了してください。
            {$url}
            EOD;

        // Fromはご自身の環境に合わせてください
        $headers = "From : hoge@hoge.com\n";
        // text/htmlを指定し、html形式で送ることも可能
        $headers .= "Content-Type : text/plain";

        // mb_send_mailは成功したらtrue、失敗したらfalseを返す
        $isSent = mb_send_mail($email, $subject, $body, $headers);

        if (!$isSent) throw new \Exception('メール送信に失敗しました。');

        // メール送信まで成功したら、password_resetsテーブルへの変更を確定
        $this->dbh->commit();

    } catch (\Exception $e) {
        $this->dbh->rollBack();

        exit($e->getMessage());
    }
  }

  /**
   * // tokenに合致するユーザーを取得
   *
   * @param string $passwordResetToken
   * @return array $passwordResetUser
   */
  public function token_get_user($token) {

    $sql = 'SELECT * FROM `password_resets` WHERE `token` = :token';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':token', $token, \PDO::PARAM_STR);
    $sth->execute();
    $passwordResetUser = $sth->fetch(\PDO::FETCH_OBJ);

    return $passwordResetUser;
  }

  /**
   * 該当ユーザーのパスワードを更新
   *
   * @param string $hashedPassword
   * @param array $passwordResetUser
   * @return void
   */
  public function passwd_update($hashedPassword, $passwordResetUser) {
    $sql = 'UPDATE `users` SET `password` = :password WHERE `email` = :email';

    $this->dbh->beginTransaction();
    try {
      // 該当ユーザーのパスワードを更新
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
      $sth->bindValue(':email', $passwordResetUser->email, \PDO::PARAM_STR);
      $sth->execute();

      // 用が済んだので、パスワードリセットテーブルから削除
      $sql = 'DELETE FROM `password_resets` WHERE `email` = :email';
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':email', $passwordResetUser->email, \PDO::PARAM_STR);
      $sth->execute();

      $this->dbh->commit();

  } catch (\Exception $e) {
      $this->dbh->rollBack();

      exit($e->getMessage());
  }
  }
}
?>
