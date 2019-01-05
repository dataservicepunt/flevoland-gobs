<?php

class SubscriptionsStorage {

  private $_pdo;

  public function __construct($pdo) {
    $this->_pdo = $pdo;
  }

  /**
   * Get subscriptions from file.
   */
  public function get() {
    $sql = "
      SELECT
        telefoonnummer,
        GROUP_CONCAT(object) AS objecten
      FROM subscriptions
      GROUP BY telefoonnummer
    ";
    $subscriptions = [];
    foreach ($this->_pdo->query($sql, PDO::FETCH_ASSOC) as $subscription) {
      $subscriptions[$subscription["telefoonnummer"]] = explode(",", $subscription["objecten"]);
    }
    return [
      "subscriptions" => $subscriptions
    ];
  }

  /**
   * Get telefoonnummers for given objects.
   */
  public function getByObjects($objecten) {
    $params = array_combine(
      array_map(
        function ($id) { return ":object_{$id}"; },
        array_keys($objecten)
      ),
      $objecten
    );
    $sql = "
      SELECT DISTINCT(telefoonnummer) AS telefoonnummer
      FROM subscriptions
      WHERE object IN (" . implode(",", array_keys($params)) . ")
    ";
    $stmt = $this->_pdo->prepare($sql);
    $stmt->execute($params);
    $telefoonnummers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $telefoonnummers;
  }

  /**
   * Get object subscription counts.
   */
  public function getCounts() {
    $sql = "
      SELECT
        object,
        COUNT(telefoonnummer) AS subscriptionCount
      FROM subscriptions
      GROUP BY object
    ";
    $counts = [];
    foreach ($this->_pdo->query($sql, PDO::FETCH_ASSOC) as $object) {
      $counts[$object["object"]] = $object["subscriptionCount"];
    }
    return $counts;
  }

  /**
   * Save subscriptions to file.
   */
  public function save($telefoonnummer, $objecten) {
    $this->_pdo->beginTransaction();
    $stmt = $this->_pdo->prepare("
      DELETE FROM subscriptions
      WHERE telefoonnummer = :telefoonnummer
    ");
    $stmt->execute([
      "telefoonnummer" => $telefoonnummer
    ]);
    $stmt = $this->_pdo->prepare("
      INSERT INTO subscriptions (telefoonnummer, object)
      VALUES (:telefoonnummer, :object)
    ");
    foreach ($objecten as $object) {
      $stmt->execute([
        "telefoonnummer" => $telefoonnummer,
        "object" => $object
      ]);
    }
    $this->_pdo->commit();
  }

}
