<?php

class SubscriptionsStorage {

  //private $_storageFilePath;
  private $_pdo;

  public function __construct($config, $pdo) {
    //$this->_storageFilePath = $config["subscriptionsFilePath"];
    //if (!file_exists($this->_storageFilePath)) {
    //  copy("{$this->_storageFilePath}.dist", $this->_storageFilePath);
    //}
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

    //$subscriptions = json_decode(file_get_contents($this->_storageFilePath), true);
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

    //$subscriptions = $this->get();
    //$telefoonnummers = [];
    //foreach ($objecten as $object) {
    // foreach ($subscriptions["subscriptions"] as $telefoonnummer => $objecten) {
    //    if (in_array($object, $objecten)) {
    //      $telefoonnummers[$telefoonnummer] = true;
    //    }
    //  }
    //}
    //return array_keys($telefoonnummers);
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
    //$subscriptions = $this->get();
    //$counts = [];
    //foreach ($subscriptions["subscriptions"] as $telefoonnummer => $objecten) {
    //  foreach ($objecten as $object) {
    //    $counts[$object]++;
    //  }
    //}
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
    //$subscriptions = $this->get();
    //$subscriptions["subscriptions"][$telefoonnummer] = $objecten;
    //file_put_contents($this->_storageFilePath, json_encode($subscriptions));
  }

}
