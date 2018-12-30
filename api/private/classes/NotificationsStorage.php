<?php

class NotificationsStorage {

  //private $_storageFilePath;
  private $_pdo;

  public function __construct($config, $pdo) {
    $this->_pdo = $pdo;
    //$this->_storageFilePath = $config["notificationsLogFilePath"];
    //if (!file_exists($this->_storageFilePath)) {
    //  copy("{$this->_storageFilePath}.dist", $this->_storageFilePath);
    //}
  }

  /**
   * Get notifications from file.
   */
  public function get() {
    $sql = "
      SELECT
        datetime,
        smsText,
        smsLength,
        objecten,
        senderId
      FROM
        notifications
    ";
    $notifications = [];
    foreach ($this->_pdo->query($sql) as $notification) {
      $notifications[] = [
        "datetime" => $notification["datetime"],
        "smsText" => $notification["smsText"],
        "smsLength" => $notification["smsLength"],
        "objecten" => explode(",", $notification["objecten"]),
        "senderId" => $notification["senderId"]
      ];
    }
    return [
      "notifications" => $notifications
    ];
    //$notifications = json_decode(file_get_contents($this->_storageFilePath), true);
  }

  /**
   * Save notification to file.
   */
  public function save($datetime, $smsText, $smsLength, $objecten, $senderId) {
    $sql = "
      INSERT INTO notifications (datetime, smsText, smsLength, objecten, senderId)
      VALUES (:datetime, :smsText, :smsLength, :objecten, :senderId)
    ";
    $stmt = $this->_pdo->prepare($sql);
    $stmt->execute([
      "datetime" => $datetime,
      "smsText" => $smsText,
      "smsLength" => $smsLength,
      "objecten" => implode(",", $objecten),
      "senderId" => $senderId
    ]);
    //$notifications = $this->get();
    //$notifications["notifications"][] = $request;
    //file_put_contents($this->_storageFilePath, json_encode($notifications));
  }

}
