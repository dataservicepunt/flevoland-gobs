<?php

class SubscriptionsLogStorage {

  private $_pdo;

  public function __construct($pdo) {
    $this->_pdo = $pdo;
  }

  /**
   * Get subscriptions logs.
   */
  public function get() {
    $sql = "
      SELECT
        telefoonnummer,
        objecten,
        datetime
      FROM subscriptions_log
    ";
    $rs = [];
    foreach ($this->_pdo->query($sql, PDO::FETCH_ASSOC) as $sub) {
      $sub["objecten"] = count(explode(",", $sub["objecten"]));
      $sub["telefoonnummer"] = substr($sub["telefoonnummer"], -3);
      $rs[] = $sub;
    }
    return $rs;
  }

  /**
   * Save subscriptionslog.
   */
  public function save($telefoonnummer, $objecten, $datetime) {
    $stmt = $this->_pdo->prepare("
      INSERT INTO subscriptions_log (telefoonnummer, objecten, datetime)
      VALUES (:telefoonnummer, :objecten, :datetime)
    ");
    $stmt->execute([
      "telefoonnummer" => $telefoonnummer,
      "objecten" => implode(",", $objecten),
      "datetime" => $datetime
    ]);
  }

}
