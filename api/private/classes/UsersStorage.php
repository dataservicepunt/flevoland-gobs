<?php

class UsersStorage {

  private $_pdo;

  public function __construct($pdo) {
    $this->_pdo = $pdo;
  }

  /**
   * Get userConfig by $username and $password.
   */
  public function get($username, $password) {
    if (empty($username) || empty($password)) {
      return null;
    }

    $stmt = $this->_pdo->prepare("
      SELECT
        id,
        passwordHash,
        hashAlgorithm,
        accessToken
      FROM users
      WHERE username = :username
      LIMIT 1
    ");
    $stmt->execute([
      "username" => $username
    ]);
    $userConfig = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($userConfig)) {
      return null;
    }

    if (hash($userConfig["hashAlgorithm"], $password)
        !== strtolower($userConfig["passwordHash"])) {
      return null;
    }

    return $userConfig;
  }

}
