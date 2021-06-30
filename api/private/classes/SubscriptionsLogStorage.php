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
   * Get subscriptions mutations by week.
   */
  public function getWeekByWeek() {
    $sql = "
      SELECT
        telefoonnummer,
        objecten,
        datetime
      FROM subscriptions_log
      ORDER BY datetime
    ";
    $logs = [];
    $telefoonnummers = [];
    $objecten = [];
    foreach ($this->_pdo->query($sql, PDO::FETCH_ASSOC) as $log) {
      $log["objecten"] = explode(",", $log["objecten"]);

      if (isset($telefoonnummers[$log["telefoonnummer"]])) {
        $additions = array_diff($log["objecten"], $telefoonnummers[$log["telefoonnummer"]]);
        $deletions = array_diff($telefoonnummers[$log["telefoonnummer"]], $log["objecten"]);
      } else {
        $additions = $log["objecten"];
        $deletions = [];
      }

      $telefoonnummers[$log["telefoonnummer"]] = $log["objecten"];

      foreach ($additions as $object) {
        $logs[] = [
          "datetime" => $log["datetime"],
          "object" => $object,
          "mutation" => "aanmelding"
        ];
      }

      foreach ($deletions as $object) {
        $logs[] = [
          "datetime" => $log["datetime"],
          "object" => $object,
          "mutation" => "afmelding"
        ];
      }
    }
    return $logs;
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
