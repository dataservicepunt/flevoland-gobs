<?php

class SubscriptionsLogStorage {

  private $_storageFilePath;

  public function __construct($config) {
    $this->_storageFilePath = $config["subscriptionsLogFilePath"];
    if (!file_exists($this->_storageFilePath)) {
      copy("{$this->_storageFilePath}.dist", $this->_storageFilePath);
    }
  }

  /**
   * Get subscriptionslog from file.
   */
  public function get() {
    $subscriptionsLog = json_decode(file_get_contents($this->_storageFilePath), true);
    return $subscriptionsLog;
  }

  /**
   * Save subscriptionslog to file.
   */
  public function save($telefoonnummer, $objecten, $datetime) {
    $subscriptionsLog = $this->get();
    $subscriptionsLog["subscriptions"][] = [
      "telefoonnummer" => $telefoonnummer,
      "objecten" => $objecten,
      "datetime" => $datetime
    ];
    file_put_contents($this->_storageFilePath, json_encode($subscriptionsLog));
  }

}
