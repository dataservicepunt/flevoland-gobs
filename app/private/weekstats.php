<style>
.label {
  padding: 4px;
  border-radius: 2px;
  color: #333;
  font-weight: 100;
  font-size: 12px;
}
.label.--yellow {
  background: #FBB907;
}
.label.--green {
  background: #65B32E;
  color: white;
}
.label.--red {
  background: #dc3545;
  color: white;
}
</style>
<?php
  $rs = json_decode(file_get_contents("https://sms.flevowegen.nl/api/aanmeldingen/"), true);

  $wegen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_wegen.json"), true);
  $sluizen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_sluizen.json"), true);
  $bruggen = json_decode(file_get_contents(__DIR__ . "/mapping_from_specs/mapping_bruggen.json"), true);

  function printObjectLabel($object_id) {
    global $wegen, $sluizen, $bruggen;
    if (!empty($wegen[$object_id]))
      $object = $wegen[$object_id]["communicatie_naam"];
    else if (!empty($sluizen[$object_id]))
      $object = $sluizen[$object_id]["communicatie_naam"];
    else if (!empty($bruggen[$object_id]))
      $object = $bruggen[$object_id]["communicatie_naam"];
    else
      $object = "onbekend";
    ?>
      <span class="label <?php echo $object === "onbekend" ? "--red" : "--yellow"; ?>">
        <?php echo $object; ?>
      </span>
    <?php
  }

  $logs = array_reverse($rs["week_by_week"]);
  foreach ($logs as $log) {
?>
  <div>
    <p style="font-size: 12px"><?php echo $log["datetime"]; ?></p>
    <p><?php echo $log["mutation"]; ?> <?php printObjectLabel($log["object"]); ?></p>
    <hr>
  </div>
<?php
  } // foreach
