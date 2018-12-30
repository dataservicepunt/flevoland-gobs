<?php

class SubscriptionsLogStorage {

  //private $_storageFilePath;
  private $_pdo;

  public function __construct($config, $pdo) {
    $this->_pdo = $pdo;
    //$this->_storageFilePath = $config["subscriptionsLogFilePath"];
    //if (!file_exists($this->_storageFilePath)) {
    //  copy("{$this->_storageFilePath}.dist", $this->_storageFilePath);
    //}
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
    //$subscriptionsLog = $this->get();
    //$subscriptionsLog["subscriptions"][] = [
    //  "telefoonnummer" => $telefoonnummer,
    //  "objecten" => $objecten,
    //  "datetime" => $datetime
    //];
    //file_put_contents($this->_storageFilePath, json_encode($subscriptionsLog));
  }

}
