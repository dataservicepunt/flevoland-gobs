<?php

class NotificationsStorage {

  private $_pdo;

  public function __construct($pdo) {
    $this->_pdo = $pdo;
  }

  /**
   * Get notifications.
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
  }

  /**
   * Save notification.
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
  }

}
