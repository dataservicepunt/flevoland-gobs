<?php

class NotificationsStorage {

  private $_storageFilePath;

  public function __construct($config) {
    $this->_storageFilePath = $config["notificationsLogFilePath"];
    if (!file_exists($this->_storageFilePath)) {
      copy("{$this->_storageFilePath}.dist", $this->_storageFilePath);
    }
  }

  /**
   * Get notifications from file.
   */
  public function get() {
    $notifications = json_decode(file_get_contents($this->_storageFilePath), true);
    return $notifications;
  }

  /**
   * Save notification to file.
   */
  public function save($request) { //FIXME Define attributes
    $notifications = $this->get();
    $notifications["notifications"][] = $request;
    file_put_contents($this->_storageFilePath, json_encode($notifications));
  }

}
