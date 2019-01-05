<?php

class SubscriptionsLogStorage {

  private $_pdo;

  public function __construct($pdo) {
    $this->_pdo = $pdo;
  }

  /**
   * Save subscriptionslog to file.
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
